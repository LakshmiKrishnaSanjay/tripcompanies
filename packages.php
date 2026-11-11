<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';

$query = package_query();
$results = $query['view'] === 'wishlist' ? packages_public() : filter_packages($query);
$page = paginate($results, (int) $query['page'], 12);
$pageTitle = 'Holiday Packages from Dubai';
$pageDescription = 'Search holiday packages from Dubai by destination, month, trip type and price. Enquire on WhatsApp.';
$pageCanonical = '/packages';
$hasHero = false;
$crumbs = [
    ['label' => 'Home', 'href' => '/'],
    ['label' => 'Holiday packages'],
];
$pageSchemas = [breadcrumb_schema($crumbs)];

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">
    <section class="section">
        <div class="container">
            <?php partial('breadcrumbs', ['items' => $crumbs]); ?>
            <h1 style="font-size: clamp(2.6rem, 5vw, 4.4rem);">Holiday packages from Dubai</h1>
            <p class="lead" style="margin: 0.7rem 0 1.2rem;"><?= e((string) $page['total']) ?> trips<?= $query['view'] === 'wishlist' ? '. Wishlist is saved in this browser.' : '' ?></p>
            <div class="layout">
                <details class="filter" open>
                    <summary class="btn btn--ghost">Filters</summary>
                    <form method="get" action="<?= e(url('/packages')) ?>">
                        <label class="field"><span>Region</span>
                            <select name="region"><option value="">Any</option><?php foreach (regions() as $key => $label): ?><option value="<?= e($key) ?>"<?= $query['region'] === $key ? ' selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?></select>
                        </label>
                        <label class="field"><span>Destination</span>
                            <select name="destination"><option value="">Any</option><?php foreach (destinations_all() as $destination): ?><option value="<?= e((string) $destination['slug']) ?>"<?= $query['destination'] === $destination['slug'] ? ' selected' : '' ?>><?= e((string) $destination['name']) ?></option><?php endforeach; ?></select>
                        </label>
                        <label class="field"><span>Month</span>
                            <select name="month"><option value="">Any</option><?php foreach (travel_months() as $month): ?><option<?= $query['month'] === $month ? ' selected' : '' ?>><?= e($month) ?></option><?php endforeach; ?></select>
                        </label>
                        <label class="field"><span>Trip type</span>
                            <select name="type"><option value="">Any</option><?php foreach (trip_types() as $key => $label): ?><option value="<?= e($key) ?>"<?= $query['type'] === $key ? ' selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?></select>
                        </label>
                        <label class="field"><span>Duration</span>
                            <select name="duration">
                                <option value="">Any</option>
                                <option value="short"<?= $query['duration'] === 'short' ? ' selected' : '' ?>>Up to 4 nights</option>
                                <option value="week"<?= $query['duration'] === 'week' ? ' selected' : '' ?>>5 to 7 nights</option>
                                <option value="long"<?= $query['duration'] === 'long' ? ' selected' : '' ?>>8 nights or more</option>
                            </select>
                        </label>
                        <label class="field"><span>Price</span>
                            <select name="price"><option value="">Any</option><?php foreach (price_bands() as $key => $label): ?><option value="<?= e($key) ?>"<?= $query['price'] === $key ? ' selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?></select>
                        </label>
                        <fieldset style="border: 0; padding: 0; margin: 0;">
                            <legend class="label">Inclusions</legend>
                            <?php foreach (inclusion_catalog() as $key => $label): ?>
                                <label class="label"><input type="checkbox" name="inclusions[]" value="<?= e($key) ?>"<?= in_array($key, $query['inclusions'], true) ? ' checked' : '' ?>> <?= e($label) ?></label>
                            <?php endforeach; ?>
                        </fieldset>
                        <div class="filter__actions">
                            <button class="btn btn--primary" type="submit">Apply filters</button>
                            <a class="btn btn--ghost" href="<?= e(url('/packages')) ?>">Clear</a>
                        </div>
                    </form>
                </details>
                <div>
                    <form method="get" action="<?= e(url('/packages')) ?>" class="sort-bar">
                        <?php foreach (['region', 'destination', 'month', 'type', 'duration', 'price', 'view'] as $key): ?>
                            <?php if ($query[$key] !== ''): ?><input type="hidden" name="<?= e($key) ?>" value="<?= e((string) $query[$key]) ?>"><?php endif; ?>
                        <?php endforeach; ?>
                        <?php foreach ($query['inclusions'] as $icon): ?><input type="hidden" name="inclusions[]" value="<?= e($icon) ?>"><?php endforeach; ?>
                        <label class="field"><span>Sort</span>
                            <select name="sort" onchange="this.form.requestSubmit()">
                                <option value="recommended"<?= $query['sort'] === 'recommended' ? ' selected' : '' ?>>Recommended</option>
                                <option value="price"<?= $query['sort'] === 'price' ? ' selected' : '' ?>>Price</option>
                                <option value="duration"<?= $query['sort'] === 'duration' ? ' selected' : '' ?>>Duration</option>
                            </select>
                        </label>
                        <noscript><button class="btn btn--ghost" type="submit">Sort</button></noscript>
                    </form>
                    <?php if ($query['view'] === 'wishlist'): ?>
                        <p class="notice">Your wishlist is stored in this browser. With JavaScript off, open a saved trip from the link you already have, or browse every holiday below and use WhatsApp.</p>
                    <?php endif; ?>
                    <?php if ($page['items'] === []): ?>
                        <div class="notice">
                            <p>No holidays match those filters.</p>
                            <a class="btn btn--primary" href="<?= e(url('/custom-trip')) ?>">Request a custom trip</a>
                        </div>
                    <?php else: ?>
                        <div class="card-grid card-grid--3"<?= $query['view'] === 'wishlist' ? ' data-wishlist-view' : '' ?>>
                            <?php foreach ($page['items'] as $package): ?>
                                <?php partial('package-card', ['package' => $package]); ?>
                            <?php endforeach; ?>
                            <?php if ($query['view'] === 'wishlist'): ?>
                                <p class="notice" data-wishlist-empty hidden>No saved holidays yet. <a href="<?= e(url('/packages')) ?>">Browse packages</a></p>
                            <?php endif; ?>
                        </div>
                        <?php partial('pagination', ['page' => $page['page'], 'pages' => $page['pages'], 'path' => '/packages', 'query' => $query]); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
