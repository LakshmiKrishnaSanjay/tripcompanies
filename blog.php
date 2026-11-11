<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
$pageTitle = 'Travel guides';
$pageDescription = 'Short travel guides from the Tripcompanies desk in Dubai.';
$pageCanonical = '/blog';
$hasHero = false;
$posts = posts_all();
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">
    <section class="section">
        <div class="container">
            <?php partial('breadcrumbs', ['items' => [['label' => 'Home', 'href' => '/'], ['label' => 'Guides']]]); ?>
            <h1 style="font-size: clamp(2.6rem, 5vw, 4.4rem);">Travel guides</h1>
            <?php if ($posts === []): ?>
                <p class="notice">No guides are published yet.</p>
            <?php else: ?>
                <div class="post-grid" style="margin-top: 1.2rem;">
                    <?php foreach ($posts as $post): ?>
                        <a class="package-card" href="<?= e(url('/blog/' . $post['slug'])) ?>" style="text-decoration: none;">
                            <span class="package-card__media"><img class="media-fill" src="<?= e((string) $post['image']) ?>" alt="<?= e((string) $post['alt']) ?>" width="800" height="600" loading="lazy"></span>
                            <span class="package-card__body"><span class="kicker"><?= e((string) $post['date']) ?></span><h3><?= e((string) $post['title']) ?></h3><p><?= e((string) $post['excerpt']) ?></p></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
