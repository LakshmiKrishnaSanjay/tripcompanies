<?php
declare(strict_types=1);
$ctaTitle = (string) ($ctaTitle ?? 'Your next trip starts with a message');
$ctaText = (string) ($ctaText ?? 'Tell us where you want to go. We answer on WhatsApp with a clear, unhurried plan.');
$ctaMessage = (string) ($ctaMessage ?? "Hi Tripcompanies, I'd like to plan a trip.");
$ctaImage = 'https://images.unsplash.com/photo-1473580044384-7ba9967e16a0?auto=format&fit=crop&fm=webp&q=75&w=2000';
$ctaSet = image_srcset($ctaImage);
?>
<section class="cta-band">
    <img class="cta-band__img" src="<?= e($ctaImage) ?>"<?php if ($ctaSet !== ''): ?> srcset="<?= e($ctaSet) ?>" sizes="100vw"<?php endif; ?> alt="" width="2000" height="1250" loading="lazy" decoding="async">
    <div class="cta-band__shade" aria-hidden="true"></div>
    <div class="container cta-band__inner">
        <h2><?= editorial_title($ctaTitle, 'message') ?></h2>
        <p><?= e($ctaText) ?></p>
        <a class="btn btn--white" href="<?= e(wa_link($ctaMessage)) ?>" target="_blank" rel="noopener noreferrer">WhatsApp Us</a>
    </div>
</section>
