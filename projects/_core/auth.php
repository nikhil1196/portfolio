<?php
/** Session auth shared across all demo projects. */

function auth_user(): ?int { return $_SESSION['uid'] ?? null; }
function auth_name(): string { return $_SESSION['uname'] ?? ''; }

function auth_require(array $app): void {
    if (!auth_user()) redirect('login.php');
}

function auth_login(array $app, string $email, string $pass): bool {
    $u = q1($app, 'SELECT * FROM users WHERE email = ?', [$email]);
    if ($u && password_verify($pass, $u['password'])) {
        session_regenerate_id(true);
        $_SESSION['uid'] = $u['id'];
        $_SESSION['uname'] = $u['name'];
        return true;
    }
    return false;
}

function auth_logout(): void {
    $_SESSION = [];
    session_destroy();
}

/** Shared login page — pass $app + optional $error. */
function render_login(array $app, string $error = ''): void {
    $accent = $app['accent'] ?? '#6c5ce7'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login — <?= h($app['name']) ?></title>
<link rel="stylesheet" href="../_core/assets/admin.css">
<style>:root{--acc:<?= h($accent) ?>}</style>
</head>
<body class="login-page">
    <form class="login-card" method="POST">
        <div class="login-logo" style="background:<?= h($accent) ?>"><?= h($app['icon'] ?? '◆') ?></div>
        <h1><?= h($app['name']) ?></h1>
        <p class="login-sub">Sign in to your admin panel</p>
        <?php if ($error): ?><div class="alert alert-err"><?= h($error) ?></div><?php endif; ?>
        <?= csrf_field() ?>
        <label>Email<input type="email" name="email" required autofocus placeholder="admin@demo.local"></label>
        <label>Password<input type="password" name="password" required placeholder="admin123"></label>
        <button class="btn btn-acc btn-block" type="submit">Sign In</button>
        <p class="login-hint">Demo credentials: <code>admin@demo.local</code> / <code>admin123</code></p>
    </form>
</body>
</html><?php exit;
}
