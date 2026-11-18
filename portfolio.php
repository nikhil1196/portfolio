<?php
require_once __DIR__ . '/includes/config.php';
$pageTitle   = t('nav.portfolio');
$currentPage = 'portfolio.php';
$pageDesc    = t('meta.desc.portfolio');
include 'includes/header.php';
// Project data lives in lang/*.php — edit there to add real links.
?>

<section class="page-banner">
    <div class="container">
        <h1><?= t('ban.portfolio.t1') ?> <span class="grad"><?= t('ban.portfolio.t2') ?></span></h1>
        <p class="breadcrumb"><a href="index.php"><?= t('crumb.home') ?></a> / <?= t('nav.portfolio') ?></p>
        <p class="banner-sub"><?= t('ban.portfolio.sub') ?></p>
    </div>
</section>

<section class="section" style="padding-top:24px;">
    <div class="container">
        <div class="filter-bar reveal">
            <?php foreach (ta('filters') as $f): ?>
                <button class="filter-btn <?= $f['key'] === 'all' ? 'active' : '' ?>" data-filter="<?= e($f['key']) ?>"><?= e($f['label']) ?></button>
            <?php endforeach; ?>
        </div>

        <div class="grid-3" id="projectGrid">
            <?php foreach (ta('projects') as $i => $p): ?>
                <div class="card project-card project-item reveal" data-category="<?= e($p['cat']) ?>" data-delay="<?= ($i % 3) + 1 ?>">
                    <div class="project-thumb" style="background:<?= e($p['bg']) ?>;"><?= e($p['thumb']) ?></div>
                    <div class="project-body">
                        <span class="project-cat"><?= e($p['cat_label']) ?></span>
                        <h3><?= e($p['title']) ?></h3>
                        <p><?= $p['desc'] ?></p>
                        <div class="project-tags">
                            <?php foreach ($p['tags'] as $tg): ?><span><?= e($tg) ?></span><?php endforeach; ?>
                        </div>
                        <div class="project-links">
                            <a href="<?= e($p['link']) ?>"><?= t('proj.live') ?></a>
                            <a href="<?= e($p['github']) ?>"><?= t('proj.src') ?></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <p class="reveal" style="text-align:center; color:var(--text-muted); margin-top:36px; font-size:.9rem;">
            <?= t('port.note') ?> <a href="contact.php" style="color:var(--accent-2)"><?= t('port.note.link') ?></a> <?= t('port.note.end') ?>
        </p>
    </div>
</section>

<!-- ============ CTA ============ -->
<section class="section" style="padding-top:0;">
    <div class="container">
        <div class="cta-band reveal">
            <h2><?= t('cta.p.t') ?></h2>
            <p><?= t('cta.p.p') ?></p>
            <a href="hire-me.php" class="btn btn-primary"><?= t('cta.p.b') ?></a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
