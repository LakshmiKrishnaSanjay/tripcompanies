<?php
declare(strict_types=1);
$variant = (string) ($variant ?? 'section');
if (!in_array($variant, ['section', 'hero'], true)) {
    $variant = 'section';
}
?>
<div class="flight-path flight-path--<?= e($variant) ?>" aria-hidden="true">
    <svg class="flight-path__svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path class="flight-path__line" d="M0 78 C 160 20, 280 100, 460 62 S 760 10, 920 58 1120 96, 1200 46"/>
        <circle class="flight-path__pin" cx="180" cy="46" r="5"/>
        <circle class="flight-path__pin flight-path__pin--brand" cx="560" cy="70" r="5"/>
        <circle class="flight-path__pin" cx="960" cy="42" r="5"/>
    </svg>
    <span class="flight-path__plane"><?= icon('plane', 'icon') ?></span>
</div>
