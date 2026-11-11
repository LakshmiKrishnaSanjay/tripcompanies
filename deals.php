<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
$pageTitle = 'Seasonal holiday deals from Dubai';
$pageDescription = 'Seasonal holiday campaigns from the Tripcompanies desk in Dubai.';
$pageCanonical = '/deals';
$hasHero = false;
$deals = deals_all();
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">
    <section class="section">
        <div class="container">
            <?php partial('breadcrumbs', ['items' => [['label' => 'Home', 'href' => '/'], ['label' => 'Deals']]]); ?>
            <h1 style="font-size: clamp(2.6rem, 5vw, 4.4rem);">Seasonal deals</h1>
            <?php if ($deals === []): ?>
                <p class="notice" style="margin-top: 1rem;">No campaigns are published yet. <a href="<?= e(url('/custom-trip')) ?>">Request a custom trip</a>.</p>
            <?php else: ?>
                <div class="card-grid card-grid--3" style="margin-top: 1.4rem;">
                    <?php foreach ($deals as $deal): ?>
                        <a class="package-card" href="<?= e(url('/deals/' . $deal['slug'])) ?>" style="text-decoration: none;">
                            <span class="package-card__media"><img class="media-fill" src="<?= e((string) $deal['image']) ?>" alt="<?= e((string) $deal['alt']) ?>" width="800" height="600" loading="lazy"></span>
                            <span class="package-card__body"><span class="kicker"><?= e((string) $deal['window']) ?></span><h3><?= e((string) $deal['title']) ?></h3><p><?= e((string) $deal['summary']) ?></p></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
