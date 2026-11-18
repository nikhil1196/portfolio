<?php
require_once __DIR__ . '/includes/config.php';
$pageTitle   = t('nav.home');
$currentPage = 'index.php';
$pageDesc    = t('meta.desc.home');
include 'includes/header.php';
?>
<script>window.HERO_ROLES = <?= json_encode(ta('hero.roles')) ?>;</script>

<!-- ============ HERO ============ -->
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-grid"></div>
    <div class="container">
        <div class="hero-inner">
            <div class="hero-content">
                <span class="hero-badge"><span class="status-dot"></span> <?= t('hero.badge') ?></span>
                <h1 class="hero-name"><?= t('hero.hi') ?> <span class="grad"><?= e(SITE_NAME) ?></span></h1>
                <div class="hero-role"><span class="typed"></span><span class="cursor">&nbsp;</span></div>
                <p class="hero-desc"><?= t('hero.desc') ?></p>
                <div class="hero-actions">
                    <a href="portfolio.php" class="btn btn-primary"><?= t('hero.btn.work') ?></a>
                    <a href="hire-me.php" class="btn btn-outline"><?= t('hero.btn.hire') ?></a>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-card">
                    <div class="hero-card-bar"><i></i><i></i><i></i></div>
                    <div class="hero-card-body">
                        <div><span class="ln">1</span><span class="code-cmt">// nikhilagrawal.tech</span></div>
                        <div><span class="ln">2</span><span class="code-kw">class</span> <span class="code-cls">NikhilAgrawal</span> <span class="code-kw">extends</span> <span class="code-cls">BackendEngineer</span></div>
                        <div><span class="ln">3</span>{</div>
                        <div><span class="ln">4</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="code-kw">public array</span> <span class="code-var">$stack</span> = [</div>
                        <div><span class="ln">5</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="code-str">'Laravel'</span>, <span class="code-str">'PHP'</span>, <span class="code-str">'Python'</span>,</div>
                        <div><span class="ln">6</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="code-str">'MySQL'</span>, <span class="code-str">'REST APIs'</span>, <span class="code-str">'Docker'</span>,</div>
                        <div><span class="ln">7</span>&nbsp;&nbsp;&nbsp;&nbsp;];</div>
                        <div><span class="ln">8</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="code-kw">public function</span> <span class="code-fn">deliver</span>(): <span class="code-cls">Result</span></div>
                        <div><span class="ln">9</span>&nbsp;&nbsp;&nbsp;&nbsp;{</div>
                        <div><span class="ln">10</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="code-kw">return</span> <span class="code-str">'scalable, on-time'</span>;</div>
                        <div><span class="ln">11</span>&nbsp;&nbsp;&nbsp;&nbsp;}</div>
                        <div><span class="ln">12</span>}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ STATS ============ -->
<section class="stats-strip">
    <div class="container">
        <div class="stats-grid">
            <?php foreach (ta('stats') as $i => $stat): ?>
                <div class="stat reveal" data-delay="<?= $i + 1 ?>">
                    <div class="stat-num" data-count="<?= $stat['number'] ?>" data-suffix="<?= $stat['suffix'] ?>">0<?= $stat['suffix'] ?></div>
                    <div class="stat-label"><?= $stat['label'] ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ ABOUT PREVIEW ============ -->
<section class="section">
    <div class="container">
        <div class="section-head reveal">
            <span class="section-tag"><?= t('home.who.tag') ?></span>
            <h2 class="section-title"><?= t('home.who.t1') ?> <span class="grad"><?= t('home.who.t2') ?></span></h2>
            <p class="section-sub"><?= t('home.who.sub') ?></p>
        </div>
        <div class="grid-3">
            <?php foreach (ta('home.cards') as $i => $card): ?>
                <div class="card reveal" data-delay="<?= $i + 1 ?>">
                    <div class="card-icon"><?= $card['icon'] ?></div>
                    <h3><?= $card['t'] ?></h3>
                    <p><?= $card['p'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <div style="text-align:center; margin-top:44px;" class="reveal">
            <a href="about.php" class="btn btn-outline"><?= t('home.more') ?></a>
        </div>
    </div>
</section>

<!-- ============ SKILLS PREVIEW ============ -->
<section class="section section-alt">
    <div class="container">
        <div class="section-head reveal">
            <span class="section-tag"><?= t('home.stack.tag') ?></span>
            <h2 class="section-title"><?= t('home.stack.t1') ?> <span class="grad"><?= t('home.stack.t2') ?></span></h2>
        </div>
        <div class="chips reveal" style="justify-content:center; max-width:840px; margin:0 auto;">
            <?php foreach (ta('chips') as $c): ?>
                <span class="chip"><?= e($c) ?></span>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ FEATURED PROJECTS ============ -->
<section class="section">
    <div class="container">
        <div class="section-head reveal">
            <span class="section-tag"><?= t('home.feat.tag') ?></span>
            <h2 class="section-title"><?= t('home.feat.t1') ?> <span class="grad"><?= t('home.feat.t2') ?></span></h2>
            <p class="section-sub"><?= t('home.feat.sub') ?></p>
        </div>
        <div class="grid-3">
            <?php
            $projects = ta('projects');
            $featured = [$projects[0], $projects[4], $projects[9]]; // Gym SaaS, Restaurant POS, AI Support
            foreach ($featured as $i => $p): ?>
                <div class="card project-card reveal" data-delay="<?= $i + 1 ?>">
                    <div class="project-thumb" style="background:<?= e($p['bg']) ?>;"><?= e($p['thumb']) ?></div>
                    <div class="project-body">
                        <span class="project-cat"><?= e($p['cat_label']) ?></span>
                        <h3><?= e($p['title']) ?></h3>
                        <p><?= $p['desc'] ?></p>
                        <div class="project-tags">
                            <?php foreach ($p['tags'] as $tg): ?><span><?= e($tg) ?></span><?php endforeach; ?>
                        </div>
                        <div class="project-links"><a href="portfolio.php"><?= t('proj.case') ?></a></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div style="text-align:center; margin-top:44px;" class="reveal">
            <a href="portfolio.php" class="btn btn-primary"><?= t('home.feat.all') ?></a>
        </div>
    </div>
</section>

<!-- ============ CTA ============ -->
<section class="section" style="padding-top:0;">
    <div class="container">
        <div class="cta-band reveal">
            <h2><?= t('cta.h.t') ?></h2>
            <p><?= t('cta.h.p') ?></p>
            <a href="hire-me.php" class="btn btn-primary"><?= t('cta.h.b') ?></a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
