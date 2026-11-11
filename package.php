<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';

$slug = sanitize_slug((string) ($_GET['slug'] ?? ''));
$package = find_public_package($slug);
if ($package === null) {
    render_404();
}

$name = package_destination($package);
$pageTitle = $package['title'] . ' from Dubai';
$pageDescription = (string) ($package['overview'] ?? $pageTitle);
$pageCanonical = '/packages/' . $slug;
$hasHero = false;
$crumbs = [
    ['label' => 'Home', 'href' => '/'],
    ['label' => 'Holiday packages', 'href' => '/packages'],
    ['label' => (string) $package['title']],
];
$pageSchemas = [breadcrumb_schema($crumbs)];
if (empty($package['is_sample'])) {
    $pageSchemas[] = [
        '@type' => 'Product',
        'name' => $package['title'],
        'description' => $package['overview'] ?? '',
        'offers' => [
            '@type' => 'Offer',
            'priceCurrency' => 'AED',
            'price' => (string) ($package['price_from'] ?? ''),
            'availability' => 'https://schema.org/InStock',
            'url' => absolute_url('/packages/' . $slug),
        ],
    ];
}
$related = related_packages($package);
$gallery = $package['gallery'] ?? [];
if ($gallery === []) {
    $gallery = [['src' => $package['image'], 'alt' => $package['image_alt'] ?? $package['title']]];
}

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main" data-recent-slug="<?= e($slug) ?>">
    <section class="section">
        <div class="container">
            <?php partial('breadcrumbs', ['items' => $crumbs]); ?>
            <?php if (!empty($package['is_sample'])): ?><p class="sample-note">Sample package. Dates and the price are confirmed on WhatsApp.</p><?php endif; ?>
            <div class="gallery">
                <?php foreach ($gallery as $shot): ?>
                    <button type="button" data-lightbox="<?= e((string) $shot['src']) ?>" data-alt="<?= e((string) ($shot['alt'] ?? '')) ?>">
                        <img class="media-fill" src="<?= e((string) $shot['src']) ?>" alt="<?= e((string) ($shot['alt'] ?? '')) ?>" width="1200" height="900">
                    </button>
                <?php endforeach; ?>
            </div>
            <div class="detail" style="margin-top: 1.4rem;">
                <article>
                    <p class="kicker"><?= e($name) ?> · <?= e(duration_label($package)) ?></p>
                    <h1 style="font-size: clamp(2.6rem, 5vw, 4.6rem); margin-top: 0.4rem;"><?= e((string) $package['title']) ?></h1>
                    <?php if (!empty($package['route'])): ?><p style="margin-top: 0.5rem;"><?= e(implode(' · ', $package['route'])) ?></p><?php endif; ?>
                    <nav class="anchor-nav" aria-label="Package sections">
                        <a href="#overview">Overview</a>
                        <a href="#highlights">Highlights</a>
                        <a href="#itinerary">Day by day</a>
                        <a href="#hotels">Hotels</a>
                        <a href="#included">Included</a>
                        <a href="#departures">Departures</a>
                        <a href="#visa">Visa</a>
                        <a href="#terms">Terms</a>
                    </nav>
                    <section id="overview" class="prose"><h2>Overview</h2><p><?= e((string) ($package['overview'] ?? '')) ?></p></section>
                    <section id="highlights" class="prose"><h2>Highlights</h2><ul class="check-list"><?php foreach ($package['highlights'] ?? [] as $item): ?><li><?= icon('check') ?><?= e((string) $item) ?></li><?php endforeach; ?></ul></section>
                    <section id="itinerary" class="prose"><h2>Day by day itinerary</h2><?php foreach ($package['itinerary'] ?? [] as $day): ?><h3>Day <?= e((string) $day['day']) ?>: <?= e((string) $day['title']) ?></h3><p><?= e((string) $day['desc']) ?></p><?php endforeach; ?></section>
                    <section id="hotels" class="prose"><h2>Hotels</h2><?php foreach ($package['hotels'] ?? [] as $hotel): ?><h3><?= e((string) $hotel['name']) ?></h3><p><?= e((string) $hotel['note']) ?></p><?php endforeach; ?></section>
                    <section id="included" class="prose"><h2>Included and excluded</h2><ul class="check-list"><?php foreach ($package['included'] ?? [] as $item): ?><li><?= icon('check') ?><?= e((string) $item) ?></li><?php endforeach; ?></ul><ul class="check-list"><?php foreach ($package['excluded'] ?? [] as $item): ?><li><?= e((string) $item) ?></li><?php endforeach; ?></ul></section>
                    <section id="departures" class="prose"><h2>Departure dates</h2><?php if (!empty($package['departures'])): ?><ul class="check-list"><?php foreach ($package['departures'] as $date): ?><li><?= e((string) $date) ?></li><?php endforeach; ?></ul><?php else: ?><p>Tell us a month and we will check what is open.</p><?php endif; ?></section>
                    <section id="visa" class="prose"><h2>Visa information</h2><p><?= visa_note_html((string) ($package['visa_note'] ?? ''), (string) $package['title']) ?></p></section>
                    <section id="terms" class="prose"><h2>Terms</h2><p><?= e((string) ($package['terms'] ?? '')) ?></p></section>
                    <?php if ($related !== []): ?>
                        <h2 style="margin-top: 2rem;">Related packages</h2>
                        <div class="card-grid card-grid--3" style="margin-top: 1rem;">
                            <?php foreach ($related as $item): ?><?php partial('package-card', ['package' => $item]); ?><?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </article>
                <aside class="sticky">
                    <p class="kicker">From</p>
                    <p class="price"><span data-money="<?= e((string) $package['price_from']) ?>">AED <?= e(number_format((float) $package['price_from'], 0)) ?></span><small><?= e((string) ($package['price_basis'] ?? 'per person, twin share')) ?><?php $save = save_label($package); if ($save !== ''): ?> · <?= e($save) ?><?php endif; ?></small></p>
                    <form method="get" action="<?= e(url('/enquire')) ?>">
                        <input type="hidden" name="package_slug" value="<?= e($slug) ?>">
                        <input type="hidden" name="package" value="<?= e((string) $package['title']) ?>">
                        <label class="field"><span>Travel month</span><select name="month"><?php foreach (travel_months() as $month): ?><option><?= e($month) ?></option><?php endforeach; ?></select></label>
                        <label class="field"><span>Adults</span><select name="adults"><?php foreach (traveller_options() as $option): ?><option><?= e($option) ?></option><?php endforeach; ?></select></label>
                        <label class="field"><span>Name</span><input name="name" required></label>
                        <button class="btn btn--primary" type="submit">Enquire on WhatsApp</button>
                    </form>
                    <a class="btn btn--ghost" href="<?= e(url('/contact?topic=callback&package=' . rawurlencode((string) $package['title']))) ?>">Request a callback</a>
                </aside>
            </div>
        </div>
    </section>
</main>
<div class="lightbox" id="lightbox" hidden><img alt=""></div>
<?php require __DIR__ . '/includes/footer.php'; ?>
