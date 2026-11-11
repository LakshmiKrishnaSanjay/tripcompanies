<?php
declare(strict_types=1);

/**
 * Bootstrap. Every page includes this file once.
 * BASE_PATH stays empty when the site lives at the domain root.
 * If you upload into a subfolder, set BASE_PATH to '/that-folder'.
 */
error_reporting(E_ALL);

$tripHost = strtolower((string) ($_SERVER['SERVER_NAME'] ?? ''));
$tripLocal = in_array($tripHost, ['localhost', '127.0.0.1', '::1'], true);
ini_set('display_errors', $tripLocal ? '1' : '0');
ini_set('log_errors', '1');
unset($tripHost, $tripLocal);

date_default_timezone_set('Asia/Dubai');

define('ROOT_PATH', dirname(__DIR__));
define('BASE_PATH', '');
define('ASSET_VERSION', '74');
define('SHOW_SAMPLE_CONTENT', true);

const FEATURE_INBOUND = true;
const FEATURE_VISA = true;

$site = require ROOT_PATH . '/data/site.php';

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/catalog.php';
