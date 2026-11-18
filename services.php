<?php
require_once __DIR__ . '/includes/config.php';
$pageTitle   = t('nav.services');
$currentPage = 'services.php';
$pageDesc    = t('meta.desc.services');
include 'includes/header.php';
?>

<section class="page-banner">
    <div class="container">
        <h1><?= t('ban.services.t1') ?> <span class="grad"><?= t('ban.services.t2') ?></span></h1>
        <p class="breadcrumb"><a href="index.php"><?= t('crumb.home') ?></a> / <?= t('nav.services') ?></p>
        <p class="banner-sub"><?= t('ban.services.sub') ?></p>
    </div>
</section>

<section class="section" style="padding-top:24px;">
    <div class="container">
        <div class="grid-3">
            <?php foreach (ta('svc') as $i => $s): ?>
                <div class="card reveal" data-delay="<?= ($i % 3) + 1 ?>">
                    <div class="card-icon"><?= $s['icon'] ?></div>
                    <h3><?= $s['t'] ?></h3>
                    <p><?= $s['p'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ PROCESS ============ -->
<section class="section section-alt">
    <div class="container">
        <div class="section-head reveal">
            <span class="section-tag"><?= t('svc.proc.tag') ?></span>
            <h2 class="section-title"><?= t('svc.proc.t1') ?> <span class="grad"><?= t('svc.proc.t2') ?></span></h2>
            <p class="section-sub"><?= t('svc.proc.sub') ?></p>
        </div>
        <div class="process-steps">
            <?php foreach (ta('proc') as $i => $step): ?>
                <div class="process-step card reveal" data-delay="<?= $i + 1 ?>">
                    <h3><?= $step['t'] ?></h3>
                    <p><?= $step['p'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ CTA ============ -->
<section class="section" style="padding-top:0;">
    <div class="container">
        <div class="cta-band reveal">
            <h2><?= t('cta.s.t') ?></h2>
            <p><?= t('cta.s.p') ?></p>
            <a href="hire-me.php" class="btn btn-primary"><?= t('cta.s.b') ?></a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
