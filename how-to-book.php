<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
$pageTitle = 'How to book a holiday';
$pageDescription = 'How a Tripcompanies holiday moves from the first WhatsApp message to the airport.';
$pageCanonical = '/how-to-book';
$hasHero = false;
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">
    <section class="section">
        <div class="container prose">
            <?php partial('breadcrumbs', ['items' => [['label' => 'Home', 'href' => '/'], ['label' => 'How to book']]]); ?>
            <h1 style="font-size: clamp(2.6rem, 5vw, 4.4rem);">How to book</h1>
            <?php foreach (site('steps') as $index => $step): ?>
                <h2><?= e((string) ($index + 1)) ?>. <?= e((string) $step['title']) ?></h2>
                <p><?= e((string) $step['text']) ?></p>
            <?php endforeach; ?>
            <p>Packages on the site are starting points. The quote you accept on WhatsApp is the booking. There is no online payment on this website.</p>
            <a class="btn btn--primary" href="<?= e(url('/custom-trip')) ?>">Start a request</a>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
