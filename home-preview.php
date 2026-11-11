<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';

/**
 * New home page concept. Separate preview at /home-preview.
 * Uses the live header, footer and data. Replaces nothing.
 */
$slides = promotions();
$pageTitle = 'Holiday Packages from Dubai';
$pageDescription = 'Tripcompanies plans holiday packages from Dubai for people living in the UAE. Enquire on WhatsApp.';
$pageCanonical = '/';
$robots = 'noindex, nofollow';
$bodyClass = 'hp-page';
$hasHero = true;
$pagePreload = (string) ($slides[0]['image'] ?? '');

$used = [];
$publicPackages = packages_public();
$destinations = destinations_all();
$activeDeals = deals_active();
$reviews = array_slice(reviews_all(), 0, 3);
$posts = array_slice(posts_all(), 0, 3);
$faqs = [];
foreach (faqs_all() as $group) {
    foreach ($group['items'] as $item) {
        $faqs[] = $item;
        if (count($faqs) >= 5) {
            break 2;
        }
    }
}

$hpFrom = static function (callable $match) use ($publicPackages): ?float {
    $from = null;
    foreach ($publicPackages as $package) {
        if ($match($package)) {
            $price = (float) ($package['price_from'] ?? 0);
            $from = $from === null ? $price : min($from, $price);
        }
    }
    return $from;
};

$hpSlideFrom = static function (array $slide) use ($hpFrom): ?float {
    $href = (string) ($slide['href'] ?? '');
    if (preg_match('#^/deals/([a-z0-9-]+)#', $href, $m) === 1) {
        return $hpFrom(static fn(array $p): bool => in_array($m[1], (array) ($p['deal_slugs'] ?? []), true));
    }
    if (preg_match('#^/destinations/([a-z0-9-]+)#', $href, $m) === 1) {
        return $hpFrom(static fn(array $p): bool => ($p['destination_slug'] ?? '') === $m[1]);
    }
    return null;
};

$hpMoney = static function (float $amount): string {
    return '<span data-money="' . e((string) $amount) . '">AED ' . e(number_format($amount, 0)) . '</span>';
};

$hpTitle = static function (string $before, string $brush, string $after = ''): string {
    return e($before) . ' <em>' . e($brush) . '</em>' . ($after !== '' ? ' ' . e($after) : '');
};

$hpCard = static function (array $package) use ($hpMoney): void {
    $slug = (string) ($package['slug'] ?? '');
    $title = (string) ($package['title'] ?? '');
    $src = (string) ($package['image'] ?? '');
    $set = image_srcset($src);
    $catalog = inclusion_catalog();
    $have = array_values(array_filter((array) ($package['inclusion_icons'] ?? []), static fn($i): bool => isset($catalog[$i])));
    $iconFor = ['visa' => 'passport', 'flights' => 'plane', 'hotel' => 'bed', 'transfers' => 'pin', 'sightseeing' => 'compass'];
    $was = $package['price_was'] ?? null;
    $showWas = $was !== null && $was !== '' && (float) $was > (float) ($package['price_from'] ?? 0);
    $save = save_label($package);
    ?>
    <article class="hp-card" data-slug="<?= e($slug) ?>" data-price-aed="<?= e((string) ($package['price_from'] ?? 0)) ?>">
        <div class="hp-card__media">
            <a href="<?= e(package_url($package)) ?>" aria-label="<?= e($title) ?>">
                <img src="<?= e($src) ?>"<?php if ($set !== ''): ?> srcset="<?= e($set) ?>" sizes="(max-width: 800px) 85vw, 420px"<?php endif; ?> alt="<?= e((string) ($package['image_alt'] ?? $title)) ?>" width="800" height="640" loading="lazy" decoding="async">
                <span class="hp-card__country" aria-hidden="true"><?= e(package_destination($package)) ?></span>
            </a>
            <?php if (!empty($package['badge'])): ?><span class="hp-card__badge"><?= e((string) $package['badge']) ?></span><?php endif; ?>
            <button class="icon-btn heart hp-card__heart" type="button" data-wish="<?= e($slug) ?>" aria-pressed="false" aria-label="Save <?= e($title) ?>"><?= icon('heart') ?></button>
            <span class="hp-card__days"><?= icon('clock') ?><?= e((int) ($package['days'] ?? 0) . ' Days ' . (int) ($package['nights'] ?? 0) . ' Nights') ?></span>
        </div>
        <div class="hp-card__body">
            <h3><a href="<?= e(package_url($package)) ?>"><?= e($title) ?></a></h3>
            <ul class="hp-card__inc">
                <?php foreach (array_slice($have, 0, 3) as $inc): ?>
                    <li><?= icon($iconFor[$inc] ?? 'check') ?><?= e((string) $catalog[$inc]) ?></li>
                <?php endforeach; ?>
                <?php if (count($have) > 3): ?><li class="hp-card__more">+<?= e((string) (count($have) - 3)) ?> more</li><?php endif; ?>
            </ul>
            <div class="hp-card__foot">
                <p class="hp-card__price">
                    <small>From<?php if ($showWas): ?> <s data-money="<?= e((string) $was) ?>">AED <?= e(number_format((float) $was, 0)) ?></s><?php endif; ?></small>
                    <strong><?= $hpMoney((float) ($package['price_from'] ?? 0)) ?></strong>
                    <small>per person, twin share<?= $save !== '' ? ' · ' . e($save) : '' ?><?= !empty($package['is_sample']) ? ' · sample' : '' ?></small>
                </p>
                <a class="hp-btn" href="<?= e(url('/enquire?package_slug=' . rawurlencode($slug))) ?>" data-enquire data-kind="package" data-slug="<?= e($slug) ?>" data-title="<?= e($title) ?>">Enquire</a>
            </div>
        </div>
    </article>
    <?php
};

