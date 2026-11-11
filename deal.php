<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
$deal = find_deal(sanitize_slug((string) ($_GET['slug'] ?? '')));
if ($deal === null) {
    render_404();
}
$query = package_query_from(['deal' => $deal['slug'], 'sort' => 'recommended']);
$packages = filter_packages($query);
$pageTitle = $deal['title'] . ' from Dubai';
$pageDescription = (string) $deal['summary'];
$pageCanonical = '/deals/' . $deal['slug'];
$hasHero = true;
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">
    <section class="page-hero">
        <img class="media-fill" src="<?= e((string) $deal['image']) ?>" alt="<?= e((string) $deal['alt']) ?>" width="2000" height="1100" fetchpriority="high">
        <div class="page-hero__content on-photo">
            <p class="eyebrow"><?= e((string) $deal['window']) ?></p>
            <h1><?= e((string) $deal['title']) ?></h1>
            <p class="lead"><?= e((string) $deal['summary']) ?></p>
            <?php if (!empty($deal['ends_at'])): ?><p class="countdown" data-countdown="<?= e((string) $deal['ends_at']) ?>"></p><?php endif; ?>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <?php partial('breadcrumbs', ['items' => [['label' => 'Home', 'href' => '/'], ['label' => 'Deals', 'href' => '/deals'], ['label' => (string) $deal['title']]]]); ?>
            <?php if ($packages === []): ?>
                <p class="notice">No packages are listed for this campaign. <a href="<?= e(url('/custom-trip')) ?>">Request a custom trip</a>.</p>
            <?php else: ?>
                <div class="card-grid card-grid--3">
                    <?php foreach ($packages as $package): ?><?php partial('package-card', ['package' => $package]); ?><?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
