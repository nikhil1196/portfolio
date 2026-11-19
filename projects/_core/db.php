<?php
/** PDO connection + auto migration/seed. SQLite default, MySQL via config. */

function db_connect(array $app): PDO {
    $opts = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    if (($app['db_driver'] ?? 'sqlite') === 'mysql') {
        return new PDO($app['db_dsn'], $app['db_user'] ?? 'root', $app['db_pass'] ?? '', $opts);
    }
    $dataDir = $app['dir'] . '/data';
    if (!is_dir($dataDir)) {
        mkdir($dataDir, 0777, true);
        // keep the sqlite file out of the web root's reach via Apache
        file_put_contents($dataDir . '/.htaccess', "Require all denied\n");
    }
    $pdo = new PDO('sqlite:' . $dataDir . '/app.sqlite', null, null, $opts);
    $pdo->exec('PRAGMA foreign_keys = ON');
    return $pdo;
}

/** Runs schema.sql + seed.sql once, tracked in _meta table. */
function db_maybe_migrate(array $app): void {
    $db = $app['db'];
    try {
        $db->query('SELECT 1 FROM _meta LIMIT 1');
        return; // already initialised
    } catch (Throwable $e) {}
    foreach (['schema.sql', 'seed.sql'] as $file) {
        $path = $app['dir'] . '/' . $file;
        if (is_file($path)) db_run_file($db, $path);
    }
}

function db_run_file(PDO $db, string $path): void {
    $sql = file_get_contents($path);
    // split on ";" at end of line — keeps it safe for both sqlite & mysql
    foreach (preg_split('/;\s*[\r\n]+/', $sql) as $stmt) {
        $stmt = trim($stmt);
        if ($stmt !== '') $db->exec($stmt);
    }
}
