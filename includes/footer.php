<?php
declare(strict_types=1);
$year = date('Y');
$footerDestinations = destinations_all();
$footerDeals = deals_active();
$footerWhatsApp = wa_link('Hi Tripcompanies, I would like to enquire.');
?>
<footer class="site-footer">
    <div class="ft-cta">
        <?php $footerPhoto = 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&fm=webp&q=75&w=2400'; ?>
        <img class="ft-cta__img" src="<?= e($footerPhoto) ?>" srcset="<?= e(image_srcset($footerPhoto)) ?>" sizes="100vw" alt="" width="2400" height="1200" loading="lazy" decoding="async">
        <div class="container ft-cta__in">
            <p class="ft-cta__tag"><?= e((string) site('tagline')) ?></p>
            <h2>Your next holiday is <em>one message</em> away</h2>
            <div class="ft-cta__actions">
                <a class="ft-btn" href="<?= e($footerWhatsApp) ?>" target="_blank" rel="noopener noreferrer"><?= icon('whatsapp') ?>WhatsApp Us</a>
                <a class="ft-call" href="tel:<?= e((string) site('phone_tel')) ?>"><?= icon('phone') ?><?= e((string) site('phone_display')) ?></a>
            </div>
        </div>
    </div>

    <div class="container ft-main">
        <div class="ft-brand">
            <a class="logo" href="<?= e(url('/')) ?>"><img src="<?= e(asset('img/logo-white.png')) ?>" alt="Tripcompanies" width="61" height="58"></a>
            <p>Holiday packages from Dubai, planned for people living in the UAE.</p>
            <form class="ft-news" method="post" action="<?= e(url('/send-enquiry')) ?>">
                <input type="hidden" name="type" value="newsletter">
                <input type="hidden" name="return" value="<?= e(current_path()) ?>">
                <label class="ft-news__label" for="ft-email">Get seasonal deals</label>
                <div class="ft-pill">
                    <input id="ft-email" name="email" type="email" required autocomplete="email" placeholder="Your email address">
                    <button type="submit" aria-label="Subscribe"><?= icon('arrow') ?></button>
                </div>
                <label class="ft-consent"><input type="checkbox" name="consent" value="yes" required><span>I agree to hear from Tripcompanies about trips.</span></label>
                <p class="honeypot"><label>Company website<input name="company_website" tabindex="-1" autocomplete="off"></label></p>
            </form>
        </div>

        <div class="ft-col ft-col--two">
            <h3>Destinations</h3>
            <ul>
                <?php foreach ($footerDestinations as $destination): ?>
                    <li><a href="<?= e(url('/destinations/' . $destination['slug'])) ?>"><?= e((string) $destination['name']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="ft-col">
            <h3>Holidays</h3>
            <ul>
                <li><a href="<?= e(url('/packages')) ?>">All Packages</a></li>
                <?php foreach ($footerDeals as $deal): ?>
                    <li><a href="<?= e(url('/deals/' . $deal['slug'])) ?>"><?= e((string) $deal['title']) ?></a></li>
                <?php endforeach; ?>
                <li><a href="<?= e(url('/custom-trip')) ?>">Customized Tours</a></li>
            </ul>
        </div>

        <div class="ft-col">
            <h3>Company</h3>
            <ul>
                <li><a href="<?= e(url('/about')) ?>">About Us</a></li>
                <li><a href="<?= e(url('/how-to-book')) ?>">How to Book</a></li>
                <li><a href="<?= e(url('/blog')) ?>">Blog</a></li>
                <li><a href="<?= e(url('/faq')) ?>">FAQ</a></li>
                <li><a href="<?= e(url('/contact')) ?>">Contact Us</a></li>
            </ul>
        </div>

        <div class="ft-col ft-contact">
            <h3>Contact Us</h3>
            <ul>
                <li><a href="<?= e($footerWhatsApp) ?>" target="_blank" rel="noopener noreferrer"><?= icon('whatsapp') ?>WhatsApp</a></li>
                <li><a href="tel:<?= e((string) site('phone_tel')) ?>"><?= icon('phone') ?><?= e((string) site('phone_display')) ?></a></li>
                <li><span class="ft-plain"><?= icon('pin') ?><?= e((string) site('city')) ?>, UAE</span></li>
                <li><a href="<?= e((string) site('instagram')) ?>" target="_blank" rel="noopener noreferrer"><?= icon('instagram') ?>Instagram</a></li>
            </ul>
        </div>
    </div>

    <div class="ft-base">
        <div class="container ft-base__in">
            <p>© <?= e($year) ?> Tripcompanies. All rights reserved.</p>
            <p><a href="<?= e(url('/terms')) ?>">Terms</a><a href="<?= e(url('/privacy')) ?>">Privacy</a><a href="<?= e(url('/cancellation-policy')) ?>">Cancellation Policy</a></p>
        </div>
    </div>
</footer>
<?php partial('enquiry-drawer'); ?>
<?php require __DIR__ . '/whatsapp-float.php'; ?>
<nav class="mobile-bar" aria-label="Quick actions">
    <a href="<?= e(wa_link('Hi Tripcompanies, I would like to enquire.')) ?>" target="_blank" rel="noopener noreferrer"><?= icon('whatsapp') ?>WhatsApp</a>
    <a href="tel:<?= e((string) site('phone_tel')) ?>"><?= icon('phone') ?>Call</a>
    <button type="button" data-search-open><?= icon('search') ?>Search</button>
</nav>
<script src="<?= e(asset('js/main.js')) ?>" defer></script>
</body>
</html>
