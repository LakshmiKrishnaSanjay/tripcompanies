<?php
declare(strict_types=1);
/** @var array<string, mixed> $package */
$slug = (string) ($package['slug'] ?? '');
$title = (string) ($package['title'] ?? '');
$icons = inclusion_catalog();
$have = array_values(array_filter(
    (array) ($package['inclusion_icons'] ?? []),
    static fn($icon): bool => isset($icons[$icon])
));
$shown = array_slice($have, 0, 4);
$more = count($have) - count($shown);
$was = $package['price_was'] ?? null;
$showWas = $was !== null && $was !== '' && (float) $was > (float) ($package['price_from'] ?? 0);
$save = save_label($package);
$enquire = url('/enquire?package_slug=' . rawurlencode($slug));
$src = (string) ($package['image'] ?? '');
?>
<article class="package-card" data-slug="<?= e($slug) ?>" data-price-aed="<?= e((string) ($package['price_from'] ?? 0)) ?>">
    <div class="package-card__media">
        <?php if (!empty($package['badge'])): ?><span class="badge"><?= e((string) $package['badge']) ?></span><?php endif; ?>
        <?php if (!empty($package['is_sample'])): ?><span class="sample-tag" style="left:auto; right:0.7rem;">Sample</span><?php endif; ?>
        <button class="icon-btn heart" type="button" data-wish="<?= e($slug) ?>" aria-pressed="false" aria-label="Save <?= e($title) ?>"><?= icon('heart') ?></button>
        <a href="<?= e(package_url($package)) ?>">
            <img class="media-fill" src="<?= e($src) ?>"<?php $set = image_srcset($src); if ($set !== ''): ?> srcset="<?= e($set) ?>" sizes="(max-width: 800px) 92vw, 320px"<?php endif; ?> alt="<?= e((string) ($package['image_alt'] ?? $title)) ?>" width="800" height="600" loading="lazy" decoding="async">
        </a>
    </div>
    <div class="package-card__body">
        <p class="package-card__dest"><?= e(package_destination($package)) ?></p>
        <h3 class="package-card__title"><a href="<?= e(package_url($package)) ?>"><?= e($title) ?></a></h3>
        <p class="icons-row">
            <?php foreach ($shown as $icon): ?><span><?= icon((string) $icon === 'visa' ? 'passport' : ($icon === 'flights' ? 'plane' : ($icon === 'hotel' ? 'bed' : ($icon === 'transfers' ? 'pin' : 'compass')))) ?><?= e($icons[$icon]) ?></span><?php endforeach; ?>
            <?php if ($more > 0): ?><span>+<?= e((string) $more) ?> more</span><?php endif; ?>
        </p>
        <?php if (!empty($package['departures'][0])): ?><p class="label">Next departure <?= e((string) $package['departures'][0]) ?></p><?php endif; ?>
        <p class="price">
            <?php if ($showWas): ?><s data-money="<?= e((string) $was) ?>">AED <?= e(number_format((float) $was, 0)) ?></s><?php endif; ?>
            From <span data-money="<?= e((string) ($package['price_from'] ?? 0)) ?>">AED <?= e(number_format((float) ($package['price_from'] ?? 0), 0)) ?></span>
            <small>per person, twin share<?= $save !== '' ? ' · ' . e($save) : '' ?></small>
        </p>
        <div class="card-actions">
            <a class="btn btn--primary" href="<?= e($enquire) ?>" data-enquire data-kind="package" data-slug="<?= e($slug) ?>" data-title="<?= e($title) ?>">Enquire</a>
            <a class="btn btn--ghost" href="<?= e(package_url($package)) ?>">View details</a>
        </div>
    </div>
</article>
