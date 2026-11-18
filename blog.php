<?php
require_once __DIR__ . '/includes/config.php';
$pageTitle   = t('nav.blog');
$currentPage = 'blog.php';
$pageDesc    = t('meta.desc.blog');
include 'includes/header.php';
// Blog posts live in lang/*.php — edit there to publish real articles.
?>

<section class="page-banner">
    <div class="container">
        <h1><?= t('ban.blog.t1') ?> <span class="grad"><?= t('ban.blog.t2') ?></span></h1>
        <p class="breadcrumb"><a href="index.php"><?= t('crumb.home') ?></a> / <?= t('nav.blog') ?></p>
        <p class="banner-sub"><?= t('ban.blog.sub') ?></p>
    </div>
</section>

<section class="section" style="padding-top:24px;">
    <div class="container">
        <div class="grid-3">
            <?php foreach (ta('blog.posts') as $i => $post): ?>
                <article class="card blog-card reveal" data-delay="<?= ($i % 3) + 1 ?>">
                    <div class="blog-thumb" style="background:<?= e($post['bg']) ?>;">
                        <span class="blog-cat"><?= e($post['cat']) ?></span>
                    </div>
                    <div class="blog-body">
                        <span class="blog-meta"><?= e($post['date']) ?> · <?= e($post['read']) ?></span>
                        <h3><?= $post['title'] ?></h3>
                        <p><?= $post['excerpt'] ?></p>
                        <a href="<?= e($post['link']) ?>" class="blog-read"><?= t('blog.read') ?></a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <p class="reveal" style="text-align:center; color:var(--text-muted); margin-top:36px; font-size:.9rem;">
            <?= t('blog.more') ?> <a href="contact.php" style="color:var(--accent-2)"><?= t('blog.more.link') ?></a> <?= t('blog.more.end') ?>
        </p>
    </div>
</section>

<!-- ============ NEWSLETTER ============ -->
<section class="section" style="padding-top:0;">
    <div class="container">
        <div class="cta-band reveal">
            <h2><?= t('news.t') ?></h2>
            <p><?= t('news.p') ?></p>
            <form style="display:flex; gap:12px; max-width:460px; margin:0 auto; position:relative;" onsubmit="event.preventDefault(); this.innerHTML='<?= t('news.ok') ?>';" style="color:var(--accent-2)">
                <input type="email" class="form-control" placeholder="<?= e(t('news.ph')) ?>" required>
                <button type="submit" class="btn btn-primary" style="white-space:nowrap;"><?= t('news.btn') ?></button>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
