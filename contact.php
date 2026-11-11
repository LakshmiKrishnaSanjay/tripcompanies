<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
$pageTitle = 'Contact the Dubai desk';
$pageDescription = 'Message Tripcompanies on WhatsApp or send a note from Dubai.';
$pageCanonical = '/contact';
$hasHero = true;
$topic = (string) ($_GET['topic'] ?? '');
$packageName = clean_line((string) ($_GET['package'] ?? ''), 120);
$flash = flash_get('enquiry');
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">
    <section class="page-hero page-hero--short">
        <img class="media-fill" src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&fm=webp&q=75&w=2000" alt="Dubai skyline along the water at blue hour" width="2000" height="1100">
        <div class="page-hero__content on-photo">
            <p class="eyebrow">Contact</p>
            <h1>Write to the desk</h1>
            <p class="lead">Destination, month, and who is travelling. We answer from Dubai.</p>
        </div>
    </section>
    <section class="section">
        <div class="container split">
            <aside>
                <p class="eyebrow">Dubai desk</p>
                <h2>A direct line</h2>
                <a class="btn btn--primary" href="<?= e(wa_link('Hi Tripcompanies, I would like to enquire.')) ?>">WhatsApp Us</a>
                <ul class="contact-list">
                    <li><a href="tel:<?= e((string) site('phone_tel')) ?>"><?= e((string) site('phone_display')) ?></a></li>
                    <li><a href="mailto:<?= e((string) site('email')) ?>"><?= e((string) site('email')) ?></a></li>
                    <li><?= e(trust_has('office_address') ? (string) trust('office_address') : (string) site('location')) ?></li>
                    <?php if (trust_has('opening_hours')): ?><li><?= e((string) trust('opening_hours')) ?></li><?php endif; ?>
                </ul>
            </aside>
            <div>
                <?php if (is_array($flash) && ($flash['status'] ?? '') === 'success'): ?><p class="notice">Received. If email is delayed, WhatsApp is the faster reply.</p><?php endif; ?>
                <?php if (is_array($flash) && ($flash['status'] ?? '') === 'error'): ?><p class="notice"><?= e((string) ($flash['errors']['form'] ?? 'Please check the form and try again.')) ?></p><?php endif; ?>
                <form class="form" id="callback" method="post" action="<?= e(url('/send-enquiry')) ?>" style="padding: 1rem;">
                    <input type="hidden" name="type" value="<?= $topic === 'callback' ? 'callback' : 'enquiry' ?>">
                    <input type="hidden" name="return" value="/contact">
                    <p class="honeypot"><label>Company website<input name="company_website" tabindex="-1" autocomplete="off"></label></p>
                    <h2><?= $topic === 'callback' ? 'Request a callback' : 'Send an enquiry' ?></h2>
                    <div class="form-row">
                        <label class="field"><span>Name</span><input name="name" required value="<?= e((string) ($flash['old']['name'] ?? '')) ?>"></label>
                        <label class="field"><span>Phone</span><input name="phone" required value="<?= e((string) ($flash['old']['phone'] ?? '')) ?>"></label>
                        <label class="field"><span>Destination or package</span><input name="destination" required value="<?= e((string) ($flash['old']['destination'] ?? $packageName)) ?>"></label>
                        <label class="field"><span>Travel month</span>
                            <select name="travel_month"><?php foreach (travel_months() as $month): ?><option<?= (($flash['old']['travel_month'] ?? '') === $month) ? ' selected' : '' ?>><?= e($month) ?></option><?php endforeach; ?></select>
                        </label>
                        <label class="field"><span>Travellers</span>
                            <select name="travellers"><?php foreach (traveller_options() as $option): ?><option<?= (($flash['old']['travellers'] ?? '') === $option) ? ' selected' : '' ?>><?= e($option) ?></option><?php endforeach; ?></select>
                        </label>
                    </div>
                    <label class="field"><span>Note</span><textarea name="message" required minlength="10" rows="4"><?= e((string) ($flash['old']['message'] ?? '')) ?></textarea></label>
                    <button class="btn btn--primary" type="submit"><?= $topic === 'callback' ? 'Request a callback' : 'Send by email' ?></button>
                </form>
            </div>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
