<?php
declare(strict_types=1);
$eyebrow = (string) ($eyebrow ?? '');
$title = (string) ($title ?? '');
$lead = (string) ($lead ?? '');
$headingId = (string) ($headingId ?? '');
$align = (string) ($align ?? 'left');
if (!in_array($align, ['left', 'center'], true)) {
    $align = 'left';
}
$level = (string) ($level ?? 'h2');
$level = $level === 'h1' ? 'h1' : 'h2';
$emphasis = (string) ($emphasis ?? '');
?>
<div class="section-heading section-heading--<?= e($align) ?>">
    <?php if ($eyebrow !== ''): ?>
        <p class="eyebrow"><?= e($eyebrow) ?></p>
    <?php endif; ?>
    <<?= $level ?><?= $headingId !== '' ? ' id="' . e($headingId) . '"' : '' ?>><?= editorial_title($title, $emphasis) ?></<?= $level ?>>
    <?php if ($lead !== ''): ?>
        <p class="section-heading__lead"><?= e($lead) ?></p>
    <?php endif; ?>
</div>
