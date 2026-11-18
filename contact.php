<?php
require_once __DIR__ . '/includes/config.php';
$pageTitle   = t('nav.contact');
$currentPage = 'contact.php';
$pageDesc    = t('meta.desc.contact');
include 'includes/header.php';
?>

<section class="page-banner">
    <div class="container">
        <h1><?= t('ban.contact.t1') ?> <span class="grad"><?= t('ban.contact.t2') ?></span></h1>
        <p class="breadcrumb"><a href="index.php"><?= t('crumb.home') ?></a> / <?= t('nav.contact') ?></p>
        <p class="banner-sub"><?= t('ban.contact.sub') ?></p>
    </div>
</section>

<section class="section" style="padding-top:24px;">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info-card reveal">
                <h3><?= t('con.info.h3') ?></h3>
                <p><?= t('con.info.p') ?></p>

                <div class="contact-line">
                    <span class="icon">&#64;</span>
                    <div>
                        <strong><?= t('con.l.email') ?></strong>
                        <a href="mailto:<?= e(SITE_EMAIL) ?>"><?= e(SITE_EMAIL) ?></a>
                    </div>
                </div>
                <div class="contact-line">
                    <span class="icon">&#9990;</span>
                    <div>
                        <strong><?= t('con.l.phone') ?></strong>
                        <a href="tel:<?= e(SITE_PHONE_LINK) ?>"><?= e(SITE_PHONE) ?></a>
                    </div>
                </div>
                <div class="contact-line">
                    <span class="icon">&#9873;</span>
                    <div>
                        <strong><?= t('con.l.loc') ?></strong>
                        <?= e(SITE_LOCATION) ?>
                    </div>
                </div>
                <div class="contact-line" style="margin-bottom:0;">
                    <span class="icon">&#9719;</span>
                    <div>
                        <strong><?= t('con.l.avail') ?></strong>
                        <span style="color:#28c840"><?= t('con.l.avail.v') ?></span>
                    </div>
                </div>
            </div>

            <div class="form-card reveal" data-delay="2">
                <div class="form-success"></div>
                <div class="form-error-alert"></div>
                <form id="contactForm" action="contact-handler.php" method="POST" novalidate
                      data-sending="<?= e(t('f.sending')) ?>" data-net-error="<?= e(t('form.err.net')) ?>">
                    <input type="text" name="website" class="hp-field" tabindex="-1" autocomplete="off" aria-hidden="true">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="cfName"><?= t('f.name') ?> <span class="req">*</span></label>
                            <input type="text" id="cfName" name="name" class="form-control" placeholder="<?= e(t('f.ph.name')) ?>" required>
                            <div class="form-error-msg"><?= t('f.e.name') ?></div>
                        </div>
                        <div class="form-group">
                            <label for="cfEmail"><?= t('f.email') ?> <span class="req">*</span></label>
                            <input type="email" id="cfEmail" name="email" class="form-control" placeholder="<?= e(t('f.ph.email')) ?>" required>
                            <div class="form-error-msg"><?= t('f.e.email') ?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cfSubject"><?= t('f.subject') ?> <span class="req">*</span></label>
                        <input type="text" id="cfSubject" name="subject" class="form-control" placeholder="<?= e(t('f.ph.subject')) ?>" required>
                        <div class="form-error-msg"><?= t('f.e.subject') ?></div>
                    </div>
                    <div class="form-group">
                        <label for="cfBudget"><?= t('f.budget') ?></label>
                        <select id="cfBudget" name="budget" class="form-control">
                            <option value=""><?= t('f.budget.opt0') ?></option>
                            <option><?= t('f.budget.1') ?></option>
                            <option><?= t('f.budget.2') ?></option>
                            <option><?= t('f.budget.3') ?></option>
                            <option><?= t('f.budget.4') ?></option>
                            <option><?= t('f.budget.5') ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cfMessage"><?= t('f.message') ?> <span class="req">*</span></label>
                        <textarea id="cfMessage" name="message" class="form-control" placeholder="<?= e(t('f.ph.msg')) ?>" required></textarea>
                        <div class="form-error-msg"><?= t('f.e.msg') ?></div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" id="cfSubmit"><?= t('f.submit') ?></button>
                    <p style="font-size:.78rem; color:var(--text-muted); margin-top:14px; text-align:center;">
                        <?= t('f.pref') ?> <a href="mailto:<?= e(SITE_EMAIL) ?>" style="color:var(--accent-2)"><?= e(SITE_EMAIL) ?></a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
