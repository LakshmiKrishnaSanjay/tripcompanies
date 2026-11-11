<?php
declare(strict_types=1);

/**
 * Local preview only: php -S localhost:8080 router.php
 * Apache ignores this file. On a normal host, .htaccess does the routing.
 */
if (PHP_SAPI !== 'cli-server') {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$uri = is_string($uri) && $uri !== '' ? $uri : '/';
$file = __DIR__ . str_replace('/', DIRECTORY_SEPARATOR, $uri);

if ($uri !== '/' && is_file($file)) {
    return false;
}

if (preg_match('#^/(data|includes)(/|$)#', $uri) === 1) {
    http_response_code(403);
    echo 'Forbidden';
    return true;
}

if (preg_match('#^/packages/([a-z0-9-]+)/?$#', $uri, $matches) === 1) {
    $_GET['slug'] = $matches[1];
    require __DIR__ . '/package.php';
    return true;
}

$routes = [
    '#^/deals/([a-z0-9-]+)/?$#' => 'deal.php',
    '#^/destinations/([a-z0-9-]+)/?$#' => 'destination.php',
    '#^/inbound/([a-z0-9-]+)/?$#' => 'experience.php',
    '#^/visa/([a-z0-9-]+)/?$#' => 'visa-country.php',
    '#^/blog/([a-z0-9-]+)/?$#' => 'post.php',
];
foreach ($routes as $pattern => $script) {
    if (preg_match($pattern, $uri, $matches) === 1) {
        $_GET['slug'] = $matches[1];
        require __DIR__ . '/' . $script;
        return true;
    }
}

if ($uri === '/sitemap.xml') {
    require __DIR__ . '/sitemap.php';
    return true;
}

$clean = trim($uri, '/');
if ($clean === '' || $clean === 'index') {
    require __DIR__ . '/index.php';
    return true;
}

if ($clean === 'router') {
    http_response_code(404);
    require __DIR__ . '/404.php';
    return true;
}

$script = __DIR__ . DIRECTORY_SEPARATOR . $clean . '.php';
if (is_file($script)) {
    require $script;
    return true;
}

http_response_code(404);
require __DIR__ . '/404.php';
return true;
