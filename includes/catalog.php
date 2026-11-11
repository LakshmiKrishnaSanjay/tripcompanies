<?php
declare(strict_types=1);

function sample_allowed(): bool
{
    return defined('SHOW_SAMPLE_CONTENT') && SHOW_SAMPLE_CONTENT;
}

function is_public_record(array $row): bool
{
    if (!empty($row['is_sample']) && !sample_allowed()) {
        return false;
    }
    return true;
}

/** @param array<int, array<string, mixed>> $rows */
function public_records(array $rows): array
{
    return array_values(array_filter($rows, 'is_public_record'));
}

function trust(?string $key = null, mixed $default = null): mixed
{
    $data = load_data('trust');
    if ($key === null) {
        return $data;
    }
    return $data[$key] ?? $default;
}

function trust_has(string $key): bool
{
    $value = trust($key);
    if (is_array($value)) {
        return $value !== [];
    }
    return $value !== null && $value !== '';
}

function trust_any(): bool
{
    foreach (['licence_number', 'years_in_business', 'travellers_served', 'google_rating', 'google_review_count', 'visa_success_rate', 'response_time', 'opening_hours', 'office_address', 'awards', 'partners'] as $key) {
        if (trust_has($key)) {
            return true;
        }
    }
    return false;
}

function one_of(mixed $value, array $allowed): string
{
    $value = is_string($value) ? $value : '';
    return in_array($value, $allowed, true) ? $value : '';
}

/** @return list<string> */
function many_of(mixed $value, array $allowed): array
{
    $items = is_array($value) ? $value : [$value];
    $picked = [];
    foreach ($items as $item) {
        if (is_string($item) && in_array($item, $allowed, true) && !in_array($item, $picked, true)) {
            $picked[] = $item;
        }
    }
    return $picked;
}

function destinations_all(): array
{
    return public_records(load_data('destinations'));
}

function find_destination(string $slug): ?array
{
    foreach (destinations_all() as $row) {
        if (($row['slug'] ?? '') === $slug) {
            return $row;
        }
    }
    return null;
}

function destination_name(string $slug): string
{
    $row = find_destination($slug);
    return $row ? (string) $row['name'] : '';
}

function feature_on(string $name): bool
{
    return defined($name) && constant($name) === true;
}

function regions(): array
{
    return [
        'south-caucasus' => 'South Caucasus',
        'central-asia' => 'Central Asia',
        'southeast-asia' => 'Southeast Asia',
        'western-asia' => 'Western Asia and Southeastern Europe',
        'east-africa' => 'East Africa',
    ];
}

function trip_types(): array
{
    return [
        'honeymoon' => 'Honeymoon',
        'family' => 'Family',
        'group' => 'Group Departures',
        'city' => 'City Breaks',
        'adventure' => 'Adventure',
        'luxury' => 'Luxury',
    ];
}

function deals_all(): array
{
    return public_records(load_data('deals'));
}

function deals_active(): array
{
    return array_values(array_filter(
        deals_all(),
        static fn(array $deal): bool => !empty($deal['active'])
    ));
}

function find_deal(string $slug): ?array
{
    foreach (deals_all() as $deal) {
        if (($deal['slug'] ?? '') === $slug) {
            return $deal;
        }
    }
    return null;
}

function promotions(): array
{
    $rows = public_records(load_data('promotions'));
    return array_values(array_filter($rows, static function (array $row): bool {
        $feature = (string) ($row['feature'] ?? '');
        if ($feature === 'inbound') {
            return feature_on('FEATURE_INBOUND');
        }
        if ($feature === 'visa') {
            return feature_on('FEATURE_VISA');
        }
        return true;
    }));
}

function reviews_all(): array
{
    return public_records(load_data('reviews'));
}

function reviews_for(string $slug): array
{
    if ($slug === '') {
        return reviews_all();
    }
    return array_values(array_filter(
        reviews_all(),
        static fn(array $row): bool => ($row['destination_slug'] ?? '') === $slug
    ));
}

function posts_all(): array
{
    $posts = public_records(load_data('posts'));
    usort($posts, static fn(array $a, array $b): int => strcmp((string) ($b['date'] ?? ''), (string) ($a['date'] ?? '')));
    return $posts;
}

function find_post(string $slug): ?array
{
    foreach (posts_all() as $post) {
        if (($post['slug'] ?? '') === $slug) {
            return $post;
        }
    }
    return null;
}

