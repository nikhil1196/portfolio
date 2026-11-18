<?php
require_once __DIR__ . '/includes/config.php';
$pageTitle   = t('nav.about') . ' ' . t('ban.about.t2');
$currentPage = 'about.php';
$pageDesc    = t('meta.desc.about');
include 'includes/header.php';
?>

<section class="page-banner">
    <div class="container">
        <h1><?= t('ban.about.t1') ?> <span class="grad"><?= t('ban.about.t2') ?></span></h1>
        <p class="breadcrumb"><a href="index.php"><?= t('crumb.home') ?></a> / <?= t('nav.about') ?></p>
        <p class="banner-sub"><?= t('ban.about.sub') ?></p>
    </div>
</section>

<!-- ============ BIO ============ -->
<section class="section" style="padding-top:20px;">
    <div class="container">
        <div class="about-grid">
            <div class="about-photo reveal">
                <div class="about-photo-frame">
                    <div class="avatar-circle">NA</div>
                    <span class="avatar-note"><?= t('about.avatar.note') ?></span>
                </div>
                <div class="about-facts">
                    <div class="about-fact"><span class="k"><?= t('about.fact.name') ?></span> <?= e(SITE_NAME) ?></div>
                    <div class="about-fact"><span class="k"><?= t('about.fact.role') ?></span> <?= t('about.fact.role.v') ?></div>
                    <div class="about-fact"><span class="k"><?= t('about.fact.location') ?></span> <?= e(SITE_LOCATION) ?></div>
                    <div class="about-fact"><span class="k"><?= t('about.fact.email') ?></span> <a href="mailto:<?= e(SITE_EMAIL) ?>" style="color:var(--accent-2)"><?= e(SITE_EMAIL) ?></a></div>
                    <div class="about-fact"><span class="k"><?= t('about.fact.phone') ?></span> <?= e(SITE_PHONE) ?></div>
                    <div class="about-fact"><span class="k"><?= t('about.fact.status') ?></span> <span style="color:#28c840"><?= t('about.fact.status.v') ?></span></div>
                </div>
            </div>

            <div class="about-text">
                <h3 class="reveal"><?= t('about.h3') ?></h3>
                <p class="reveal"><?= t('about.p1') ?></p>
                <p class="reveal"><?= t('about.p2') ?></p>
                <p class="reveal"><?= t('about.p3') ?></p>

                <div class="reveal" style="margin-top:28px;">
                    <h4 style="margin-bottom:16px; font-family:var(--font-head);"><?= t('about.comp') ?></h4>
                    <?php foreach (ta('skills') as $skill): ?>
                        <div class="skill-bar">
                            <div class="skill-bar-head"><span><?= $skill[0] ?></span><span><?= $skill[1] ?>%</span></div>
                            <div class="skill-bar-track"><div class="skill-bar-fill" data-level="<?= $skill[1] ?>"></div></div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="hero-actions reveal" style="margin-top:34px;">
                    <a href="hire-me.php" class="btn btn-primary"><?= t('about.btn.hire') ?></a>
                    <a href="contact.php" class="btn btn-outline"><?= t('about.btn.contact') ?></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ DETAILED SKILLS ============ -->
<section class="section section-alt">
    <div class="container">
        <div class="section-head reveal">
            <span class="section-tag"><?= t('skills.det.tag') ?></span>
            <h2 class="section-title"><?= t('skills.det.t1') ?> <span class="grad"><?= t('skills.det.t2') ?></span></h2>
            <p class="section-sub"><?= t('skills.det.sub') ?></p>
        </div>
        <div class="grid-3">
            <?php foreach (ta('skill.groups') as $i => $g): ?>
                <div class="card reveal" data-delay="<?= ($i % 3) + 1 ?>">
                    <h3 style="margin-bottom:16px;"><?= $g['t'] ?></h3>
                    <div class="chips">
                        <?php foreach ($g['items'] as $item): ?><span class="chip"><?= e($item) ?></span><?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ EXPERIENCE ============ -->
<section class="section">
    <div class="container">
        <div class="section-head reveal">
            <span class="section-tag"><?= t('exp.tag') ?></span>
            <h2 class="section-title"><?= t('exp.t1') ?> <span class="grad"><?= t('exp.t2') ?></span></h2>
        </div>

        <div class="timeline">
            <?php foreach (ta('timeline') as $job): ?>
                <div class="timeline-item reveal">
                    <span class="timeline-date"><?= e($job['date']) ?></span>
                    <div class="timeline-card">
                        <h3 class="timeline-role"><?= e($job['role']) ?></h3>
                        <div class="timeline-org"><?= e($job['org']) ?></div>
                        <ul>
                            <?php foreach ($job['bullets'] as $b): ?><li><?= $b ?></li><?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ EDUCATION & AWARDS ============ -->
<section class="section section-alt">
    <div class="container">
        <div class="grid-2">
            <div class="reveal">
                <div class="section-head" style="text-align:left; margin-bottom:28px;">
                    <span class="section-tag"><?= t('edu.tag') ?></span>
                    <h2 class="section-title" style="font-size:1.7rem;"><?= t('edu.t1') ?> <span class="grad"><?= t('edu.t2') ?></span></h2>
                </div>
                <div class="timeline-card">
                    <h3 class="timeline-role"><?= t('edu.role') ?></h3>
                    <div class="timeline-org"><?= t('edu.org') ?></div>
                    <ul>
                        <li><?= t('edu.b1') ?></li>
                        <li><?= t('edu.b2') ?></li>
                    </ul>
                </div>
                <div class="timeline-card" style="margin-top:18px;">
                    <h3 class="timeline-role"><?= t('exp2.role') ?></h3>
                    <div class="chips" style="margin-top:14px;">
                        <?php foreach (ta('exp2.chips') as $c): ?><span class="chip"><?= $c ?></span><?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="reveal" data-delay="2">
                <div class="section-head" style="text-align:left; margin-bottom:28px;">
                    <span class="section-tag"><?= t('awd.tag') ?></span>
                    <h2 class="section-title" style="font-size:1.7rem;"><?= t('awd.t1') ?> <span class="grad"><?= t('awd.t2') ?></span></h2>
                </div>
                <?php foreach (ta('awards') as $a): ?>
                    <div class="award-item">
                        <span class="award-icon"><?= $a['icon'] ?></span>
                        <div><strong><?= $a['t'] ?></strong><span><?= $a['s'] ?></span></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ============ CTA ============ -->
<section class="section" style="padding-top:0;">
    <div class="container">
        <div class="cta-band reveal">
            <h2><?= t('cta.a.t') ?></h2>
            <p><?= t('cta.a.p') ?></p>
            <div class="hero-actions" style="justify-content:center;">
                <a href="portfolio.php" class="btn btn-primary"><?= t('cta.a.b1') ?></a>
                <a href="contact.php" class="btn btn-outline"><?= t('cta.a.b2') ?></a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
