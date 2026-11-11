<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';

http_response_code(404);
$pageTitle = 'Page not found';
$pageDescription = 'That page is not on the Tripcompanies site. Start again from the home page or message the Dubai desk.';
$pageCanonical = '/404';
$robots = 'noindex, follow';

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">
    <?php partial('not-found'); ?>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
