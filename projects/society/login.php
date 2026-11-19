<?php
require_once dirname(__DIR__) . '/_core/boot.php';
$app = app_boot(__DIR__);
if (is_post()) {
    csrf_check();
    if (auth_login($app, postv('email'), postv('password'))) redirect('index.php');
    render_login($app, 'Invalid email or password.');
}
render_login($app);
