<?php
declare(strict_types=1);

$featuredExperience = null;
$uaeCategoryPreviews = [];
foreach (experiences_all() as $candidate) {
    $category = (string) ($candidate['category'] ?? '');
    if ($category !== '' && !isset($uaeCategoryPreviews[$category])) {
        $uaeCategoryPreviews[$category] = $candidate;
    }
    if ($featuredExperience === null && !empty($candidate['badge'])) {
        $featuredExperience = $candidate;
    }
}
if ($featuredExperience === null) {
    $featuredExperience = $uaeCategoryPreviews[experience_categories()[0] ?? ''] ?? (experiences_all()[0] ?? null);
}

$hours = trust_has('opening_hours') ? (string) trust('opening_hours') : '';
$announcement = trim((string) site('announcement', ''));
$currencies = site('currencies', []);
if (!is_array($currencies)) {
    $currencies = [];
}
?>
<a class="skip-link" href="#main">Skip to content</a>
<div class="topbar">
    <div class="utility">
        <div class="container utility__inner">
            <div class="utility__left">
                <a href="tel:<?= e((string) site('phone_tel')) ?>"><?= e((string) site('phone_display')) ?></a>
                <a href="mailto:<?= e((string) site('email')) ?>"><?= e((string) site('email')) ?></a>
                <?php if ($hours !== ''): ?><span class="utility__hours"><?= e($hours) ?></span><?php endif; ?>
            </div>
            <?php if ($announcement !== ''): ?><p class="utility__note"><?= e($announcement) ?></p><?php endif; ?>
            <div class="utility__right">
                <?php if ($currencies !== []): ?>
                    <label class="sr-only" for="currency">Currency</label>
                    <select class="currency-select" id="currency" data-currency>
                        <?php foreach ($currencies as $code => $rate): ?>
                            <option value="<?= e((string) $code) ?>" data-rate="<?= e((string) $rate) ?>"<?= $code === 'AED' ? ' selected' : '' ?>><?= e((string) $code) ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
                <button class="theme-toggle" type="button" data-theme-toggle aria-pressed="false" aria-label="Switch to light mode">
                    <span class="theme-toggle__icon theme-toggle__icon--sun"><?= icon('sun') ?></span>
                    <span class="theme-toggle__icon theme-toggle__icon--moon"><?= icon('moon') ?></span>
                </button>
            </div>
        </div>
    </div>
    <input class="nav-toggle" type="checkbox" id="nav-toggle" aria-controls="site-nav" aria-expanded="false" aria-label="Open menu">
    <div class="header__inner container">
        <a class="logo" href="<?= e(url('/')) ?>" aria-label="Tripcompanies home">
            <img class="logo__mark logo__mark--ink" src="<?= e(asset('img/logo-ink.png')) ?>" alt="" width="61" height="58">
            <img class="logo__mark logo__mark--white" src="<?= e(asset('img/logo-white.png')) ?>" alt="" width="61" height="58">
        </a>
        <nav class="nav" id="site-nav" aria-label="Primary">
            <ul class="nav__list">
                <li class="mega<?= nav_is_active('/deals') ? ' is-current' : '' ?>">
                    <details>
                        <summary class="mega__btn">Deals</summary>
                        <div class="mega__panel mega__panel--narrow">
                            <ul class="mega__list">
                                <?php foreach (deals_active() as $deal): ?>
                                    <li><a href="<?= e(url('/deals/' . $deal['slug'])) ?>"><?= e((string) $deal['title']) ?></a></li>
                                <?php endforeach; ?>
                                <li><a href="<?= e(url('/deals')) ?>">All deals</a></li>
                            </ul>
                        </div>
                    </details>
                </li>
                <li><a class="nav__link" href="<?= e(url('/custom-trip')) ?>"<?= nav_is_active('/custom-trip') ? ' aria-current="page"' : '' ?>>Customized Tours</a></li>
                <li class="mega mega--countries<?= nav_is_active('/destinations') || nav_is_active('/outbound') ? ' is-current' : '' ?>">
                    <details>
                        <summary class="mega__btn">Countries</summary>
                        <div class="mega__panel">
                            <div class="mega__cols mega__cols--regions">
                                <?php foreach (regions() as $key => $label): ?>
                                    <div>
                                        <p class="mega__label"><?= e($label) ?></p>
                                        <ul class="mega__list">
                                            <?php foreach (destinations_all() as $destination): ?>
                                                <?php if (($destination['region'] ?? '') !== $key) { continue; } ?>
                                                <li><a href="<?= e(url('/destinations/' . $destination['slug'])) ?>"><?= e((string) $destination['name']) ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <p class="mega__more"><a href="<?= e(url('/destinations')) ?>">All destinations</a></p>
                        </div>
                    </details>
                </li>
                <?php if (feature_on('FEATURE_INBOUND')): ?>
                <li class="mega<?= nav_is_active('/inbound') ? ' is-current' : '' ?>">
                    <details>
                        <summary class="mega__btn">Discover UAE</summary>
                        <div class="mega__panel">
                            <div class="mega__grid" data-mega-preview>
                                <div>
                                    <ul class="mega__list">
                                        <?php foreach (experience_categories() as $category): ?>
                                            <?php $preview = $uaeCategoryPreviews[$category] ?? null; ?>
                                            <li>
                                                <a
                                                    href="<?= e(url('/inbound?category=' . rawurlencode($category))) ?>"
                                                    <?php if (is_array($preview)): ?>
                                                        data-preview-image="<?= e((string) $preview['image']) ?>"
                                                        data-preview-alt="<?= e((string) ($preview['alt'] ?? $preview['title'])) ?>"
                                                        data-preview-category="<?= e($category) ?>"
                                                        data-preview-title="<?= e((string) $preview['title']) ?>"
                                                        data-preview-href="<?= e(url('/inbound/' . $preview['slug'])) ?>"
                                                    <?php endif; ?>
                                                ><?= e($category) ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?php if (is_array($featuredExperience)): ?>
                                    <a
                                        class="mega__card"
                                        href="<?= e(url('/inbound/' . $featuredExperience['slug'])) ?>"
                                        data-preview-card
                                        data-default-href="<?= e(url('/inbound/' . $featuredExperience['slug'])) ?>"
                                        data-default-image="<?= e((string) $featuredExperience['image']) ?>"
                                        data-default-alt="<?= e((string) ($featuredExperience['alt'] ?? $featuredExperience['title'])) ?>"
                                        aria-label="<?= e((string) $featuredExperience['title']) ?>"
                                    >
                                        <img src="<?= e((string) $featuredExperience['image']) ?>" alt="<?= e((string) ($featuredExperience['alt'] ?? '')) ?>" width="640" height="480" data-preview-img>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </details>
                </li>
                <?php endif; ?>
                <li class="mega<?= nav_is_active('/how-to-book') || nav_is_active('/blog') || nav_is_active('/faq') || nav_is_active('/about') || nav_is_active('/packages') ? ' is-current' : '' ?>">
                    <details>
                        <summary class="mega__btn">Explore</summary>
                        <div class="mega__panel mega__panel--narrow">
                            <ul class="mega__list">
                                <li><a href="<?= e(url('/packages')) ?>">Packages</a></li>
                                <li><a href="<?= e(url('/about')) ?>">About</a></li>
                                <li><a href="<?= e(url('/how-to-book')) ?>">How to Book</a></li>
                                <li><a href="<?= e(url('/blog')) ?>">Blog</a></li>
                                <li><a href="<?= e(url('/faq')) ?>">FAQ</a></li>
                            </ul>
                        </div>
                    </details>
                </li>
                <?php if (feature_on('FEATURE_VISA')): ?>
                <li class="mega<?= nav_is_active('/visa') ? ' is-current' : '' ?>">
                    <details>
                        <summary class="mega__btn">Visa</summary>
                        <div class="mega__panel mega__panel--narrow">
                            <ul class="mega__list">
                                <?php foreach (visas_all() as $visa): ?>
                                    <li><a href="<?= e(url('/visa/' . $visa['slug'])) ?>"><?= e((string) $visa['country']) ?></a></li>
                                <?php endforeach; ?>
                                <li><a href="<?= e(url('/visa')) ?>">All visa services</a></li>
                            </ul>
                        </div>
                    </details>
                </li>
                <?php endif; ?>
            </ul>
            <button class="theme-row" type="button" data-theme-toggle aria-pressed="false">
                <span>Theme</span>
                <span data-theme-value>Dark</span>
            </button>
        </nav>
        <div class="header__tools">
            <button class="theme-toggle theme-toggle--tools" type="button" data-theme-toggle aria-pressed="false" aria-label="Switch to light mode">
                <span class="theme-toggle__icon theme-toggle__icon--sun"><?= icon('sun') ?></span>
                <span class="theme-toggle__icon theme-toggle__icon--moon"><?= icon('moon') ?></span>
            </button>
            <button class="icon-btn" type="button" data-search-open aria-label="Search holidays">
                <?= icon('search') ?>
            </button>
            <a class="icon-btn" href="<?= e(url('/packages?view=wishlist')) ?>" aria-label="Wishlist">
                <?= icon('heart') ?>
                <span class="wish-count" data-wish-count hidden>0</span>
            </a>
            <a class="btn btn--expert header__contact" href="<?= e(wa_link('Hi Tripcompanies, I would like to talk to an expert about a trip.')) ?>" target="_blank" rel="noopener noreferrer">
                <span class="header__contact-label">Talk to an Expert</span>
            </a>
            <label class="menu-btn" for="nav-toggle">
                <span class="sr-only">Menu</span>
                <span class="menu-btn__open"><?= icon('menu') ?></span>
                <span class="menu-btn__close"><?= icon('close') ?></span>
            </label>
        </div>
    </div>
</div>
<div class="search-dialog" id="site-search" hidden>
    <div class="dialog" role="dialog" aria-modal="true" aria-labelledby="search-title">
        <div class="cluster" style="justify-content: space-between; margin-bottom: 0.8rem;">
            <h2 id="search-title" class="display" style="font-size: 2rem;">Search</h2>
            <button class="icon-btn" type="button" data-search-close aria-label="Close search"><?= icon('close') ?></button>
        </div>
        <?php partial('search-panel', ['id' => 'overlay']); ?>
    </div>
</div>
