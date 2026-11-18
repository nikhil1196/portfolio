<?php
require_once __DIR__ . '/config.php';
$pageTitle    = $pageTitle ?? t('nav.home');
$currentPage  = $currentPage ?? basename($_SERVER['PHP_SELF']);
$pageDesc     = $pageDesc ?? t('meta.desc.home');
?>
<!DOCTYPE html>
<html lang="<?= e(SITE_LANG) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        // Apply saved theme before first paint (prevents flash)
        (function () {
            var t = localStorage.getItem('site-theme')
                || (window.matchMedia && matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark');
            document.documentElement.dataset.theme = t;
        })();
    </script>
    <title><?= e($pageTitle) ?> | <?= e(SITE_NAME) ?> — <?= e(SITE_DOMAIN) ?></title>
    <meta name="description" content="<?= e($pageDesc) ?>">
    <meta property="og:title" content="<?= e($pageTitle) ?> | <?= e(SITE_NAME) ?>">
    <meta property="og:description" content="<?= e($pageDesc) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= e(SITE_URL) ?>">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%236c5ce7'/><text x='50' y='68' font-size='52' font-family='monospace' font-weight='bold' fill='white' text-anchor='middle'>NA</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="page-loader" id="pageLoader"><span class="loader-bracket">&lt;</span><span class="loader-text">NA</span><span class="loader-bracket">/&gt;</span></div>

    <header class="site-header" id="siteHeader">
        <div class="container nav-container">
            <a href="index.php" class="brand">
                <span class="brand-mark">&lt;NA /&gt;</span>
                <span class="brand-text">nikhilagrawal<span class="accent">.tech</span></span>
            </a>

            <nav class="main-nav" id="mainNav" aria-label="Primary">
                <ul>
                    <?php foreach ($NAV_ITEMS as $tkey => $file): ?>
                        <li><a href="<?= $file ?>" class="<?= is_active($file, $currentPage) ?>"><?= e(t($tkey)) ?></a></li>
                    <?php endforeach; ?>
                    <li class="nav-tools">
                        <button class="icon-btn" id="themeToggle" aria-label="<?= e(t('a11y.theme')) ?>" title="<?= e(t('a11y.theme')) ?>">
                            <svg class="icon-sun" viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M4.9 4.9l1.4 1.4m11.4 11.4 1.4 1.4M2 12h2m16 0h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
                            <svg class="icon-moon" viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg>
                        </button>
                        <select class="lang-select" id="langSelect" aria-label="<?= e(t('a11y.lang')) ?>" title="<?= e(t('a11y.lang')) ?>">
                            <?php foreach ($AVAILABLE_LANGS as $code => $name): ?>
                                <option value="<?= e($code) ?>" <?= $code === SITE_LANG ? 'selected' : '' ?>><?= e($name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </li>
                    <li class="nav-cta"><a href="hire-me.php" class="btn btn-sm btn-primary"><?= e(t('nav.hire')) ?></a></li>
                </ul>
            </nav>

            <button class="nav-toggle" id="navToggle" aria-label="<?= e(t('a11y.nav')) ?>" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
    </header>

    <main id="main">
