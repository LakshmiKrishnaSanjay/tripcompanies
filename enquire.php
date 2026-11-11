<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';

$slug = sanitize_slug((string) ($_GET['package_slug'] ?? ''));
$package = $slug !== '' ? find_public_package($slug) : null;
$fields = [
    'package' => $package['title'] ?? clean_line((string) ($_GET['package'] ?? ''), 120),
    'experience' => clean_line((string) ($_GET['experience'] ?? ''), 120),
    'visa' => clean_line((string) ($_GET['visa'] ?? ''), 120),
    'destination' => clean_line((string) ($_GET['destination'] ?? ''), 120),
    'month' => clean_line((string) ($_GET['month'] ?? $_GET['travel_month'] ?? ''), 40),
    'adults' => clean_line((string) ($_GET['adults'] ?? ''), 12),
    'children' => clean_line((string) ($_GET['children'] ?? ''), 12),
    'travellers' => clean_line((string) ($_GET['travellers'] ?? ''), 12),
    'name' => clean_line((string) ($_GET['name'] ?? ''), 80),
    'phone' => clean_line((string) ($_GET['phone'] ?? ''), 30),
    'budget' => clean_line((string) ($_GET['budget'] ?? ''), 40),
    'style' => clean_line((string) ($_GET['style'] ?? ''), 40),
    'hotel' => clean_line((string) ($_GET['hotel'] ?? ''), 80),
    'notes' => clean_line((string) ($_GET['message'] ?? $_GET['notes'] ?? ''), 500),
];
if ($fields['package'] === '' && $fields['experience'] === '' && $fields['visa'] === '' && $fields['destination'] === '') {
    $fields['notes'] = trim($fields['notes'] . ' Website enquiry');
}
header('Location: ' . wa_link(enquire_message($fields)), true, 302);
exit;
