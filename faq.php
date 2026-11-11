<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
$groups = faqs_all();
$pairs = [];
foreach ($groups as $group) {
    foreach ($group['items'] as $item) {
        $pairs[] = $item;
    }
}
$pageTitle = 'Travel questions';
$pageDescription = 'Answers about booking holiday packages from Dubai and how prices work at Tripcompanies.';
$pageCanonical = '/faq';
$hasHero = false;
$pageSchemas = $pairs !== [] ? [faq_schema($pairs)] : [];
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">
    <section class="section">
        <div class="container">
            <?php partial('breadcrumbs', ['items' => [['label' => 'Home', 'href' => '/'], ['label' => 'FAQ']]]); ?>
            <div class="faq-page__head">
                <h1 style="font-size: clamp(2.6rem, 5vw, 4.4rem);">Questions</h1>
                <p class="lead">Booking, prices, the places we plan, and what a sample holiday includes. If yours is not here, message the desk.</p>
            </div>
            <?php if ($groups === []): ?>
                <p class="notice">No questions are published yet. Message the desk instead.</p>
            <?php else: ?>
                <nav class="faq-jump" aria-label="Question topics">
                    <?php foreach ($groups as $group): ?>
                        <?php $id = (string) ($group['id'] ?? strtolower((string) preg_replace('/[^a-z0-9]+/i', '-', (string) $group['topic']))); ?>
                        <a href="#<?= e($id) ?>"><?= e((string) $group['topic']) ?></a>
                    <?php endforeach; ?>
                </nav>
                <div class="faq-page">
                    <?php foreach ($groups as $group): ?>
                        <?php $id = (string) ($group['id'] ?? strtolower((string) preg_replace('/[^a-z0-9]+/i', '-', (string) $group['topic']))); ?>
                        <section id="<?= e($id) ?>">
                            <h2><?= e((string) $group['topic']) ?></h2>
                            <?php foreach ($group['items'] as $item): ?>
                                <details class="faq"><summary><span><?= e((string) $item['q']) ?></span></summary><p><?= e((string) $item['a']) ?></p></details>
                            <?php endforeach; ?>
                        </section>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <section class="section section--sand faq-close">
        <div class="container">
            <h2>Still deciding</h2>
            <div class="faq-next">
                <a class="panel" href="<?= e(url('/how-to-book')) ?>"><span class="kicker">Steps</span><strong>How to book</strong><span>From the first message to the airport.</span></a>
                <a class="panel" href="<?= e(url('/custom-trip')) ?>"><span class="kicker">Custom</span><strong>Plan a custom trip</strong><span>Name the places, the month and who is travelling.</span></a>
                <a class="panel" href="<?= e(url('/packages')) ?>"><span class="kicker">Holidays</span><strong>Browse packages</strong><span>Sample routes from Dubai, ready to adjust.</span></a>
            </div>
            <p class="faq-next__note"><a class="btn btn--primary" href="<?= e(wa_link('Hi Tripcompanies, I have a question about a holiday.')) ?>">Message on WhatsApp</a></p>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
