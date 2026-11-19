<?php
/** Shared admin layout: sidebar + topbar + content area. */

function page_head(array $app, string $title): void {
    $cur = basename($_SERVER['PHP_SELF']); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= h($title) ?> — <?= h($app['name']) ?></title>
<link rel="stylesheet" href="../_core/assets/admin.css">
<style>:root{--acc:<?= h($app['accent'] ?? '#6c5ce7') ?>}</style>
</head>
<body class="admin">
<div class="shell">
    <aside class="sidebar">
        <a class="side-brand" href="index.php">
            <span class="side-icon" style="background:<?= h($app['accent'] ?? '#6c5ce7') ?>"><?= h($app['icon'] ?? '◆') ?></span>
            <span><?= h($app['name']) ?></span>
        </a>
        <nav class="side-nav">
            <?php foreach (($app['nav'] ?? []) as $item): ?>
                <a href="<?= h($item[1]) ?>" class="<?= $item[1] === $cur ? 'active' : '' ?>">
                    <span class="ni"><?= $item[2] ?? '•' ?></span><?= h($item[0]) ?>
                </a>
            <?php endforeach; ?>
        </nav>
        <div class="side-foot">
            <a href="../../portfolio.php" class="side-back">← Back to Portfolio</a>
        </div>
    </aside>
    <div class="main">
        <header class="topbar">
            <h1><?= h($title) ?></h1>
            <div class="topbar-right">
                <span class="topbar-user"><?= h(auth_name()) ?></span>
                <a class="btn btn-sm" href="logout.php">Logout</a>
            </div>
        </header>
        <main class="content">
        <?php foreach (flashes() as $f): ?>
            <div class="alert alert-<?= h($f[1]) ?>"><?= h($f[0]) ?></div>
        <?php endforeach; ?>
<?php
}

function page_foot(): void { ?>
        </main>
    </div>
</div>
<script src="../_core/assets/admin.js"></script>
</body>
</html><?php
}

function stat_card(string $label, $value, string $sub = ''): void { ?>
    <div class="stat-card">
        <div class="stat-label"><?= h($label) ?></div>
        <div class="stat-value"><?= $value ?></div>
        <?php if ($sub): ?><div class="stat-sub"><?= h($sub) ?></div><?php endif; ?>
    </div><?php
}

function card_open(string $title = '', string $extra = ''): void { ?>
    <div class="card">
        <?php if ($title || $extra): ?>
            <div class="card-head"><h2><?= h($title) ?></h2><div class="card-extra"><?= $extra ?></div></div>
        <?php endif; ?>
        <div class="card-body">
<?php }
function card_close(): void { ?></div></div><?php }
