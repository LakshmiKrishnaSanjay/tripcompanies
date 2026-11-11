<?php
declare(strict_types=1);

function site(?string $key = null, mixed $default = null): mixed
{
    global $site;
    if ($key === null) {
        return $site;
    }
    return $site[$key] ?? $default;
}

function e(string|int|float|null $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function url(string $path = '/'): string
{
    $base = rtrim((string) BASE_PATH, '/');
    $path = '/' . ltrim($path, '/');
    if ($path === '/') {
        return $base === '' ? '/' : $base . '/';
    }
    return $base . $path;
}

function absolute_url(string $path): string
{
    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
        return $path;
    }
    return rtrim((string) site('url'), '/') . url($path);
}

function asset(string $path): string
{
    $href = url('/assets/' . ltrim($path, '/'));
    $sep = str_contains($href, '?') ? '&' : '?';
    return $href . $sep . 'v=' . ASSET_VERSION;
}

function image_srcset(string $url): string
{
    if (!preg_match('#images\.unsplash\.com/(photo-[A-Za-z0-9\-]+)#', $url, $match)) {
        return '';
    }
    $id = $match[1];
    $parts = [];
    foreach ([640, 1024, 1600, 2400] as $width) {
        $parts[] = 'https://images.unsplash.com/' . $id
            . '?auto=format&fit=crop&fm=webp&q=75&w=' . $width . ' ' . $width . 'w';
    }
    return implode(', ', $parts);
}

function editorial_title(string $title, string $emphasis = ''): string
{
    $html = e($title);
    if ($emphasis !== '' && str_contains($title, $emphasis)) {
        $html = str_replace(e($emphasis), '<em>' . e($emphasis) . '</em>', $html);
    }
    return $html;
}

function current_path(): string
{
    $uri = parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH);
    $uri = is_string($uri) && $uri !== '' ? $uri : '/';
    $base = rtrim((string) BASE_PATH, '/');
    if ($base !== '' && str_starts_with($uri, $base)) {
        $uri = substr($uri, strlen($base)) ?: '/';
    }
    $uri = '/' . trim($uri, '/');
    if ($uri === '/index.php' || $uri === '/index') {
        return '/';
    }
    $routed = [
        'package.php' => '/packages',
        'deal.php' => '/deals',
        'destination.php' => '/destinations',
        'experience.php' => '/inbound',
        'visa-country.php' => '/visa',
        'post.php' => '/blog',
    ];
    foreach ($routed as $file => $base) {
        if ($uri === '/' . $file || str_ends_with($uri, '/' . $file)) {
            $slug = sanitize_slug((string) ($_GET['slug'] ?? ''));
            return $slug !== '' ? $base . '/' . $slug : $base;
        }
    }
    $uri = preg_replace('/\.php$/', '', $uri) ?? $uri;
    return $uri === '/' ? '/' : rtrim($uri, '/');
}

function nav_is_active(string $href): bool
{
    $path = current_path();
    if ($href === '/') {
        return $path === '/';
    }
    $href = rtrim($href, '/');
    return $path === $href || str_starts_with($path, $href . '/');
}

function wa_link(string $message): string
{
    $number = preg_replace('/\D+/', '', (string) site('whatsapp')) ?? '';
    return 'https://wa.me/' . $number . '?text=' . rawurlencode($message);
}

function visa_note_html(string $note, string $context): string
{
    $note = trim($note);
    if ($note === '') {
        $note = "Visa requirements depend on your nationality and UAE residency. Message us on WhatsApp and we'll check for you.";
    }
    $href = wa_link('Hi Tripcompanies, please check the visa requirements for ' . $context . '.');
    $safe = e($note);
    $link = '<a href="' . e($href) . '">WhatsApp</a>';
    if (str_contains($safe, 'WhatsApp')) {
        return str_replace('WhatsApp', $link, $safe);
    }
    return $safe . ' ' . $link;
}

function load_data(string $file): array
{
    static $cache = [];
    if (!isset($cache[$file])) {
        $path = ROOT_PATH . '/data/' . basename($file) . '.php';
        $data = is_file($path) ? require $path : [];
        $cache[$file] = is_array($data) ? $data : [];
    }
    return $cache[$file];
}

function packages_all(): array
{
    return load_data('packages');
}

