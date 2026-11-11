<?php
declare(strict_types=1);
$eyebrow = (string) ($eyebrow ?? '');
$title = (string) ($title ?? '');
$lead = (string) ($lead ?? '');
$image = (string) ($image ?? '');
$alt = (string) ($alt ?? '');
$emphasis = (string) ($emphasis ?? '');
$heroClass = trim('page-hero ' . (string) ($class ?? ''));
$srcset = image_srcset($image);
?>
<section class="<?= e($heroClass) ?>">
    <img class="page-hero__img" src="<?= e($image) ?>"<?php if ($srcset !== ''): ?> srcset="<?= e($srcset) ?>" sizes="100vw"<?php endif; ?> alt="<?= e($alt) ?>" width="2000" height="1250" fetchpriority="high">
    <div class="page-hero__shade" aria-hidden="true"></div>
    <div class="container page-hero__content">
        <?php if ($eyebrow !== ''): ?>
            <p class="eyebrow"><?= e($eyebrow) ?></p>
        <?php endif; ?>
        <h1><?= editorial_title($title, $emphasis) ?></h1>
        <?php if ($lead !== ''): ?>
            <p class="lead"><?= e($lead) ?></p>
        <?php endif; ?>
    </div>
</section>