function faqs_all(): array
{
    $groups = load_data('faqs');
    $clean = [];
    foreach ($groups as $group) {
        if (!is_array($group)) {
            continue;
        }
        $items = [];
        foreach ($group['items'] ?? [] as $item) {
            if (is_array($item) && is_public_record($item)) {
                $items[] = $item;
            }
        }
        $feature = (string) ($group['feature'] ?? '');
        if ($feature === 'inbound' && !feature_on('FEATURE_INBOUND')) {
            continue;
        }
        if ($feature === 'visa' && !feature_on('FEATURE_VISA')) {
            continue;
        }
        if ($items !== []) {
            $group['items'] = $items;
            $clean[] = $group;
        }
    }
    return $clean;
}

function experiences_all(): array
{
    return public_records(load_data('experiences'));
}

function experience_categories(): array
{
    return ['Desert', 'City Tours', 'Cruises', 'Attractions', 'Theme Parks', 'Transfers'];
}

function find_experience(string $slug): ?array
{
    foreach (experiences_all() as $row) {
        if (($row['slug'] ?? '') === $slug) {
            return $row;
        }
    }
    return null;
}

function visas_all(): array
{
    return public_records(visas());
}

function find_visa(string $slug): ?array
{
    foreach (visas_all() as $visa) {
        if (($visa['slug'] ?? '') === $slug) {
            return $visa;
        }
    }
    return null;
}

function packages_public(): array
{
    return public_records(packages_all());
}

function find_public_package(string $slug): ?array
{
    $package = find_package($slug);
    if ($package === null || !is_public_record($package)) {
        return null;
    }
    return $package;
}

function season_from_month(string $month): string
{
    if ($month === '') {
        return '';
    }
    $time = strtotime('1 ' . $month);
    if ($time === false) {
        return '';
    }
    $n = (int) date('n', $time);
    return match (true) {
        $n === 12 || $n <= 2 => 'winter',
        $n <= 5 => 'spring',
        $n <= 8 => 'summer',
        default => 'autumn',
    };
}

function duration_band(array $package): string
{
    $nights = (int) ($package['nights'] ?? 0);
    if ($nights <= 4) {
        return 'short';
    }
    if ($nights <= 7) {
        return 'week';
    }
    return 'long';
}

function inclusion_catalog(): array
{
    return [
        'flights' => 'Flights',
        'hotel' => 'Hotel',
        'transfers' => 'Transfers',
        'sightseeing' => 'Sightseeing',
        'visa' => 'Visa',
    ];
}

function price_bands(): array
{
    return [
        '0-5000' => 'Up to AED 5,000',
        '5000-10000' => 'AED 5,000 to 10,000',
        '10000-plus' => 'AED 10,000 and above',
    ];
}

function package_query_from(array $source): array
{
    $rawDestination = clean_line((string) ($source['destination'] ?? ''), 80);
    $destinations = array_map(static fn(array $row): string => (string) $row['slug'], destinations_all());
    $destination = one_of($rawDestination, $destinations);
    if ($destination === '' && $rawDestination !== '') {
        foreach (destinations_all() as $row) {
            if (strcasecmp((string) ($row['name'] ?? ''), $rawDestination) === 0) {
                $destination = (string) $row['slug'];
                break;
            }
        }
    }
    $deals = array_map(static fn(array $row): string => (string) $row['slug'], deals_all());
    $months = travel_months();
    $inclusions = array_keys(inclusion_catalog());
    $month = one_of($source['month'] ?? '', $months);
    $season = one_of($source['season'] ?? '', ['winter', 'spring', 'summer', 'autumn']);
    if ($season === '' && $month !== '') {
        $season = season_from_month($month);
    }
    $sort = one_of($source['sort'] ?? '', ['recommended', 'price', 'duration']);
    $page = (int) ($source['page'] ?? 1);

    return [
        'destination' => $destination,
        'region' => one_of($source['region'] ?? '', array_keys(regions())),
        'season' => $season,
        'deal' => one_of($source['deal'] ?? '', $deals),
        'month' => $month,
        'type' => one_of($source['type'] ?? '', array_keys(trip_types())),
        'duration' => one_of($source['duration'] ?? '', ['short', 'week', 'long']),
        'price' => one_of($source['price'] ?? '', array_keys(price_bands())),
        'inclusions' => many_of($source['inclusions'] ?? [], $inclusions),
        'q' => clean_line((string) ($source['q'] ?? ''), 80),
        'sort' => $sort !== '' ? $sort : 'recommended',
        'page' => max(1, $page),
        'travellers' => one_of($source['travellers'] ?? '', traveller_options()),
        'view' => (($source['view'] ?? '') === 'wishlist') ? 'wishlist' : '',
    ];
}

