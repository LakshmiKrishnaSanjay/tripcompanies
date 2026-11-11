<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
if (!feature_on('FEATURE_VISA')) {
    header('Location: ' . url('/outbound'), true, 302);
    exit;
}
$visa = find_visa(sanitize_slug((string) ($_GET['slug'] ?? '')));
if ($visa === null) {
    render_404();
}
$pageTitle = $visa['country'] . ' visa from Dubai';
$pageDescription = (string) $visa['summary'];
$pageCanonical = '/visa/' . $visa['slug'];
$hasHero = false;
$crumbs = [['label' => 'Home', 'href' => '/'], ['label' => 'Visa services', 'href' => '/visa'], ['label' => (string) $visa['country']]];
$pageSchemas = [breadcrumb_schema($crumbs)];
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">
    <section class="section">
        <div class="container prose">
            <?php partial('breadcrumbs', ['items' => $crumbs]); ?>
            <?php if (!empty($visa['is_sample'])): ?><p class="sample-note">Sample checklist. We send the current list for your nationality before you collect papers.</p><?php endif; ?>
            <h1 style="font-size: clamp(2.6rem, 5vw, 4.4rem);"><?= e((string) $visa['country']) ?> visa</h1>
            <p><?= e((string) $visa['summary']) ?></p>
            <p class="notice">The final decision rests with the embassy or immigration authority. Tripcompanies does not guarantee an approval.</p>
            <p>Typical processing: <?= e((string) $visa['processing']) ?></p>
            <?php if (!empty($visa['types'])): ?><p>Visa types: <?= e(implode(', ', $visa['types'])) ?></p><?php endif; ?>
            <?php if (!empty($visa['fee'])): ?><p>Starting fee: AED <?= e(number_format((float) $visa['fee'], 0)) ?>. Embassy fees are quoted separately.</p><?php endif; ?>
            <h2>Documents to prepare</h2>
            <ul class="check-list"><?php foreach ($visa['documents'] ?? [] as $item): ?><li><?= icon('check') ?><?= e((string) $item) ?></li><?php endforeach; ?></ul>
            <h2>How it moves</h2>
            <?php foreach ($visa['steps'] ?? [] as $step): ?><h3><?= e((string) $step['title']) ?></h3><p><?= e((string) $step['text']) ?></p><?php endforeach; ?>
            <a class="btn btn--primary" href="<?= e(url('/enquire?visa=' . rawurlencode((string) $visa['country']) . '&kind=visa')) ?>">Apply via WhatsApp</a>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