function packages_by_type(string $type): array
{
    return array_values(array_filter(
        packages_all(),
        static fn(array $package): bool => ($package['type'] ?? 'outbound') === $type
    ));
}

function find_package(string $slug): ?array
{
    foreach (packages_all() as $package) {
        if (($package['slug'] ?? '') === $slug) {
            return $package;
        }
    }
    return null;
}

function sanitize_slug(string $slug): string
{
    $slug = strtolower(trim($slug));
    return preg_match('/^[a-z0-9-]{1,80}$/', $slug) === 1 ? $slug : '';
}

function visas(): array
{
    $data = load_data('visas');
    $countries = $data['countries'] ?? [];
    return is_array($countries) ? $countries : [];
}

function visa_faqs(): array
{
    $data = load_data('visas');
    $faqs = $data['faqs'] ?? [];
    return is_array($faqs) ? $faqs : [];
}

function experiences(): array
{
    return load_data('experiences');
}

function duration_label(array $package): string
{
    return (int) ($package['nights'] ?? 0) . 'N / ' . (int) ($package['days'] ?? 0) . 'D';
}

function price_label(array $package): string
{
    $currency = (string) ($package['currency'] ?? 'AED');
    $amount = number_format((float) ($package['price_from'] ?? 0), 0);
    return $currency . ' ' . $amount;
}

function season_label(string $season): string
{
    return ucfirst($season);
}

function region_label(string $region): string
{
    if (function_exists('regions')) {
        $regions = regions();
        if (isset($regions[$region])) {
            return $regions[$region];
        }
    }
    return match ($region) {
        'middle-east' => 'Middle East',
        'uae' => 'UAE',
        default => ucfirst(str_replace('-', ' ', $region)),
    };
}

function package_url(array $package): string
{
    return url('/packages/' . ($package['slug'] ?? ''));
}

function clip(string $value, int $max): string
{
    if (function_exists('mb_substr')) {
        return mb_substr($value, 0, $max);
    }
    return substr($value, 0, $max);
}

function clean_text(string $value, int $max = 2000): string
{
    $value = str_replace(["\0", "\r"], '', $value);
    $value = trim(strip_tags($value));
    return clip($value, $max);
}

function clean_line(string $value, int $max = 200): string
{
    $value = str_replace(["\r", "\n", "%0a", "%0A", "%0d", "%0D"], ' ', $value);
    return clean_text($value, $max);
}

function ensure_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    $secure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => (BASE_PATH === '' ? '/' : BASE_PATH),
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => $secure,
    ]);
    session_start();
}

function flash_set(string $key, mixed $value): void
{
    ensure_session();
    $_SESSION['_flash'][$key] = $value;
}

function flash_get(string $key, mixed $default = null): mixed
{
    ensure_session();
    if (!isset($_SESSION['_flash'][$key])) {
        return $default;
    }
    $value = $_SESSION['_flash'][$key];
    unset($_SESSION['_flash'][$key]);
    return $value;
}

function travel_months(): array
{
    $months = [];
    $start = new DateTimeImmutable('first day of this month');
    for ($i = 0; $i < 12; $i++) {
        $months[] = $start->modify('+' . $i . ' months')->format('F');
    }
    return $months;
}

function traveller_options(): array
{
    $options = [];
    for ($i = 1; $i <= 12; $i++) {
        $options[] = (string) $i;
    }
    $options[] = '13+';
    return $options;
}

/**
 * @param array<string, mixed> $post
 * @return array{errors: array<string, string>, old: array<string, string>}
 */