function package_query(): array
{
    return package_query_from($_GET);
}

function package_matches(array $package, array $query): bool
{
    if ($query['destination'] !== '' && ($package['destination_slug'] ?? '') !== $query['destination']) {
        return false;
    }
    if ($query['region'] !== '' && ($package['region'] ?? '') !== $query['region']) {
        return false;
    }
    if ($query['season'] !== '') {
        $seasons = $package['seasons'] ?? [$package['season'] ?? ''];
        if (!in_array($query['season'], $seasons, true)) {
            return false;
        }
    }
    if ($query['deal'] !== '') {
        $deals = $package['deal_slugs'] ?? [];
        if (!in_array($query['deal'], $deals, true)) {
            return false;
        }
    }
    if ($query['type'] !== '') {
        $types = $package['trip_types'] ?? [];
        if (!in_array($query['type'], $types, true)) {
            return false;
        }
    }
    if ($query['duration'] !== '' && duration_band($package) !== $query['duration']) {
        return false;
    }
    if ($query['price'] !== '') {
        $price = (float) ($package['price_from'] ?? 0);
        $ok = match ($query['price']) {
            '0-5000' => $price <= 5000,
            '5000-10000' => $price > 5000 && $price <= 10000,
            '10000-plus' => $price > 10000,
            default => true,
        };
        if (!$ok) {
            return false;
        }
    }
    if ($query['inclusions'] !== []) {
        $icons = $package['inclusion_icons'] ?? [];
        foreach ($query['inclusions'] as $icon) {
            if (!in_array($icon, $icons, true)) {
                return false;
            }
        }
    }
    if ($query['q'] !== '') {
        $hay = strtolower(implode(' ', [
            (string) ($package['title'] ?? ''),
            destination_name((string) ($package['destination_slug'] ?? '')),
            (string) ($package['overview'] ?? ''),
        ]));
        if (!str_contains($hay, strtolower($query['q']))) {
            return false;
        }
    }
    return true;
}

function sort_packages(array $packages, string $sort): array
{
    usort($packages, static function (array $a, array $b) use ($sort): int {
        if ($sort === 'price') {
            return ((float) ($a['price_from'] ?? 0)) <=> ((float) ($b['price_from'] ?? 0));
        }
        if ($sort === 'duration') {
            return ((int) ($a['nights'] ?? 0)) <=> ((int) ($b['nights'] ?? 0));
        }
        $feature = ((int) !empty($b['is_featured'])) <=> ((int) !empty($a['is_featured']));
        if ($feature !== 0) {
            return $feature;
        }
        return strcmp((string) ($a['title'] ?? ''), (string) ($b['title'] ?? ''));
    });
    return $packages;
}

function filter_packages(array $query): array
{
    $rows = array_values(array_filter(
        packages_public(),
        static fn(array $package): bool => package_matches($package, $query)
    ));
    return sort_packages($rows, (string) ($query['sort'] ?? 'recommended'));
}

function paginate(array $rows, int $page, int $perPage = 12): array
{
    $total = count($rows);
    $pages = max(1, (int) ceil($total / $perPage));
    $page = min(max(1, $page), $pages);
    $offset = ($page - 1) * $perPage;
    return [
        'items' => array_slice($rows, $offset, $perPage),
        'page' => $page,
        'pages' => $pages,
        'total' => $total,
        'per_page' => $perPage,
    ];
}

function query_url(string $path, array $query, array $overrides = []): string
{
    $next = array_merge($query, $overrides);
    $params = [];
    foreach ($next as $key => $value) {
        if ($value === '' || $value === null || $value === [] || $key === 'page' && (int) $value <= 1 && !array_key_exists('page', $overrides)) {
            continue;
        }
        if ($key === 'page' && (int) $value <= 1) {
            continue;
        }
        $params[$key] = $value;
    }
    $qs = http_build_query($params);
    return url($path) . ($qs !== '' ? '?' . $qs : '');
}

