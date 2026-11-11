<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
if (!feature_on('FEATURE_INBOUND')) {
    header('Location: ' . url('/outbound'), true, 302);
    exit;
}

$categories = experience_categories();
$category = one_of((string) ($_GET['category'] ?? ''), $categories);
$q = clean_line((string) ($_GET['q'] ?? ''), 80);
$rows = array_values(array_filter(experiences_all(), static function (array $row) use ($category, $q): bool {
    if ($category !== '' && ($row['category'] ?? '') !== $category) {
        return false;
    }
    if ($q === '') {
        return true;
    }
    $hay = strtolower((string) ($row['title'] ?? '') . ' ' . (string) ($row['summary'] ?? ''));
    return str_contains($hay, strtolower($q));
}));
$pageTitle = 'Things to do in the UAE';
$pageDescription = 'UAE experiences for visitors: desert, city tours, cruises, attractions, theme parks and transfers.';
$pageCanonical = '/inbound';
$hasHero = false;
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">
    <section class="section">
        <div class="container">
            <?php partial('breadcrumbs', ['items' => [['label' => 'Home', 'href' => '/'], ['label' => 'UAE experiences']]]); ?>
            <h1 style="font-size: clamp(2.6rem, 5vw, 4.4rem);">Things to do in the UAE</h1>
            <p class="lead" style="margin: 0.7rem 0 1rem;">Written for travellers flying into the UAE. Pickup, pace and the heat are part of the plan.</p>
            <form class="search-form is-active" method="get" action="<?= e(url('/inbound')) ?>" style="margin-bottom: 1rem;">
                <label class="field"><span>Keyword</span><input name="q" value="<?= e($q) ?>"></label>
                <label class="field"><span>Category</span>
                    <select name="category"><option value="">All</option><?php foreach ($categories as $item): ?><option<?= $category === $item ? ' selected' : '' ?>><?= e($item) ?></option><?php endforeach; ?></select>
                </label>
                <button class="btn btn--primary" type="submit">Filter</button>
            </form>
            <?php if ($rows === []): ?>
                <p class="notice">Nothing matches that search. <a href="<?= e(url('/custom-trip')) ?>">Tell us what you want to do</a>.</p>
            <?php else: ?>
                <div class="card-grid card-grid--3"><?php foreach ($rows as $experience): ?><?php partial('experience-card', ['experience' => $experience]); ?><?php endforeach; ?></div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
