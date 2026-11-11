<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
$pageTitle = 'Outbound holidays from Dubai';
$pageDescription = 'Outbound holiday packages from Dubai for people living in the UAE.';
$pageCanonical = '/outbound';
$hasHero = false;
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">
    <section class="section">
        <div class="container">
            <?php partial('breadcrumbs', ['items' => [['label' => 'Home', 'href' => '/'], ['label' => 'Outbound holidays']]]); ?>
            <h1 style="font-size: clamp(2.6rem, 5vw, 4.4rem);">Outbound holidays</h1>
            <p class="lead" style="margin: 0.7rem 0 1.4rem;">Holidays for people living in the UAE. Choose a region, then a destination.</p>
            <?php foreach (regions() as $key => $label): ?>
                <?php
                $places = array_values(array_filter(destinations_all(), static fn(array $row): bool => ($row['region'] ?? '') === $key));
                $packages = filter_packages(package_query_from(['region' => $key]));
                if ($places === [] && $packages === []) { continue; }
                ?>
                <h2 style="margin: 1.6rem 0 0.8rem;"><?= e($label) ?></h2>
                <div class="tabs">
                    <?php foreach ($places as $place): ?><a class="tab" href="<?= e(url('/destinations/' . $place['slug'])) ?>"><?= e((string) $place['name']) ?></a><?php endforeach; ?>
                </div>
                <?php if ($packages !== []): ?>
                    <div class="card-grid card-grid--3"><?php foreach (array_slice($packages, 0, 3) as $package): ?><?php partial('package-card', ['package' => $package]); ?><?php endforeach; ?></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
