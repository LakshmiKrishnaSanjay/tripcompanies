<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';

$slides = promotions();
if ($slides === []) {
    $slides = [[
        'eyebrow' => site('tagline'),
        'title' => 'Holiday packages from Dubai',
        'emphasis' => 'Dubai',
        'text' => 'Holiday packages for people living in the UAE, planned on WhatsApp.',
        'image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Gergeti_Trinity_Church.jpg?width=2400',
        'alt' => 'Gergeti Trinity Church below Mount Kazbek in Georgia',
        'href' => '/outbound',
        'cta' => 'Plan a trip',
    ]];
}
$pageTitle = 'Holiday Packages from Dubai';
$pageDescription = 'Tripcompanies plans holiday packages from Dubai for people living in the UAE. Enquire on WhatsApp.';
$pageCanonical = '/';
$pagePreload = (string) $slides[0]['image'];
$hasHero = true;
$used = [];
claim_image((string) $slides[0]['image'], $used);

$activeDeals = deals_active();
$dealSlug = (string) ($activeDeals[0]['slug'] ?? '');
$dealPackages = $dealSlug === '' ? [] : filter_packages(package_query_from(['deal' => $dealSlug, 'sort' => 'recommended']));
$types = trip_types();
$destinations = destinations_all();
$experiences = experiences_all();
$visas = visas_all();
$reviews = reviews_all();
$posts = array_slice(posts_all(), 0, 3);
$faqs = [];
foreach (faqs_all() as $group) {
    foreach ($group['items'] as $item) {
        $faqs[] = $item;
        if (count($faqs) >= 6) {
            break 2;
        }
    }
}
$pageSchemas = $faqs !== [] ? [faq_schema($faqs)] : [];

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">
    <section class="hero" data-hero tabindex="0" aria-roledescription="carousel" aria-label="Featured trips">
        <?php foreach ($slides as $index => $slide): ?>
            <?php if ($index > 0) { claim_image((string) $slide['image'], $used); } ?>
            <article class="hero__slide<?= $index === 0 ? ' is-active' : '' ?>" aria-hidden="<?= $index === 0 ? 'false' : 'true' ?>">
                <img class="media-fill hero__img" src="<?= e((string) $slide['image']) ?>"<?php $set = image_srcset((string) $slide['image']); if ($set !== ''): ?> srcset="<?= e($set) ?>" sizes="100vw"<?php endif; ?> alt="<?= e((string) $slide['alt']) ?>" width="2400" height="1500"<?= $index === 0 ? ' fetchpriority="high"' : ' loading="lazy"' ?> decoding="async">
                <div class="hero__shade" aria-hidden="true"></div>
                <div class="container hero__content on-photo">
                    <?php if ($index === 0): ?>
                        <h1><?= editorial_title((string) $slide['title'], (string) ($slide['emphasis'] ?? '')) ?></h1>
                    <?php else: ?>
                        <p class="display"><?= editorial_title((string) $slide['title'], (string) ($slide['emphasis'] ?? '')) ?></p>
                    <?php endif; ?>
                    <p class="lead"><?= e((string) $slide['text']) ?></p>
                    <div class="hero__actions">
                        <a class="btn btn--primary" href="<?= e(url((string) $slide['href'])) ?>"><?= e((string) $slide['cta']) ?></a>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
        <?php if (count($slides) > 1): ?>
            <button class="hero__arrow hero__arrow--prev" type="button" data-hero-prev aria-label="Previous slide"><?= icon('chevron-right') ?></button>
            <button class="hero__arrow hero__arrow--next" type="button" data-hero-next aria-label="Next slide"><?= icon('chevron-right') ?></button>
        <?php endif; ?>
    </section>

    <div class="container search-panel">
        <?php partial('search-panel', ['id' => 'home']); ?>
    </div>

    <?php if ($activeDeals !== []): ?>
        <section class="section">
            <div class="container">
                <div class="section__head">
                    <div>
                        <p class="eyebrow">Seasonal deals</p>
                        <h2>Holiday packages from Dubai</h2>
                    </div>
                    <a class="btn btn--ghost" href="<?= e(url('/deals')) ?>">View all</a>
                </div>
                <div class="tabs">
                    <?php foreach ($activeDeals as $deal): ?>
                        <a class="tab<?= ($deal['slug'] ?? '') === $dealSlug ? ' is-active' : '' ?>" href="<?= e(url('/deals/' . $deal['slug'])) ?>"><?= e((string) $deal['title']) ?></a>
                    <?php endforeach; ?>
                </div>
                <?php if ($dealPackages !== []): ?>
                    <div class="scroller">
                        <?php foreach (array_slice($dealPackages, 0, 8) as $package): ?>
                            <?php if (!claim_image((string) $package['image'], $used)) { continue; } ?>
                            <?php partial('package-card', ['package' => $package]); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>

    <section class="section section--sand">
        <div class="container">
            <div class="section__head"><div><p class="eyebrow">Trip type</p><h2>Browse by trip type</h2></div></div>
            <div class="tabs">
                <?php foreach ($types as $key => $label): ?>
                    <a class="tab" href="<?= e(url('/packages?type=' . $key)) ?>"><?= e($label) ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php if ($destinations !== []): ?>
        <section class="section">
            <div class="container">
                <div class="section__head"><div><p class="eyebrow">Where to go</p><h2>Top destinations</h2></div><a class="btn btn--ghost" href="<?= e(url('/destinations')) ?>">All destinations</a></div>
                <div class="tile-grid">
                    <?php foreach ($destinations as $destination): ?>
                        <?php
                        $from = null;
                        foreach (packages_public() as $package) {
                            if (($package['destination_slug'] ?? '') === $destination['slug']) {
                                $price = (float) ($package['price_from'] ?? 0);
                                $from = $from === null ? $price : min($from, $price);
                            }
                        }
                        if (!claim_image((string) $destination['image'], $used)) {
                            continue;
                        }
                        ?>
                        <a class="tile" href="<?= e(url('/destinations/' . $destination['slug'])) ?>">
                            <img class="media-fill" src="<?= e((string) $destination['image']) ?>" alt="<?= e((string) $destination['image_alt']) ?>" width="800" height="1000" loading="lazy" decoding="async">
                            <span><strong><?= e((string) $destination['name']) ?></strong><?php if ($from !== null): ?><br>From <span data-money="<?= e((string) $from) ?>">AED <?= e(number_format($from, 0)) ?></span><?php endif; ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="section section--sand">
        <div class="container split custom-band">
            <div>
                <p class="eyebrow">Customized Tours</p>
                <h2>A trip shaped around you</h2>
                <p class="lead">The packages on this site are starting points. Tell us the destination, the month and who is travelling. We reply on WhatsApp with a route and a price.</p>
                <a class="btn btn--primary" href="<?= e(url('/custom-trip')) ?>">Plan a custom trip</a>
            </div>
            <a class="banner" href="<?= e(url('/custom-trip')) ?>" aria-label="Plan a custom trip">
                <img class="media-fill" src="https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&fm=webp&q=75&w=1400" alt="A paper map and a camera on a table" width="1400" height="700" loading="lazy">
            </a>
        </div>
        <?php if (feature_on('FEATURE_VISA')): ?>
            <div class="container" style="margin-top: 1rem;">
                <a class="banner" href="<?= e(url('/visa')) ?>">
                    <img class="media-fill" src="https://images.unsplash.com/photo-1521295121783-8a321d551ad2?auto=format&fit=crop&fm=webp&q=75&w=1400" alt="Passport and boarding documents on a desk" width="1400" height="700" loading="lazy">
                    <span class="banner__copy"><p class="eyebrow">Visas</p><h2>Visa assistance</h2></span>
                </a>
            </div>
        <?php endif; ?>
    </section>

    <?php if (feature_on('FEATURE_INBOUND') && $experiences !== []): ?>
        <section class="section">
            <div class="container">
                <div class="section__head"><div><p class="eyebrow">In the UAE</p><h2>Things to do in the UAE</h2></div></div>
                <div class="tabs">
                    <?php foreach (experience_categories() as $category): ?>
                        <a class="tab" href="<?= e(url('/inbound?category=' . rawurlencode($category))) ?>"><?= e($category) ?></a>
                    <?php endforeach; ?>
                </div>
                <div class="card-grid card-grid--3">
                    <?php foreach ($experiences as $experience): ?>
                        <?php if (!claim_image((string) $experience['image'], $used)) { continue; } ?>
                        <?php partial('experience-card', ['experience' => $experience]); ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (feature_on('FEATURE_VISA') && $visas !== []): ?>
        <section class="section section--sand">
            <div class="container">
                <div class="section__head"><div><p class="eyebrow">Paperwork</p><h2>Visa services</h2></div><a class="btn btn--ghost" href="<?= e(url('/visa')) ?>">All countries</a></div>
                <div class="tile-grid">
                    <?php foreach ($visas as $visa): ?>
                        <a class="panel" href="<?= e(url('/visa/' . $visa['slug'])) ?>" style="padding: 1rem; text-decoration: none;">
                            <p class="kicker"><?= e((string) ($visa['flag'] ?? '')) ?></p>
                            <h3><?= e((string) $visa['country']) ?></h3>
                            <p><?= e((string) $visa['processing']) ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="section">
        <div class="container desk-band">
            <div>
                <p class="eyebrow">Why Tripcompanies</p>
                <h2>A desk in Dubai</h2>
                <div class="reason-grid">
                    <?php foreach (site('reasons') as $reason): ?>
                        <article class="step"><h3><?= e((string) $reason['title']) ?></h3><p><?= e((string) $reason['text']) ?></p></article>
                    <?php endforeach; ?>
                </div>
            </div>
            <div>
                <div class="section__head">
                    <div>
                        <p class="eyebrow">How to book</p>
                        <h2>Three steps</h2>
                    </div>
                    <a class="btn btn--ghost" href="<?= e(url('/how-to-book')) ?>">Read how to book</a>
                </div>
                <ol class="steps steps--book">
                    <?php foreach (site('steps') as $index => $step): ?>
                        <li class="step"><b><?= e(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)) ?></b><h3><?= e((string) $step['title']) ?></h3><p><?= e((string) $step['text']) ?></p></li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
    </section>

    <?php if (trust_any()): ?>
        <section class="section section--sand">
            <div class="container">
                <h2>The desk, in numbers</h2>
                <div class="trust-band">
                    <?php foreach (['years_in_business' => 'Years', 'travellers_served' => 'Travellers', 'google_rating' => 'Google rating', 'visa_success_rate' => 'Visa notes', 'response_time' => 'Reply time'] as $key => $label): ?>
                        <?php if (trust_has($key)): ?><p><strong><?= e((string) trust($key)) ?></strong><br><?= e($label) ?></p><?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($reviews !== []): ?>
        <section class="section">
            <div class="container">
                <div class="section__head"><div><p class="eyebrow">Sample notes</p><h2>Traveller reviews</h2><p>These notes are samples for the layout, not verified reviews.</p></div></div>
                <div class="scroller">
                    <?php foreach ($reviews as $review): ?>
                        <blockquote class="quote"><p><?= e((string) $review['quote']) ?></p><p class="kicker" style="margin-top: 0.8rem;"><?= e((string) $review['name']) ?> · <?= e((string) $review['destination']) ?></p></blockquote>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="section section--sand">
        <div class="container">
            <div class="section__head"><div><h2>Instagram</h2><p>Follow <?= e((string) site('instagram_handle')) ?></p></div></div>
            <div class="insta-grid">
                <?php foreach (site('instagram_images') as $shot): ?>
                    <?php if (!claim_image((string) $shot['src'], $used)) { continue; } ?>
                    <a class="shot" href="<?= e((string) site('instagram')) ?>"><img class="media-fill" src="<?= e((string) $shot['src']) ?>" alt="<?= e((string) $shot['alt']) ?>" width="600" height="600" loading="lazy"><span>@tripcompanies</span></a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php if ($posts !== []): ?>
        <section class="section">
            <div class="container">
                <div class="section__head"><div><p class="eyebrow">Guides</p><h2>Travel guides</h2></div><a class="btn btn--ghost" href="<?= e(url('/blog')) ?>">All guides</a></div>
                <div class="post-grid">
                    <?php foreach ($posts as $post): ?>
                        <?php if (!claim_image((string) $post['image'], $used)) { continue; } ?>
                        <a class="package-card" href="<?= e(url('/blog/' . $post['slug'])) ?>" style="text-decoration: none;">
                            <span class="package-card__media"><img class="media-fill" src="<?= e((string) $post['image']) ?>" alt="<?= e((string) $post['alt']) ?>" width="800" height="600" loading="lazy"></span>
                            <span class="package-card__body"><span class="kicker"><?= e((string) $post['date']) ?></span><h3><?= e((string) $post['title']) ?></h3><p><?= e((string) $post['excerpt']) ?></p></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="section section--sand" data-recent hidden>
        <div class="container">
            <h2>Recently viewed</h2>
            <ul class="mega__list" data-recent-list></ul>
        </div>
    </section>
    <script type="application/json" id="recent-catalogue"><?php
        $recentCatalogue = [];
        foreach (packages_public() as $package) {
            $recentCatalogue[] = [
                'slug' => (string) $package['slug'],
                'title' => (string) $package['title'],
                'url' => package_url($package),
            ];
        }
        echo json_ld($recentCatalogue);
    ?></script>

    <?php if ($faqs !== []): ?>
        <section class="section">
            <div class="container faq-band">
                <div class="faq-band__intro">
                    <p class="eyebrow">Good to know</p>
                    <h2>Questions</h2>
                    <p class="lead">Short answers before you message the desk.</p>
                    <a class="btn btn--ghost" href="<?= e(url('/faq')) ?>">All questions</a>
                </div>
                <div class="faq-list">
                    <?php foreach ($faqs as $index => $item): ?>
                        <details class="faq"<?= $index === 0 ? ' open' : '' ?>>
                            <summary><span><?= e((string) $item['q']) ?></span></summary>
                            <p><?= e((string) $item['a']) ?></p>
                        </details>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="section section--sand ask-desk">
        <div class="container">
            <h2>Ask the desk</h2>
            <p class="lead">Name, a destination and a month are enough. We reply on WhatsApp or by email.</p>
            <form class="form" method="post" action="<?= e(url('/send-enquiry')) ?>">
                <input type="hidden" name="type" value="enquiry">
                <input type="hidden" name="return" value="/">
                <p class="honeypot"><label>Company website<input name="company_website" tabindex="-1" autocomplete="off"></label></p>
                <div class="form-row">
                    <label class="field"><span>Name</span><input name="name" required maxlength="80"></label>
                    <label class="field"><span>Phone</span><input name="phone" required inputmode="tel"></label>
                    <label class="field"><span>Destination</span><input name="destination" required></label>
                    <label class="field"><span>Travel month</span>
                        <select name="travel_month" required>
                            <?php foreach (travel_months() as $month): ?><option><?= e($month) ?></option><?php endforeach; ?>
                        </select>
                    </label>
                    <label class="field"><span>Travellers</span>
                        <select name="travellers" required>
                            <?php foreach (traveller_options() as $option): ?><option><?= e($option) ?></option><?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <label class="field"><span>Note</span><textarea name="message" required minlength="10" rows="4"></textarea></label>
                <button class="btn btn--primary" type="submit">Send by email</button>
            </form>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
