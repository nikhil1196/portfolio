<?php
/**
 * Shared bootstrap for all portfolio demo projects.
 * Each project calls:  $app = app_boot(__DIR__);
 * which loads its config.php, starts the session,
 * connects the DB and runs schema/seed on first use.
 */
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/view.php';
require_once __DIR__ . '/crud.php';

function app_boot(string $dir): array {
    $cfg = require $dir . '/config.php';
    if (session_status() === PHP_SESSION_NONE) session_start();
    date_default_timezone_set($cfg['tz'] ?? 'Asia/Kolkata');
    $app = ['dir' => $dir] + $cfg;
    $app['db'] = db_connect($app);
    db_maybe_migrate($app);
    return $app;
}
