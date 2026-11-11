<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
if (!feature_on('FEATURE_INBOUND')) {
    header('Location: ' . url('/outbound'), true, 302);
    exit;
}
$experience = find_experience(sanitize_slug((string) ($_GET['slug'] ?? '')));
if ($experience === null) {
    render_404();
}
$pageTitle = $experience['title'] . ' in the UAE';
$pageDescription = (string) $experience['summary'];
$pageCanonical = '/inbound/' . $experience['slug'];
$hasHero = false;
$related = array_values(array_filter(experiences_all(), static fn(array $row): bool => ($row['slug'] ?? '') !== $experience['slug'] && ($row['category'] ?? '') === ($experience['category'] ?? '')));
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">
    <section class="section">
        <div class="container">
            <?php partial('breadcrumbs', ['items' => [['label' => 'Home', 'href' => '/'], ['label' => 'UAE experiences', 'href' => '/inbound'], ['label' => (string) $experience['title']]]]); ?>
            <?php if (!empty($experience['is_sample'])): ?><p class="sample-note">Sample experience. Time and price are confirmed on WhatsApp.</p><?php endif; ?>
            <div class="detail">
                <article>
                    <div class="gallery">
                        <?php foreach ($experience['gallery'] ?? [] as $shot): ?>
                            <img src="<?= e((string) $shot['src']) ?>" alt="<?= e((string) $shot['alt']) ?>" width="1200" height="900">
                        <?php endforeach; ?>
                    </div>
                    <p class="kicker" style="margin-top: 1rem;"><?= e((string) $experience['category']) ?> · <?= e((string) $experience['duration']) ?></p>
                    <h1 style="font-size: clamp(2.6rem, 5vw, 4.4rem);"><?= e((string) $experience['title']) ?></h1>
                    <p class="lead"><?= e((string) $experience['summary']) ?></p>
                    <p>Pickup: <?= e((string) ($experience['pickup'] ?? '')) ?></p>
                    <h2>Highlights</h2>
                    <ul class="check-list"><?php foreach ($experience['highlights'] ?? [] as $item): ?><li><?= e((string) $item) ?></li><?php endforeach; ?></ul>
                    <h2>What is included</h2>
                    <ul class="check-list"><?php foreach ($experience['included'] ?? [] as $item): ?><li><?= e((string) $item) ?></li><?php endforeach; ?></ul>
                    <h2>What to bring</h2>
                    <ul class="check-list"><?php foreach ($experience['bring'] ?? [] as $item): ?><li><?= e((string) $item) ?></li><?php endforeach; ?></ul>
                    <h2>Cancellation</h2>
                    <p><?= e((string) ($experience['cancellation'] ?? '')) ?></p>
                </article>
                <aside class="sticky">
                    <p class="price">From <span data-money="<?= e((string) $experience['price_from']) ?>">AED <?= e(number_format((float) $experience['price_from'], 0)) ?></span></p>
                    <form method="get" action="<?= e(url('/enquire')) ?>">
                        <input type="hidden" name="experience" value="<?= e((string) $experience['title']) ?>">
                        <input type="hidden" name="kind" value="experience">
                        <label class="field"><span>Month</span><select name="month"><?php foreach (travel_months() as $month): ?><option><?= e($month) ?></option><?php endforeach; ?></select></label>
                        <label class="field"><span>Travellers</span><select name="travellers"><?php foreach (traveller_options() as $option): ?><option><?= e($option) ?></option><?php endforeach; ?></select></label>
                        <label class="field"><span>Name</span><input name="name" required></label>
                        <button class="btn btn--primary" type="submit">Enquire on WhatsApp</button>
                    </form>
                </aside>
            </div>
            <?php if ($related !== []): ?>
                <h2 style="margin: 2rem 0 1rem;">Related experiences</h2>
                <div class="card-grid card-grid--3"><?php foreach (array_slice($related, 0, 3) as $item): ?><?php partial('experience-card', ['experience' => $item]); ?><?php endforeach; ?></div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