function money_aed(float $amount): string
{
    return 'AED ' . number_format($amount, 0);
}

function save_label(array $package): string
{
    $was = $package['price_was'] ?? null;
    $now = (float) ($package['price_from'] ?? 0);
    if ($was === null || $was === '' || (float) $was <= $now || $now <= 0) {
        return '';
    }
    $percent = (int) round((1 - ($now / (float) $was)) * 100);
    return $percent > 0 ? 'Save ' . $percent . '%' : '';
}

function package_destination(array $package): string
{
    $name = destination_name((string) ($package['destination_slug'] ?? ''));
    return $name !== '' ? $name : (string) ($package['destination'] ?? '');
}

function related_packages(array $package, int $limit = 3): array
{
    $slug = (string) ($package['slug'] ?? '');
    $region = (string) ($package['region'] ?? '');
    $rows = array_values(array_filter(
        packages_public(),
        static fn(array $row): bool => ($row['slug'] ?? '') !== $slug && ($row['region'] ?? '') === $region
    ));
    if (count($rows) < $limit) {
        foreach (packages_public() as $row) {
            if (($row['slug'] ?? '') === $slug) {
                continue;
            }
            if (!in_array($row, $rows, true)) {
                $rows[] = $row;
            }
            if (count($rows) >= $limit) {
                break;
            }
        }
    }
    return array_slice($rows, 0, $limit);
}

function image_identity(string $src): string
{
    if (preg_match('#(photo-[A-Za-z0-9\-]+)#', $src, $match) === 1) {
        return $match[1];
    }
    $path = parse_url($src, PHP_URL_PATH);
    return is_string($path) ? $path : $src;
}

/** @param array<int, string> $used */
function claim_image(string $src, array &$used): bool
{
    $key = image_identity($src);
    if ($key === '' || in_array($key, $used, true)) {
        return false;
    }
    $used[] = $key;
    return true;
}

function render_404(): never
{
    http_response_code(404);
    $pageTitle = 'Page not found';
    $pageDescription = 'That page is not on the Tripcompanies site. Start again from the home page or message the Dubai desk.';
    $pageCanonical = current_path();
    $robots = 'noindex, follow';
    $hasHero = true;
    require ROOT_PATH . '/includes/head.php';
    require ROOT_PATH . '/includes/header.php';
    echo '<main id="main">';
    partial('not-found');
    echo '</main>';
    require ROOT_PATH . '/includes/footer.php';
    exit;
}

function breadcrumb_schema(array $items): array
{
    $list = [];
    $position = 1;
    foreach ($items as $item) {
        $entry = [
            '@type' => 'ListItem',
            'position' => $position,
            'name' => (string) ($item['label'] ?? ''),
        ];
        if (!empty($item['href'])) {
            $entry['item'] = absolute_url((string) $item['href']);
        }
        $list[] = $entry;
        $position++;
    }
    return [
        '@type' => 'BreadcrumbList',
        'itemListElement' => $list,
    ];
}

function faq_schema(array $pairs): array
{
    $main = [];
    foreach ($pairs as $pair) {
        $main[] = [
            '@type' => 'Question',
            'name' => (string) ($pair['q'] ?? ''),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => (string) ($pair['a'] ?? ''),
            ],
        ];
    }
    return [
        '@type' => 'FAQPage',
        'mainEntity' => $main,
    ];
}

function enquire_message(array $fields): string
{
    $lines = ['Hi Tripcompanies, I would like to enquire.'];
    $map = [
        'package' => 'Package',
        'experience' => 'Experience',
        'visa' => 'Visa',
        'destination' => 'Destination',
        'month' => 'Travel month',
        'adults' => 'Adults',
        'children' => 'Children',
        'travellers' => 'Travellers',
        'name' => 'Name',
        'phone' => 'Phone',
        'budget' => 'Budget',
        'style' => 'Trip style',
        'hotel' => 'Hotel level',
        'notes' => 'Notes',
    ];
    foreach ($map as $key => $label) {
        $value = trim((string) ($fields[$key] ?? ''));
        if ($value !== '') {
            $lines[] = $label . ': ' . $value;
        }
    }
    $lines[] = 'Quoted currency: AED';
    return implode("\n", $lines);
}