require __DIR__ . '/includes/head.php';
?>
<script>document.documentElement.setAttribute('data-theme', 'light');</script>
<link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Poppins:wght@700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= e(asset('css/home-preview.css')) ?>">
<?php require __DIR__ . '/includes/header.php'; ?>
<main id="main" class="hp">
    <section class="hero hp-hero" data-hero tabindex="0" aria-roledescription="carousel" aria-label="Featured trips">
        <?php foreach ($slides as $index => $slide): ?>
            <?php claim_image((string) $slide['image'], $used); $slideFrom = $hpSlideFrom($slide); $slideSet = image_srcset((string) $slide['image']); ?>
            <article class="hero__slide<?= $index === 0 ? ' is-active' : '' ?>" aria-hidden="<?= $index === 0 ? 'false' : 'true' ?>">
                <img class="media-fill hero__img" src="<?= e((string) $slide['image']) ?>"<?php if ($slideSet !== ''): ?> srcset="<?= e($slideSet) ?>" sizes="100vw"<?php endif; ?> alt="<?= e((string) $slide['alt']) ?>" width="2400" height="1500"<?= $index === 0 ? ' fetchpriority="high"' : ' loading="lazy"' ?> decoding="async">
                <div class="hero__shade" aria-hidden="true"></div>
                <div class="container hero__content on-photo hp-hero__content">
                    <p class="hp-hero__eyebrow"><?= icon('plane') ?><?= e((string) $slide['eyebrow']) ?></p>
                    <?php if ($index === 0): ?>
                        <h1><?= editorial_title((string) $slide['title'], (string) ($slide['emphasis'] ?? '')) ?></h1>
                    <?php else: ?>
                        <p class="display"><?= editorial_title((string) $slide['title'], (string) ($slide['emphasis'] ?? '')) ?></p>
                    <?php endif; ?>
                    <p class="lead"><?= e((string) $slide['text']) ?></p>
                    <div class="hero__actions">
                        <a class="hp-btn hp-btn--lg" href="<?= e(url((string) $slide['href'])) ?>"><?= e((string) $slide['cta']) ?><?= icon('arrow') ?></a>
                        <?php if ($slideFrom !== null): ?>
                            <p class="hp-sticker"><small>Starting from</small><strong><?= $hpMoney($slideFrom) ?></strong></p>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
        <?php if (count($slides) > 1): ?>
            <button class="hero__arrow hero__arrow--prev" type="button" data-hero-prev aria-label="Previous slide"><?= icon('chevron-right') ?></button>
            <button class="hero__arrow hero__arrow--next" type="button" data-hero-next aria-label="Next slide"><?= icon('chevron-right') ?></button>
        <?php endif; ?>
    </section>

    <div class="container hp-search">
        <p class="hp-search__tab"><?= icon('plane') ?>Find your holiday</p>
        <?php partial('search-panel', ['id' => 'home']); ?>
    </div>

    <?php if ($activeDeals !== []): ?>
        <section class="hp-section hp-doodle">
            <div class="container">
                <div class="hp-head">
                    <div>
                        <p class="hp-kicker">Handpicked for every season</p>
                        <h2 class="hp-title"><?= $hpTitle('Holiday', 'deals', 'from Dubai') ?></h2>
                    </div>
                    <a class="hp-link" href="<?= e(url('/deals')) ?>">View all deals<?= icon('arrow') ?></a>
                </div>
                <div class="hp-tabs" role="tablist" aria-label="Seasonal deals">
                    <?php foreach ($activeDeals as $index => $deal): ?>
                        <button class="hp-tab" type="button" role="tab" id="hp-tab-<?= e((string) $deal['slug']) ?>" aria-controls="hp-panel-<?= e((string) $deal['slug']) ?>" aria-selected="<?= $index === 0 ? 'true' : 'false' ?>" data-hp-tab><?= e((string) $deal['title']) ?></button>
                    <?php endforeach; ?>
                </div>
                <?php foreach ($activeDeals as $index => $deal): ?>
                    <?php
                    $panelUsed = $used;
                    $panelPackages = filter_packages(package_query_from(['deal' => (string) $deal['slug'], 'sort' => 'recommended']));
                    ?>
                    <div class="hp-row" role="tabpanel" id="hp-panel-<?= e((string) $deal['slug']) ?>" aria-labelledby="hp-tab-<?= e((string) $deal['slug']) ?>"<?= $index === 0 ? '' : ' hidden' ?>>
                        <?php foreach (array_slice($panelPackages, 0, 3) as $package): ?>
                            <?php if (!claim_image((string) $package['image'], $panelUsed)) { continue; } ?>
                            <?php $hpCard($package); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($destinations !== []): ?>
        <section class="hp-section hp-section--tint">
            <div class="container">
                <div class="hp-head hp-head--center">
                    <div>
                        <p class="hp-kicker">Eight countries, one desk in Dubai</p>
                        <h2 class="hp-title"><?= $hpTitle('Where do you want to', 'go?') ?></h2>
                    </div>
                </div>
                <div class="hp-arches">
                    <?php foreach ($destinations as $destination): ?>
                        <?php
                        $slug = (string) $destination['slug'];
                        $from = $hpFrom(static fn(array $p): bool => ($p['destination_slug'] ?? '') === $slug);
                        claim_image((string) $destination['image'], $used);
                        ?>
                        <a class="hp-arch" href="<?= e(url('/destinations/' . $slug)) ?>">
                            <span class="hp-arch__img"><img src="<?= e((string) $destination['image']) ?>" alt="<?= e((string) $destination['image_alt']) ?>" width="600" height="800" loading="lazy" decoding="async"></span>
                            <strong><?= e((string) $destination['name']) ?></strong>
                            <?php if ($from !== null): ?><small>From <?= $hpMoney($from) ?></small><?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="hp-types" aria-label="Browse by trip type">
        <div class="container hp-types__in">
            <h2>Travel your way</h2>
            <ul>
                <?php $typeIcons = ['honeymoon' => 'heart', 'family' => 'users', 'group' => 'globe', 'city' => 'pin', 'adventure' => 'compass', 'luxury' => 'star']; ?>
                <?php foreach (trip_types() as $key => $label): ?>
                    <li><a href="<?= e(url('/packages?type=' . $key)) ?>"><span><?= icon($typeIcons[$key] ?? 'compass') ?></span><?= e($label) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <?php $spotlight = find_destination('kenya') ?? ($destinations[0] ?? null); ?>
    <?php if ($spotlight !== null): ?>
        <?php
        $spotlightSlug = (string) $spotlight['slug'];
        $spotlightFrom = $hpFrom(static fn(array $p): bool => ($p['destination_slug'] ?? '') === $spotlightSlug);
        $spotlightPhoto = 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&fm=webp&q=75&w=2400';
        ?>
        <section class="hp-spot">
            <img src="<?= e($spotlightPhoto) ?>" alt="Wildlife on the savannah in Kenya" width="2400" height="1400" loading="lazy" decoding="async">
            <div class="container">
                <div class="hp-spot__card">
                    <p class="hp-kicker">Destination in the spotlight</p>
                    <h2 class="hp-title"><?= $hpTitle('Safari in', (string) $spotlight['name']) ?></h2>
                    <p><?= e((string) $spotlight['tagline']) ?></p>
                    <ul>
                        <?php foreach (array_slice((array) $spotlight['why'], 0, 3) as $why): ?>
                            <li><?= icon('check') ?><?= e((string) $why) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="hp-spot__foot">
                        <a class="hp-btn" href="<?= e(url('/destinations/' . $spotlightSlug)) ?>">Explore <?= e((string) $spotlight['name']) ?><?= icon('arrow') ?></a>
                        <?php if ($spotlightFrom !== null): ?><p>From <strong><?= $hpMoney($spotlightFrom) ?></strong></p><?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php
    $valueUsed = $used;
    $valuePackages = $publicPackages;
    usort($valuePackages, static fn(array $a, array $b): int => (float) ($a['price_from'] ?? 0) <=> (float) ($b['price_from'] ?? 0));
    ?>
    <section class="hp-section">
        <div class="container">
            <div class="hp-head">
                <div>
                    <p class="hp-kicker">Short on days, big on memories</p>
                    <h2 class="hp-title"><?= $hpTitle('Quick', 'getaways') ?></h2>
                </div>
                <a class="hp-link" href="<?= e(url('/packages')) ?>">All packages<?= icon('arrow') ?></a>
            </div>
            <div class="hp-row">
                <?php $shown = 0; foreach ($valuePackages as $package): ?>
                    <?php if ($shown >= 3) { break; } ?>
                    <?php if (!claim_image((string) $package['image'], $valueUsed)) { continue; } ?>
                    <?php $hpCard($package); $shown++; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="hp-custom">
        <div class="container hp-custom__in">
            <div class="hp-custom__copy">
                <p class="hp-kicker">Customized tours</p>
                <h2>Dream it. We will plan it.</h2>
                <p>Tell us the destination, the month and who is travelling. We reply on WhatsApp with a route and a price.</p>
                <a class="hp-btn hp-btn--white" href="<?= e(url('/custom-trip')) ?>">Plan my trip<?= icon('arrow') ?></a>
            </div>
            <div class="hp-custom__pics" aria-hidden="true">
                <?php foreach (array_slice($destinations, 2, 3) as $destination): ?>
                    <span><img src="<?= e((string) $destination['image']) ?>" alt="" width="420" height="520" loading="lazy" decoding="async"><b><?= e((string) $destination['name']) ?></b></span>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="hp-section hp-doodle">
        <div class="container hp-why">
            <div>
                <p class="hp-kicker">Why Tripcompanies</p>
                <h2 class="hp-title"><?= $hpTitle('Travel with', 'us') ?></h2>
                <div class="hp-reasons">
                    <?php foreach (site('reasons') as $reason): ?>
                        <article>
                            <span><?= icon((string) ($reason['icon'] ?? 'compass')) ?></span>
                            <h3><?= e((string) $reason['title']) ?></h3>
                            <p><?= e((string) $reason['text']) ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="hp-steps">
                <h2>How to book</h2>
                <ol>
                    <?php foreach (site('steps') as $step): ?>
                        <li><div><h3><?= e((string) $step['title']) ?></h3><p><?= e((string) $step['text']) ?></p></div></li>
                    <?php endforeach; ?>
                </ol>
                <a class="hp-btn" href="<?= e(wa_link('Hi Tripcompanies, I would like to plan a trip.')) ?>" target="_blank" rel="noopener noreferrer"><?= icon('whatsapp') ?>Start on WhatsApp</a>
            </div>
        </div>
    </section>

    <?php if ($reviews !== []): ?>
        <section class="hp-section hp-section--tint">
            <div class="container">
                <div class="hp-head hp-head--center">
                    <div>
                        <p class="hp-kicker">Sample notes for layout, not verified reviews</p>
                        <h2 class="hp-title"><?= $hpTitle('Happy', 'travellers') ?></h2>
                    </div>
                </div>
                <div class="hp-quotes">
                    <?php foreach ($reviews as $review): ?>
                        <blockquote>
                            <p><?= e((string) $review['quote']) ?></p>
                            <footer><strong><?= e((string) $review['name']) ?></strong><span><?= e((string) $review['destination']) ?></span></footer>
                        </blockquote>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php $shots = (array) site('instagram_images'); ?>
    <?php if ($shots !== []): ?>
        <section class="hp-insta" aria-label="Instagram">
            <a class="hp-insta__tag" href="<?= e((string) site('instagram')) ?>"><?= icon('instagram') ?><?= e((string) site('instagram_handle')) ?></a>
            <div class="hp-insta__track">
                <?php foreach ([false, true] as $clone): ?>
                    <?php foreach ($shots as $shot): ?>
                        <a href="<?= e((string) site('instagram')) ?>"<?= $clone ? ' aria-hidden="true" tabindex="-1"' : '' ?>><img src="<?= e((string) $shot['src']) ?>" alt="<?= $clone ? '' : e((string) $shot['alt']) ?>" width="360" height="360" loading="lazy" decoding="async"></a>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($posts !== []): ?>
        <section class="hp-section">
            <div class="container">
                <div class="hp-head">
                    <div>
                        <p class="hp-kicker">Before you fly</p>
                        <h2 class="hp-title"><?= $hpTitle('Travel', 'guides') ?></h2>
                    </div>
                    <a class="hp-link" href="<?= e(url('/blog')) ?>">All guides<?= icon('arrow') ?></a>
                </div>
                <div class="hp-posts">
                    <?php foreach ($posts as $post): ?>
                        <a href="<?= e(url('/blog/' . $post['slug'])) ?>">
                            <img src="<?= e((string) $post['image']) ?>" alt="<?= e((string) $post['alt']) ?>" width="800" height="520" loading="lazy" decoding="async">
                            <small><?= e((string) $post['date']) ?></small>
                            <h3><?= e((string) $post['title']) ?></h3>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="hp-section hp-section--tint">
        <div class="container hp-ask">
            <?php if ($faqs !== []): ?>
                <div>
                    <h2 class="hp-title"><?= $hpTitle('Good to', 'know') ?></h2>
                    <div class="faq-list">
                        <?php foreach ($faqs as $index => $item): ?>
                            <details class="faq"<?= $index === 0 ? ' open' : '' ?>>
                                <summary><span><?= e((string) $item['q']) ?></span></summary>
                                <p><?= e((string) $item['a']) ?></p>
                            </details>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <form class="hp-form" method="post" action="<?= e(url('/send-enquiry')) ?>">
                <h2>Talk to an expert</h2>
                <input type="hidden" name="type" value="enquiry">
                <input type="hidden" name="return" value="/">
                <p class="honeypot"><label>Company website<input name="company_website" tabindex="-1" autocomplete="off"></label></p>
                <label class="field"><span>Name</span><input name="name" required maxlength="80"></label>
                <label class="field"><span>Phone</span><input name="phone" required inputmode="tel"></label>
                <label class="field"><span>Destination</span><input name="destination" required></label>
                <label class="field"><span>Travel month</span>
                    <select name="travel_month" required><?php foreach (travel_months() as $month): ?><option><?= e($month) ?></option><?php endforeach; ?></select>
                </label>
                <label class="field"><span>Travellers</span>
                    <select name="travellers" required><?php foreach (traveller_options() as $option): ?><option><?= e($option) ?></option><?php endforeach; ?></select>
                </label>
                <label class="field"><span>Note</span><textarea name="message" required minlength="10" rows="3"></textarea></label>
                <button class="hp-btn" type="submit">Send enquiry</button>
            </form>
        </div>
    </section>
</main>
<script src="<?= e(asset('js/home-preview.js')) ?>" defer></script>
<?php require __DIR__ . '/includes/footer.php'; ?>
