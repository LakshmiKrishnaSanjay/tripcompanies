<?php
declare(strict_types=1);

$pageTitle = trim((string) ($pageTitle ?? site('name')));
$fullTitle = str_contains(strtolower($pageTitle), 'tripcompanies')
    ? $pageTitle
    : $pageTitle . ' | Tripcompanies';

$pageDescription = trim((string) ($pageDescription ?? site('description')));
$canonicalPath = (string) ($pageCanonical ?? current_path());
$canonical = rtrim((string) site('url'), '/') . ($canonicalPath === '/' ? '/' : $canonicalPath);
$robots = (string) ($robots ?? 'index, follow');
$ogImage = absolute_url((string) ($pageOgImage ?? url('/assets/img/og-image.jpg')));
$bodyClass = trim((string) ($bodyClass ?? ''));
$hasHero = $hasHero ?? true;
$bodyClasses = trim(($hasHero ? 'has-hero ' : '') . $bodyClass);

$schemaGraph = [
    [
        '@type' => 'TravelAgency',
        '@id' => rtrim((string) site('url'), '/') . '/#agency',
        'name' => site('name'),
        'url' => site('url'),
        'logo' => absolute_url(url('/assets/img/logo-ink.png')),
        'image' => absolute_url(url('/assets/img/og-image.jpg')),
        'description' => site('description'),
        'telephone' => site('phone_tel'),
        'email' => site('email'),
        'priceRange' => 'AED',
        'currenciesAccepted' => 'AED',
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => site('city'),
            'addressCountry' => site('country_code'),
        ],
        'areaServed' => 'United Arab Emirates',
        'sameAs' => [site('instagram')],
    ],
];

if (!empty($pageSchemas) && is_array($pageSchemas)) {
    foreach ($pageSchemas as $schema) {
        if (is_array($schema)) {
            $schemaGraph[] = $schema;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($fullTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">
    <link rel="canonical" href="<?= e($canonical) ?>">
    <meta name="robots" content="<?= e($robots) ?>">
    <meta name="color-scheme" content="dark light">
    <meta name="theme-color" content="#FAF7F2">
    <script>
      (function () {
        try {
          var t = localStorage.getItem('tc-theme-mode');
          document.documentElement.setAttribute('data-theme', t || 'light');
        } catch (e) {
          document.documentElement.setAttribute('data-theme', 'light');
        }
        var meta = document.querySelector('meta[name="theme-color"]');
        if (meta) {
          meta.setAttribute('content', document.documentElement.getAttribute('data-theme') === 'light' ? '#FAF7F2' : '#08060A');
        }
      })();
    </script>
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_AE">
    <meta property="og:site_name" content="<?= e(site('name')) ?>">
    <meta property="og:title" content="<?= e($fullTitle) ?>">
    <meta property="og:description" content="<?= e($pageDescription) ?>">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <meta property="og:image" content="<?= e($ogImage) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($fullTitle) ?>">
    <meta name="twitter:description" content="<?= e($pageDescription) ?>">
    <meta name="twitter:image" content="<?= e($ogImage) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,500;1,600&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <?php if (!empty($pagePreload)): ?>
        <link rel="preload" as="image" href="<?= e((string) $pagePreload) ?>" fetchpriority="high">
    <?php endif; ?>
    <link rel="stylesheet" href="<?= e(asset('css/style.css')) ?>">
    <link rel="icon" href="<?= e(asset('img/logo-ink.png')) ?>" type="image/png">
    <script type="application/ld+json"><?= json_ld(['@context' => 'https://schema.org', '@graph' => $schemaGraph]) ?></script>
    <script>document.documentElement.classList.replace('no-js', 'js');</script>
</head>
<body class="<?= e($bodyClasses) ?>">
