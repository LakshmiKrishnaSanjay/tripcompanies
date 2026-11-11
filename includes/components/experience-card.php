<?php
declare(strict_types=1);
/** @var array<string, mixed> $experience */
$slug = (string) ($experience['slug'] ?? '');
$title = (string) ($experience['title'] ?? '');
$src = (string) ($experience['image'] ?? '');
?>
<article class="experience-card">
    <div class="experience-card__media">
        <?php if (!empty($experience['badge'])): ?><span class="badge"><?= e((string) $experience['badge']) ?></span><?php endif; ?>
        <a href="<?= e(url('/inbound/' . $slug)) ?>">
            <img class="media-fill" src="<?= e($src) ?>"<?php $set = image_srcset($src); if ($set !== ''): ?> srcset="<?= e($set) ?>" sizes="(max-width: 800px) 92vw, 320px"<?php endif; ?> alt="<?= e((string) ($experience['alt'] ?? $title)) ?>" width="800" height="600" loading="lazy" decoding="async">
        </a>
    </div>
    <div class="experience-card__body">
        <p class="kicker"><?= e((string) ($experience['category'] ?? '')) ?></p>
        <h3 class="experience-card__title"><a href="<?= e(url('/inbound/' . $slug)) ?>"><?= e($title) ?></a></h3>
        <p><?= e((string) ($experience['duration'] ?? '')) ?> · <?= e((string) ($experience['location'] ?? 'UAE')) ?></p>
        <p class="price">From <span data-money="<?= e((string) ($experience['price_from'] ?? 0)) ?>">AED <?= e(number_format((float) ($experience['price_from'] ?? 0), 0)) ?></span><small>per person, confirmed on WhatsApp</small></p>
        <a class="btn btn--primary" href="<?= e(url('/enquire?experience=' . rawurlencode($title))) ?>" data-enquire data-kind="experience" data-title="<?= e($title) ?>">Enquire on WhatsApp</a>
    </div>
</article>
