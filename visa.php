<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
if (!feature_on('FEATURE_VISA')) {
    header('Location: ' . url('/outbound'), true, 302);
    exit;
}
$country = sanitize_slug((string) ($_GET['country'] ?? ''));
$rows = visas_all();
if ($country !== '') {
    $rows = array_values(array_filter($rows, static fn(array $visa): bool => ($visa['slug'] ?? '') === $country));
}
$pageTitle = 'Visa services from Dubai';
$pageDescription = 'Visa support from Dubai for Schengen, the UK, the USA and more. The embassy decides. No approval is guaranteed.';
$pageCanonical = '/visa';
$hasHero = false;
$faqs = array_values(array_filter(visa_faqs(), 'is_public_record'));
$pageSchemas = $faqs !== [] ? [faq_schema($faqs)] : [];
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">
    <section class="section">
        <div class="container">
            <?php partial('breadcrumbs', ['items' => [['label' => 'Home', 'href' => '/'], ['label' => 'Visa services']]]); ?>
            <h1 style="font-size: clamp(2.6rem, 5vw, 4.4rem);">Visa services</h1>
            <p class="lead" style="margin: 0.7rem 0 1rem;">We prepare the file with you. The final decision rests with the embassy or immigration authority. No approval is guaranteed.</p>
            <form class="search-form is-active" method="get" action="<?= e(url('/visa')) ?>">
                <label class="field"><span>Country</span>
                    <select name="country"><option value="">All countries</option><?php foreach (visas_all() as $visa): ?><option value="<?= e((string) $visa['slug']) ?>"<?= $country === $visa['slug'] ? ' selected' : '' ?>><?= e((string) $visa['country']) ?></option><?php endforeach; ?></select>
                </label>
                <button class="btn btn--primary" type="submit">Show visas</button>
            </form>
            <?php if ($rows === []): ?>
                <p class="notice">No visa guides are published for that search. <a href="<?= e(wa_link('Hi Tripcompanies, I need help with a visa.')) ?>">Ask on WhatsApp</a>.</p>
            <?php else: ?>
                <div class="card-grid card-grid--3" style="margin-top: 1rem;">
                    <?php foreach ($rows as $visa): ?>
                        <a class="panel" href="<?= e(url('/visa/' . $visa['slug'])) ?>" style="padding: 1rem; text-decoration: none;">
                            <p class="kicker"><?= e((string) ($visa['flag'] ?? '')) ?> <?= e(implode(', ', $visa['types'] ?? [])) ?></p>
                            <h3><?= e((string) $visa['country']) ?></h3>
                            <p><?= e((string) $visa['summary']) ?></p>
                            <p class="label"><?= e((string) $visa['processing']) ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if ($faqs !== []): ?>
                <h2 style="margin-top: 2rem;">Visa questions</h2>
                <?php foreach ($faqs as $item): ?><details class="faq"><summary><span><?= e((string) $item['q']) ?></span></summary><p><?= e((string) $item['a']) ?></p></details><?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