function validate_enquiry(array $post): array
{
    $name = clean_line((string) ($post['name'] ?? ''), 80);
    $phone = clean_line((string) ($post['phone'] ?? ''), 30);
    $destination = clean_line((string) ($post['destination'] ?? ''), 80);
    $month = clean_line((string) ($post['travel_month'] ?? ''), 30);
    $travellers = clean_line((string) ($post['travellers'] ?? ''), 4);
    $message = clean_text((string) ($post['message'] ?? ''), 2000);

    $errors = [];

    if (preg_match("/^[\p{L}\p{M}][\p{L}\p{M}\s.'-]{1,79}$/u", $name) !== 1) {
        $errors['name'] = 'Please enter the name we should use.';
    }

    $digits = preg_replace('/\D+/', '', $phone) ?? '';
    if (strlen($digits) < 7 || strlen($digits) > 15) {
        $errors['phone'] = 'Enter a phone number with the country code.';
    }

    if (preg_match("/^[\p{L}\p{M}0-9][\p{L}\p{M}0-9\s.'&,+\-\/]{1,79}$/u", $destination) !== 1) {
        $errors['destination'] = 'Tell us where you would like to go.';
    }

    if (!in_array($month, travel_months(), true)) {
        $errors['travel_month'] = 'Choose a travel month.';
    }

    if (!in_array($travellers, traveller_options(), true)) {
        $errors['travellers'] = 'Choose how many people are travelling.';
    }

    $messageLength = function_exists('mb_strlen') ? mb_strlen($message) : strlen($message);
    if ($messageLength < 10) {
        $errors['message'] = 'Add a few words about the trip you have in mind.';
    }

    return [
        'errors' => $errors,
        'old' => [
            'name' => $name,
            'phone' => $phone,
            'destination' => $destination,
            'travel_month' => $month,
            'travellers' => $travellers,
            'message' => $message,
        ],
    ];
}

/**
 * Plain-text mailer. Replace the body of this function with PHPMailer
 * if the host requires SMTP — the rest of the form can stay as it is.
 *
 * @param array<string, string> $fields
 */
function send_enquiry_mail(array $fields): bool
{
    $to = (string) site('email');
    $from = (string) site('mail_from');
    $subjectRaw = 'Website enquiry: ' . $fields['destination'];
    $subject = '=?UTF-8?B?' . base64_encode($subjectRaw) . '?=';

    $body = implode("\n", [
        'New enquiry from the Tripcompanies website',
        '------------------------------------------',
        'Name: ' . $fields['name'],
        'Phone: ' . $fields['phone'],
        'Destination: ' . $fields['destination'],
        'Travel month: ' . $fields['travel_month'],
        'Travellers: ' . $fields['travellers'],
        '',
        'Message:',
        $fields['message'],
        '',
        'Sent: ' . date('Y-m-d H:i') . ' Asia/Dubai',
    ]);

    $headers = implode("\r\n", [
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'From: Tripcompanies <' . $from . '>',
        'Reply-To: ' . $to,
        'X-Mailer: PHP/' . PHP_VERSION,
    ]);

    // mail() warns when the host has no local mailer. The form already
    // shows a proper error, so that warning must not leak into the page.
    $sent = false;
    set_error_handler(static function (): bool {
        return true;
    });
    try {
        $sent = mail($to, $subject, $body, $headers);
    } finally {
        restore_error_handler();
    }

    return $sent;
}

function enquiry_whatsapp_message(array $fields): string
{
    return implode("\n", [
        "Hi Tripcompanies, I would like to enquire.",
        '',
        'Name: ' . ($fields['name'] ?? ''),
        'Phone: ' . ($fields['phone'] ?? ''),
        'Destination: ' . ($fields['destination'] ?? ''),
        'Travel month: ' . ($fields['travel_month'] ?? ''),
        'Travellers: ' . ($fields['travellers'] ?? ''),
        'Message: ' . ($fields['message'] ?? ''),
    ]);
}

function json_ld(array $data): string
{
    $flags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT;
    $json = json_encode($data, $flags);
    return is_string($json) ? $json : '{}';
}

