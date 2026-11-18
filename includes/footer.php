<?php require_once __DIR__ . '/config.php'; ?>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col footer-about">
                    <a href="index.php" class="brand">
                        <span class="brand-mark">&lt;NA /&gt;</span>
                        <span class="brand-text">nikhilagrawal<span class="accent">.tech</span></span>
                    </a>
                    <p><?= t('footer.about') ?></p>
                    <div class="socials">
                        <a href="<?= e($SOCIALS['github']) ?>" target="_blank" rel="noopener" aria-label="GitHub">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M12 .5C5.65.5.5 5.65.5 12c0 5.08 3.29 9.39 7.86 10.91.58.11.79-.25.79-.55v-2.15c-3.2.7-3.87-1.36-3.87-1.36-.52-1.33-1.28-1.68-1.28-1.68-1.05-.72.08-.7.08-.7 1.16.08 1.77 1.19 1.77 1.19 1.03 1.77 2.7 1.26 3.36.96.1-.75.4-1.26.73-1.55-2.55-.29-5.23-1.28-5.23-5.68 0-1.26.45-2.28 1.19-3.09-.12-.29-.52-1.46.11-3.05 0 0 .97-.31 3.18 1.18a11 11 0 0 1 5.8 0c2.2-1.49 3.17-1.18 3.17-1.18.63 1.59.23 2.76.12 3.05.74.81 1.18 1.83 1.18 3.09 0 4.41-2.68 5.38-5.24 5.67.41.35.78 1.05.78 2.12v3.15c0 .3.2.67.8.55A11.51 11.51 0 0 0 23.5 12C23.5 5.65 18.35.5 12 .5z"/></svg>
                        </a>
                        <a href="<?= e($SOCIALS['linkedin']) ?>" target="_blank" rel="noopener" aria-label="LinkedIn">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M20.45 20.45h-3.55v-5.57c0-1.33-.03-3.04-1.85-3.04-1.86 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.41v1.56h.05a3.74 3.74 0 0 1 3.37-1.85c3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12zM7.12 20.45H3.56V9h3.56v11.45z"/></svg>
                        </a>
                        <a href="<?= e($SOCIALS['twitter']) ?>" target="_blank" rel="noopener" aria-label="Twitter / X">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M18.9 1.15h3.68l-8.04 9.19L24 22.85h-7.41l-5.8-7.58-6.64 7.58H.47l8.6-9.83L0 1.15h7.59l5.24 6.93 6.07-6.93zm-1.29 19.5h2.04L6.49 3.24H4.3l13.3 17.41z"/></svg>
                        </a>
                        <a href="<?= e($SOCIALS['stackoverflow']) ?>" target="_blank" rel="noopener" aria-label="Stack Overflow">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M18.99 21.42v-6.6h1.99v8.59H.83v-8.6h1.99v6.61h16.17zM5.45 14.2l.41-1.95 9.74 2.05-.41 1.95-9.74-2.05zm1.29-4.62l.85-1.81 9.02 4.24-.85 1.81-9.02-4.24zm2.53-4.42l1.28-1.53 7.65 6.4-1.28 1.54-7.65-6.41zM13.4.66l5.95 8.02-1.61 1.19-5.95-8.02L13.4.66zM5.09 19.37v-2h9.98v2H5.09z"/></svg>
                        </a>
                    </div>
                </div>

                <div class="footer-col">
                    <h4><?= t('footer.quick') ?></h4>
                    <ul>
                        <?php foreach ($NAV_ITEMS as $tkey => $file): ?>
                            <li><a href="<?= $file ?>"><?= e(t($tkey)) ?></a></li>
                        <?php endforeach; ?>
                        <li><a href="hire-me.php"><?= e(t('nav.hire')) ?></a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4><?= t('footer.services') ?></h4>
                    <ul>
                        <li><a href="services.php"><?= t('footer.svc.1') ?></a></li>
                        <li><a href="services.php"><?= t('footer.svc.2') ?></a></li>
                        <li><a href="services.php"><?= t('footer.svc.3') ?></a></li>
                        <li><a href="services.php"><?= t('footer.svc.4') ?></a></li>
                        <li><a href="services.php"><?= t('footer.svc.5') ?></a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4><?= t('footer.touch') ?></h4>
                    <ul class="footer-contact">
                        <li><a href="mailto:<?= e(SITE_EMAIL) ?>"><?= e(SITE_EMAIL) ?></a></li>
                        <li><a href="tel:<?= e(SITE_PHONE_LINK) ?>"><?= e(SITE_PHONE) ?></a></li>
                        <li><?= e(SITE_LOCATION) ?></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> <?= e(SITE_NAME) ?>. <?= t('footer.crafted') ?></p>
                <p class="footer-status"><span class="status-dot"></span> <?= t('footer.status') ?></p>
            </div>
        </div>
    </footer>

    <button class="back-to-top" id="backToTop" aria-label="<?= e(t('a11y.top')) ?>">&uarr;</button>
    <script src="assets/js/main.js"></script>
</body>
</html>
