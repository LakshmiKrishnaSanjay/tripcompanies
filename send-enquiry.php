<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Location: ' . url('/contact'), true, 303);
    exit;
}

ensure_session();
$type = one_of((string) ($_POST['type'] ?? 'enquiry'), ['enquiry', 'callback', 'custom', 'newsletter']);
if ($type === '') {
    $type = 'enquiry';
}
$return = (string) ($_POST['return'] ?? '/contact');
if (!str_starts_with($return, '/') || str_starts_with($return, '//') || str_contains($return, "\n")) {
    $return = '/contact';
}
$redirect = url($return);

$honeypot = $_POST['company_website'] ?? '';
if (!is_string($honeypot) || $honeypot !== '') {
    $_SESSION['enquiry_at'] = time();
    flash_set('enquiry', ['status' => 'success']);
    header('Location: ' . $redirect, true, 303);
    exit;
}

$now = time();
$last = $_SESSION['enquiry_at'] ?? 0;
if (is_numeric($last) && ($now - (int) $last) < 45) {
    flash_set('enquiry', [
        'status' => 'error',
        'errors' => ['form' => 'Please wait a moment before sending another note. You can also WhatsApp us directly.'],
        'old' => [],
    ]);
    header('Location: ' . $redirect, true, 303);
    exit;
}

if ($type === 'newsletter') {
    $email = clean_line((string) ($_POST['email'] ?? ''), 120);
    $consent = (string) ($_POST['consent'] ?? '');
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false || $consent !== 'yes') {
        flash_set('enquiry', ['status' => 'error', 'errors' => ['form' => 'Add a valid email and tick the consent box.'], 'old' => []]);
        header('Location: ' . $redirect, true, 303);
        exit;
    }
    $sent = send_enquiry_mail([
        'name' => 'Newsletter',
        'phone' => '',
        'destination' => 'Newsletter',
        'travel_month' => '',
        'travellers' => '',
        'message' => 'Please add this address to trip notes: ' . $email,
    ]);
} else {
    $checked = validate_enquiry($_POST);
    if ($type === 'custom') {
        $checked['old']['message'] = trim(
            'Budget: ' . clean_line((string) ($_POST['budget'] ?? ''), 40) . "\n"
            . 'Style: ' . clean_line((string) ($_POST['style'] ?? ''), 40) . "\n"
            . 'Hotel: ' . clean_line((string) ($_POST['hotel'] ?? ''), 80) . "\n"
            . $checked['old']['message']
        );
        $checked['old']['destination'] = $type === 'custom' ? $checked['old']['destination'] : $checked['old']['destination'];
    }
    if ($checked['errors'] !== []) {
        flash_set('enquiry', ['status' => 'error', 'errors' => $checked['errors'], 'old' => $checked['old']]);
        header('Location: ' . $redirect, true, 303);
        exit;
    }
    if ($type === 'callback') {
        $checked['old']['destination'] = 'Callback: ' . $checked['old']['destination'];
    }
    $sent = send_enquiry_mail($checked['old']);
    if (!$sent) {
        flash_set('enquiry', [
            'status' => 'error',
            'errors' => ['form' => 'We could not send that email just now. Please WhatsApp us. The desk will pick it up there.'],
            'old' => $checked['old'],
        ]);
        header('Location: ' . $redirect, true, 303);
        exit;
    }
}

if ($type === 'newsletter' && empty($sent)) {
    flash_set('enquiry', ['status' => 'error', 'errors' => ['form' => 'We could not save that email just now. Please WhatsApp us.'], 'old' => []]);
    header('Location: ' . $redirect, true, 303);
    exit;
}

$_SESSION['enquiry_at'] = $now;
flash_set('enquiry', ['status' => 'success']);
header('Location: ' . $redirect, true, 303);
exit;
