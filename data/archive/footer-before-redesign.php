<?php
declare(strict_types=1);
$year = date('Y');
?>
<footer class="site-footer">
    <div class="ft-glow" aria-hidden="true"></div>
    <div class="container">
        <div class="ft-top">
            <div>
                <p class="ft-label">Your next trip</p>
                <h2 class="ft-title">Where to <em>next?</em></h2>
            </div>
            <form method="post" action="<?= e(url('/send-enquiry')) ?>">
                <input type="hidden" name="type" value="newsletter">
                <input type="hidden" name="return" value="<?= e(current_path()) ?>">
                <p class="ft-label">Trip notes and seasonal deals</p>
                <div class="ft-pill">
                    <input name="email" type="email" required autocomplete="email" placeholder="Your email address" aria-label="Your email address">
                    <button type="submit" aria-label="Subscribe">→</button>
                </div>
                <label class="ft-consent"><input type="checkbox" name="consent" value="yes" required><span>I agree to hear from Tripcompanies about trips.</span></label>
                <p class="honeypot"><label>Company website<input name="company_website" tabindex="-1" autocomplete="off"></label></p>
            </form>
        </div>

        <nav class="ft-dest" aria-label="Destinations"><?php $footerDestinations = destinations_all(); $footerLast = count($footerDestinations) - 1; foreach ($footerDestinations as $footerIndex => $destination): ?><a href="<?= e(url('/destinations/' . $destination['slug'])) ?>"><?= e((string) $destination['name']) ?></a><?php if ($footerIndex !== $footerLast): ?><span aria-hidden="true">✦</span><?php endif; ?><?php endforeach; ?></nav>

        <div class="ft-grid">
            <div>
                <a class="logo" href="<?= e(url('/')) ?>"><img src="<?= e(asset('img/logo-white.png')) ?>" alt="Tripcompanies"></a>
                <p>A Dubai desk for holidays abroad, planned for people living in the UAE and handled on WhatsApp.</p>
            </div>
            <div><h3>Explore</h3><ul>
                <li><a href="<?= e(url('/packages')) ?>">All packages</a></li>
                <li><a href="<?= e(url('/deals')) ?>">Deals</a></li>
                <li><a href="<?= e(url('/custom-trip')) ?>">Customized Tours</a></li>
            </ul></div>
            <div><h3>Company</h3><ul>
                <li><a href="<?= e(url('/about')) ?>">About</a></li>
                <li><a href="<?= e(url('/how-to-book')) ?>">How to Book</a></li>
                <li><a href="<?= e(url('/blog')) ?>">Blog</a></li>
                <li><a href="<?= e(url('/faq')) ?>">FAQ</a></li>
            </ul></div>
            <div><h3>Contact</h3><ul>
                <li><a href="<?= e(wa_link('Hi Tripcompanies, I would like to enquire.')) ?>">WhatsApp</a></li>
                <li><a href="tel:<?= e((string) site('phone_tel')) ?>"><?= e((string) site('phone_display')) ?></a></li>
                <li><a href="<?= e(url('/contact')) ?>">Contact us</a></li>
                <li><a href="<?= e((string) site('instagram')) ?>">Instagram</a></li>
            </ul></div>
        </div>
    </div>

    <div class="ft-word" aria-hidden="true">tripcompanies</div>

    <div class="container ft-base">
        <p>© <?= e($year) ?> Tripcompanies. All rights reserved.</p>
        <p><a href="<?= e(url('/terms')) ?>">Terms</a><a href="<?= e(url('/privacy')) ?>">Privacy</a><a href="<?= e(url('/cancellation-policy')) ?>">Cancellation policy</a></p>
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
