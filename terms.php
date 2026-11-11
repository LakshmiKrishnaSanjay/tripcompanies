<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';

$pageTitle = 'Terms of use';
$pageDescription = 'Placeholder terms for Tripcompanies, pending the client legal review.';
$pageCanonical = '/terms';
$hasHero = false;
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main"><section class="section"><div class="container prose">
    <p class="sample-note">Placeholder text for the client's legal review. Do not treat this page as final legal advice.</p>
    <h1>Terms of use</h1>
    <p>This website introduces Tripcompanies holiday packages for people living in the UAE.<?php if (feature_on('FEATURE_INBOUND')): ?> It also introduces UAE experiences.<?php endif; ?><?php if (feature_on('FEATURE_VISA')): ?> Visa support can be part of the same request.<?php endif; ?> It is not a checkout. A trip is confirmed only when you accept a quote from the desk.</p>
    <p>Package prices shown here are starting points, and sample trips are marked as samples. The figure in the WhatsApp quote replaces anything on the page.</p>
    <?php if (feature_on('FEATURE_VISA')): ?><p>Visa services prepare documents. They do not decide applications. That decision belongs to the embassy or immigration authority.</p><?php endif; ?>
</div></section></main>
<?php require __DIR__ . '/includes/footer.php'; ?>
