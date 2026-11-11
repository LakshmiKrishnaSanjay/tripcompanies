<?php
declare(strict_types=1);
?>
<section class="page-hero page-hero--short">
    <img class="page-hero__img" src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?auto=format&fit=crop&fm=webp&q=75&w=2000" alt="" width="2000" height="1250">
    <div class="page-hero__shade" aria-hidden="true"></div>
    <div class="container page-hero__content">
        <p class="eyebrow">404</p>
        <h1>This page has left the route</h1>
        <p class="lead">The link may have changed. The desk is still here. Start again, or send us the trip you were looking for.</p>
        <div class="hero__actions">
            <a class="btn btn--primary" href="<?= e(wa_link('Hi Tripcompanies, I was looking for a page on your website and could not find it.')) ?>" target="_blank" rel="noopener noreferrer">WhatsApp Us</a>
            <a class="btn btn--outline" href="<?= e(url('/')) ?>">Back home</a>
        </div>
    </div>
</section>
