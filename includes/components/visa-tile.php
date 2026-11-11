<?php
declare(strict_types=1);
/** @var array<string, mixed> $visa */
$compact = (bool) ($compact ?? false);
$country = (string) ($visa['country'] ?? '');
$message = 'Hi Tripcompanies, I need a visa for ' . $country . '.';
?>
<?php if ($compact): ?>
    <a class="visa-tile" href="<?= e(wa_link($message)) ?>" target="_blank" rel="noopener noreferrer">
        <span class="visa-tile__flag" aria-hidden="true"><?= e((string) ($visa['flag'] ?? '')) ?></span>
        <span class="visa-tile__name"><?= e($country) ?></span>
        <span class="visa-tile__go"><?= icon('arrow', 'icon') ?></span>
    </a>
<?php else: ?>
    <article class="card visa-card">
        <header class="visa-card__head">
            <span class="visa-tile__flag" aria-hidden="true"><?= e((string) ($visa['flag'] ?? '')) ?></span>
            <div>
                <h2 class="visa-card__title"><?= e($country) ?></h2>
                <p class="visa-card__time"><?= icon('clock', 'icon') ?> Typical timeline: <?= e((string) ($visa['processing'] ?? '')) ?></p>
            </div>
        </header>
        <p><?= e((string) ($visa['summary'] ?? '')) ?></p>
        <div class="accordion" data-accordion>
            <details>
                <summary>Documents we usually prepare</summary>
                <div class="accordion__body">
                    <ul class="check-list">
                        <?php foreach ($visa['documents'] ?? [] as $doc): ?>
                            <li><?= icon('check', 'icon') ?> <?= e((string) $doc) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </details>
        </div>
        <a class="text-link" href="<?= e(wa_link($message)) ?>" target="_blank" rel="noopener noreferrer">Apply via WhatsApp <?= icon('arrow', 'icon') ?></a>
    </article>
<?php endif; ?>