function icon(string $name, string $class = 'icon'): string
{
    $common = 'viewBox="0 0 24 24" aria-hidden="true" focusable="false"';
    $classAttr = e($class);

    if ($name === 'whatsapp') {
        return '<svg class="' . $classAttr . '" ' . $common . ' fill="currentColor"><path d="M12.04 2C6.58 2 2.15 6.4 2.15 11.83c0 1.74.46 3.44 1.34 4.94L2 22l5.39-1.41a10.1 10.1 0 0 0 4.65 1.12h.01c5.46 0 9.89-4.4 9.89-9.83C21.94 6.4 17.5 2 12.04 2zm5.68 13.99c-.24.67-1.39 1.23-1.92 1.31-.49.07-1.12.11-1.81-.11-.42-.14-.95-.31-1.64-.61-2.86-1.24-4.73-4.12-4.87-4.31-.14-.19-1.15-1.53-1.15-2.92 0-1.39.73-2.07.99-2.36.24-.27.64-.4.85-.4h.2c.17 0 .4-.01.61.46.23.55.8 1.91.87 2.05.07.14.12.3.02.48-.09.18-.14.3-.28.46-.14.16-.29.36-.42.49-.14.13-.28.28-.12.54.16.26.7 1.15 1.5 1.87 1.03.91 1.9 1.2 2.17 1.34.27.13.43.11.59-.07.16-.18.67-.78.85-1.05.18-.27.36-.22.6-.13.25.09 1.56.74 1.83.87.27.14.45.2.51.31.07.11.07.63-.17 1.3z"/></svg>';
    }

    if ($name === 'star') {
        return '<svg class="' . $classAttr . '" ' . $common . ' fill="currentColor"><path d="M12 2.6 14.7 8.9 21.5 9.6 16.4 14.2 17.9 21 12 17.6 6.1 21 7.6 14.2 2.5 9.6 9.3 8.9 12 2.6z"/></svg>';
    }

    $paths = [
        'plane' => '<path d="M22 2 11 13"/><path d="M22 2 15 22 11 13 2 9 22 2z"/>',
        'pin' => '<path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0z"/><circle cx="12" cy="10" r="2.5"/>',
        'check' => '<path d="m5 12 5 5L20 7"/>',
        'arrow' => '<path d="M5 12h14"/><path d="m13 6 6 6-6 6"/>',
        'chevron-right' => '<path d="m8 5 8 7-8 7"/>',
        'chevron' => '<path d="m6 9 6 6 6-6"/>',
        'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'shield' => '<path d="M12 3 20 7v6c0 4.5-3.2 7.2-8 8.5C7.2 20.2 4 17.5 4 13V7l8-4z"/>',
        'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>',
        'phone' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.33 1.9.6 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.27 1.85.47 2.81.6A2 2 0 0 1 22 16.92z"/>',
        'mail' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
        'menu' => '<path d="M4 7h16M4 12h16M4 17h16"/>',
        'close' => '<path d="M6 6 18 18M18 6 6 18"/>',
        'globe' => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3a14 14 0 0 1 0 18"/><path d="M12 3a14 14 0 0 0 0 18"/>',
        'compass' => '<circle cx="12" cy="12" r="9"/><path d="m16.2 7.8-2.3 6.1-6.1 2.3 2.3-6.1 6.1-2.3z"/>',
        'users' => '<path d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/><circle cx="9.5" cy="7" r="3"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a3 3 0 0 1 0 5.74"/>',
        'bed' => '<path d="M3 18V9"/><path d="M3 14h18v4"/><path d="M21 14V9a2 2 0 0 0-2-2H11"/><path d="M7 11a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>',
        'sun' => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>',
        'moon' => '<path d="M21 14.5A8.5 8.5 0 1 1 9.5 3 7 7 0 0 0 21 14.5z"/>',
        'passport' => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="M8 13h8M8 17h5"/>',
        'message' => '<path d="M21 11.5a8.4 8.4 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.4 8.4 0 0 1-3.8-.9L3 21l1.9-5.7a8.4 8.4 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.4 8.4 0 0 1 3.8-.9h.5a8.5 8.5 0 0 1 8 8z"/>',
        'search' => '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>',
        'heart' => '<path d="M19.5 12.6 12 20l-7.5-7.4a4.5 4.5 0 0 1 6.4-6.3L12 7.4l1.1-1.1a4.5 4.5 0 0 1 6.4 6.3z"/>',
        'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/>',
    ];

    if (!isset($paths[$name])) {
        return '';
    }

    return '<svg class="' . $classAttr . '" ' . $common . ' fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">' . $paths[$name] . '</svg>';
}

function partial(string $name, array $vars = []): void
{
    $name = basename($name);
    $file = ROOT_PATH . '/includes/components/' . $name . '.php';
    if (!is_file($file)) {
        trigger_error('Missing component: ' . $name, E_USER_WARNING);
        return;
    }
    (static function (string $__file, array $__vars): void {
        extract($__vars, EXTR_SKIP);
        include $__file;
    })($file, $vars);
}
