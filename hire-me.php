<?php
require_once __DIR__ . '/includes/config.php';
$pageTitle   = t('nav.hire');
$currentPage = 'hire-me.php';
$pageDesc    = t('meta.desc.hire');
include 'includes/header.php';
?>

<section class="page-banner">
    <div class="container">
        <h1><?= t('ban.hire.t1') ?> <span class="grad"><?= t('ban.hire.t2') ?></span></h1>
        <p class="breadcrumb"><a href="index.php"><?= t('crumb.home') ?></a> / <?= t('nav.hire') ?></p>
        <p class="banner-sub"><?= t('ban.hire.sub') ?></p>
    </div>
</section>

<!-- ============ WHY HIRE ============ -->
<section class="section" style="padding-top:24px;">
    <div class="container">
        <div class="hire-hero reveal" style="margin-bottom:56px;">
            <span class="section-tag"><?= t('hire.why.tag') ?></span>
            <h2 class="section-title"><?= t('hire.why.t1') ?> <span class="grad"><?= t('hire.why.t2') ?></span></h2>
            <p class="section-sub"><?= t('hire.why.sub') ?></p>
        </div>
        <div class="grid-3">
            <?php foreach (ta('hire.cards') as $i => $c): ?>
                <div class="card reveal" data-delay="<?= $i + 1 ?>">
                    <div class="card-icon"><?= $c['icon'] ?></div>
                    <h3><?= $c['t'] ?></h3>
                    <p><?= $c['p'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ ENGAGEMENT MODELS ============ -->
<section class="section section-alt">
    <div class="container">
        <div class="section-head reveal">
            <span class="section-tag"><?= t('hire.eng.tag') ?></span>
            <h2 class="section-title"><?= t('hire.eng.t1') ?> <span class="grad"><?= t('hire.eng.t2') ?></span></h2>
            <p class="section-sub"><?= t('hire.eng.sub') ?></p>
        </div>
        <div class="grid-3">
            <?php foreach (ta('plans') as $i => $plan): ?>
                <div class="card pricing-card <?= !empty($plan['featured']) ? 'featured' : '' ?> reveal" data-delay="<?= $i + 1 ?>">
                    <?php if (!empty($plan['featured'])): ?><span class="plan-tag"><?= e($plan['tag']) ?></span><?php endif; ?>
                    <span class="pricing-name"><?= e($plan['name']) ?></span>
                    <div class="pricing-price"><?= e($plan['price']) ?> <small><?= e($plan['per']) ?></small></div>
                    <p class="pricing-desc"><?= e($plan['desc']) ?></p>
                    <ul>
                        <?php foreach ($plan['features'] as $f): ?><li><?= $f ?></li><?php endforeach; ?>
                    </ul>
                    <a href="contact.php" class="btn <?= !empty($plan['featured']) ? 'btn-primary' : 'btn-outline' ?> btn-block"><?= e($plan['btn']) ?></a>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="reveal" style="text-align:center; color:var(--text-muted); font-size:.85rem; margin-top:28px;">
            <?= t('plans.note') ?> <a href="contact.php" style="color:var(--accent-2)"><?= t('plans.note.link') ?></a> <?= t('plans.note.end') ?>
        </p>
    </div>
</section>

<!-- ============ PROCESS ============ -->
<section class="section">
    <div class="container">
        <div class="section-head reveal">
            <span class="section-tag"><?= t('hire.gs.tag') ?></span>
            <h2 class="section-title"><?= t('hire.gs.t1') ?> <span class="grad"><?= t('hire.gs.t2') ?></span></h2>
        </div>
        <div class="process-steps">
            <?php foreach (ta('steps') as $i => $s): ?>
                <div class="process-step card reveal" data-delay="<?= $i + 1 ?>">
                    <h3><?= $s['t'] ?></h3>
                    <p><?= $s['p'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ FAQ ============ -->
<section class="section section-alt">
    <div class="container">
        <div class="section-head reveal">
            <span class="section-tag"><?= t('faq.tag') ?></span>
            <h2 class="section-title"><?= t('faq.t1') ?> <span class="grad"><?= t('faq.t2') ?></span></h2>
        </div>
        <div class="faq">
            <?php foreach (ta('faqs') as $faq): ?>
                <div class="faq-item reveal">
                    <button class="faq-q"><?= $faq['q'] ?><span class="faq-icon">+</span></button>
                    <div class="faq-a"><p><?= $faq['a'] ?></p></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ CTA ============ -->
<section class="section" style="padding-top:0;">
    <div class="container">
        <div class="cta-band reveal">
            <h2><?= t('cta.hire.t') ?></h2>
            <p><?= t('cta.hire.p') ?></p>
            <div class="hero-actions" style="justify-content:center;">
                <a href="contact.php" class="btn btn-primary"><?= t('cta.hire.b1') ?></a>
                <a href="mailto:<?= e(SITE_EMAIL) ?>" class="btn btn-outline"><?= e(SITE_EMAIL) ?></a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
