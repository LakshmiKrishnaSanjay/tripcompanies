<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
$post = find_post(sanitize_slug((string) ($_GET['slug'] ?? '')));
if ($post === null) {
    render_404();
}
$pageTitle = (string) $post['title'];
$pageDescription = (string) $post['excerpt'];
$pageCanonical = '/blog/' . $post['slug'];
$hasHero = false;
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">
    <section class="section">
        <div class="container prose">
            <?php partial('breadcrumbs', ['items' => [['label' => 'Home', 'href' => '/'], ['label' => 'Guides', 'href' => '/blog'], ['label' => (string) $post['title']]]]); ?>
            <p class="kicker"><?= e((string) $post['date']) ?></p>
            <h1 style="font-size: clamp(2.4rem, 5vw, 4rem);"><?= e((string) $post['title']) ?></h1>
            <img src="<?= e((string) $post['image']) ?>" alt="<?= e((string) $post['alt']) ?>" width="1200" height="800">
            <?php foreach ($post['body'] ?? [] as $paragraph): ?><p><?= e((string) $paragraph) ?></p><?php endforeach; ?>
            <a class="btn btn--primary" href="<?= e(wa_link('Hi Tripcompanies, I read ' . $post['title'] . ' and I would like to plan something similar.')) ?>">Plan this on WhatsApp</a>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
