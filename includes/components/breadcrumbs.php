<?php
declare(strict_types=1);
/** @var array<int, array{label: string, href?: string}> $items */
?>
<nav class="crumbs" aria-label="Breadcrumb">
    <?php foreach ($items as $index => $item): ?>
        <?php if ($index > 0): ?><span aria-hidden="true">/</span><?php endif; ?>
        <?php if (!empty($item['href'])): ?>
            <a href="<?= e(url((string) $item['href'])) ?>"><?= e((string) $item['label']) ?></a>
        <?php else: ?>
            <span><?= e((string) $item['label']) ?></span>
        <?php endif; ?>
    <?php endforeach; ?>
</nav>
