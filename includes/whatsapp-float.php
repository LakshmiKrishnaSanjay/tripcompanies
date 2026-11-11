<?php
declare(strict_types=1);
?>
<a class="wa-float" href="<?= e(wa_link('Hi Tripcompanies, I would like to enquire.')) ?>" target="_blank" rel="noopener noreferrer" aria-label="Chat with a travel expert">
    <?= icon('whatsapp', 'icon wa-float__icon') ?>
    <span class="wa-float__tip" aria-hidden="true">Chat with a travel expert</span>
</a>
<a class="callback-tab" href="<?= e(url('/contact?topic=callback')) ?>">Request a callback</a>
