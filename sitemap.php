<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';

header('Content-Type: application/xml; charset=UTF-8');

$paths = ['/', '/packages', '/deals', '/destinations', '/outbound', '/custom-trip', '/about', '/how-to-book', '/faq', '/blog', '/contact', '/terms', '/privacy', '/cancellation-policy'];
if (feature_on('FEATURE_INBOUND')) {
    $paths[] = '/inbound';
}
if (feature_on('FEATURE_VISA')) {
    $paths[] = '/visa';
}
foreach (packages_public() as $package) {
    $paths[] = '/packages/' . $package['slug'];
}
foreach (deals_all() as $deal) {
    $paths[] = '/deals/' . $deal['slug'];
}
foreach (destinations_all() as $destination) {
    $paths[] = '/destinations/' . $destination['slug'];
}
if (feature_on('FEATURE_INBOUND')) {
    foreach (experiences_all() as $experience) {
        $paths[] = '/inbound/' . $experience['slug'];
    }
}
if (feature_on('FEATURE_VISA')) {
    foreach (visas_all() as $visa) {
        $paths[] = '/visa/' . $visa['slug'];
    }
}
foreach (posts_all() as $post) {
    $paths[] = '/blog/' . $post['slug'];
}

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
foreach (array_values(array_unique($paths)) as $path) {
    echo '<url><loc>' . e(absolute_url($path)) . '</loc></url>';
}
echo '</urlset>';
