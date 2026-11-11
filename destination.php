<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
$destination = find_destination(sanitize_slug((string) ($_GET['slug'] ?? '')));
if ($destination === null) {
    render_404();
}
$packages = filter_packages(package_query_from(['destination' => $destination['slug']]));
$reviews = reviews_for((string) $destination['slug']);
$faqs = $destination['faqs'] ?? [];
$pageTitle = $destination['name'] . ' Holiday Packages from Dubai';
$pageDescription = (string) $destination['summary'];
$pageCanonical = '/destinations/' . $destination['slug'];
$hasHero = true;
$pageSchemas = [breadcrumb_schema([
    ['label' => 'Home', 'href' => '/'],
    ['label' => 'Destinations', 'href' => '/destinations'],
    ['label' => (string) $destination['name']],
])];
if ($faqs !== []) {
    $pageSchemas[] = faq_schema($faqs);
}
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">
    <section class="page-hero">
        <img class="media-fill" src="<?= e((string) $destination['image']) ?>" alt="<?= e((string) $destination['image_alt']) ?>" width="2000" height="1100" fetchpriority="high">
        <div class="page-hero__content on-photo">
            <p class="eyebrow"><?= e(regions()[$destination['region']] ?? '') ?></p>
            <h1><?= e((string) $destination['name']) ?></h1>
            <p class="lead"><?= e((string) $destination['tagline']) ?></p>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <?php partial('breadcrumbs', ['items' => [['label' => 'Home', 'href' => '/'], ['label' => 'Destinations', 'href' => '/destinations'], ['label' => (string) $destination['name']]]]); ?>
            <?php if (!empty($destination['highlights'])): ?>
                <div class="card-grid card-grid--3">
                    <?php foreach ($destination['highlights'] as $shot): ?>
                        <figure class="shot" style="aspect-ratio: 4/3;"><img class="media-fill" src="<?= e((string) $shot['src']) ?>" alt="<?= e((string) $shot['alt']) ?>" width="800" height="600" loading="lazy"><span><?= e((string) $shot['label']) ?></span></figure>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if (trust_any()): ?><p class="notice" style="margin-top: 1rem;">Ask us for the latest desk details when you enquire.</p><?php endif; ?>
            <div class="prose" style="margin-top: 1.5rem;">
                <h2>Why visit <?= e((string) $destination['name']) ?></h2>
                <p><?= e((string) $destination['summary']) ?></p>
                <ul class="check-list"><?php foreach ($destination['why'] ?? [] as $item): ?><li><?= e((string) $item) ?></li><?php endforeach; ?></ul>
            </div>
            <?php if ($packages !== []): ?>
                <h2 style="margin: 2rem 0 1rem;">Packages for <?= e((string) $destination['name']) ?></h2>
                <div class="card-grid card-grid--3"><?php foreach ($packages as $package): ?><?php partial('package-card', ['package' => $package]); ?><?php endforeach; ?></div>
            <?php endif; ?>
            <h2 style="margin: 2rem 0 1rem;">Essential information</h2>
            <ul class="check-list">
                <li>Best time: <?= e((string) $destination['best_time']) ?></li>
                <li>Currency: <?= e((string) $destination['currency']) ?></li>
                <li>Visa: <?= visa_note_html((string) ($destination['visa'] ?? ''), (string) $destination['name']) ?></li>
                <?php if (trim((string) ($destination['flying_time'] ?? '')) !== ''): ?>
                <li>Flying time: <?= e((string) $destination['flying_time']) ?></li>
                <?php endif; ?>
            </ul>
            <?php if ($reviews !== []): ?>
                <h2 style="margin: 2rem 0 1rem;">Sample notes</h2>
                <?php foreach ($reviews as $review): ?><blockquote class="quote"><p><?= e((string) $review['quote']) ?></p><p class="kicker"><?= e((string) $review['name']) ?></p></blockquote><?php endforeach; ?>
            <?php endif; ?>
            <?php if ($faqs !== []): ?>
                <h2 style="margin-top: 2rem;">Questions</h2>
                <?php foreach ($faqs as $item): ?><details class="faq"><summary><span><?= e((string) $item['q']) ?></span></summary><p><?= e((string) $item['a']) ?></p></details><?php endforeach; ?>
            <?php endif; ?>
            <form class="form" method="get" action="<?= e(url('/enquire')) ?>" style="margin-top: 2rem; padding: 1rem;">
                <h2>Ask about <?= e((string) $destination['name']) ?></h2>
                <input type="hidden" name="destination" value="<?= e((string) $destination['name']) ?>">
                <div class="form-row">
                    <label class="field"><span>Month</span><select name="month"><?php foreach (travel_months() as $month): ?><option><?= e($month) ?></option><?php endforeach; ?></select></label>
                    <label class="field"><span>Name</span><input name="name" required></label>
                </div>
                <button class="btn btn--primary" type="submit">Enquire on WhatsApp</button>
            </form>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
