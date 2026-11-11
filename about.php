<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
$pageTitle = 'About Tripcompanies';
$pageDescription = 'Tripcompanies is a Dubai desk for holiday packages, planned for people living in the UAE.';
$pageCanonical = '/about';
$hasHero = false;
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">
    <section class="section">
        <div class="container prose">
            <?php partial('breadcrumbs', ['items' => [['label' => 'Home', 'href' => '/'], ['label' => 'About']]]); ?>
            <p class="eyebrow"><?= e((string) site('tagline')) ?></p>
            <h1 style="font-size: clamp(2.6rem, 5vw, 4.4rem);">A Dubai desk for holidays abroad</h1>
            <p>Tripcompanies plans holiday packages for people living in the UAE.<?php if (feature_on('FEATURE_INBOUND')): ?> UAE experiences for arriving travellers sit in the same desk.<?php endif; ?><?php if (feature_on('FEATURE_VISA')): ?> Visa support can sit in the same conversation when you ask for it.<?php endif; ?></p>
            <p>There is no checkout on this website. You tell us the destination, the month and who is travelling. We reply on WhatsApp with a route and a price.</p>
            <?php if (trust_has('office_address')): ?><p><?= e((string) trust('office_address')) ?></p><?php else: ?><p><?= e((string) site('location')) ?></p><?php endif; ?>
            <p><a href="mailto:<?= e((string) site('email')) ?>"><?= e((string) site('email')) ?></a></p>
            <a class="btn btn--primary" href="<?= e(wa_link('Hi Tripcompanies, I would like to know more about the desk.')) ?>">WhatsApp the desk</a>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
