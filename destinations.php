<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
$pageTitle = 'Destinations for holidays from Dubai';
$pageDescription = 'Destination guides and holiday packages from Dubai, planned by Tripcompanies.';
$pageCanonical = '/destinations';
$hasHero = false;
$destinations = destinations_all();
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">
    <section class="section">
        <div class="container">
            <?php partial('breadcrumbs', ['items' => [['label' => 'Home', 'href' => '/'], ['label' => 'Destinations']]]); ?>
            <h1 style="font-size: clamp(2.6rem, 5vw, 4.4rem);">Destinations</h1>
            <?php if ($destinations === []): ?>
                <p class="notice" style="margin-top: 1rem;">Destination guides will appear here once they are published.</p>
            <?php else: ?>
                <div class="tile-grid" style="margin-top: 1.4rem;">
                    <?php foreach ($destinations as $destination): ?>
                        <a class="tile" href="<?= e(url('/destinations/' . $destination['slug'])) ?>">
                            <img class="media-fill" src="<?= e((string) $destination['image']) ?>" alt="<?= e((string) $destination['image_alt']) ?>" width="800" height="1000" loading="lazy">
                            <span><strong><?= e((string) $destination['name']) ?></strong><br><?= e((string) $destination['tagline']) ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
