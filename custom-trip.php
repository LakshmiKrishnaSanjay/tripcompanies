<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
$pageTitle = 'Tailor made trip request';
$pageDescription = 'Tell Tripcompanies the destinations, dates, travellers and budget. We reply on WhatsApp.';
$pageCanonical = '/custom-trip';
$hasHero = false;
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">
    <section class="section">
        <div class="container" style="max-width: 820px;">
            <?php partial('breadcrumbs', ['items' => [['label' => 'Home', 'href' => '/'], ['label' => 'Custom trip']]]); ?>
            <h1 style="font-size: clamp(2.6rem, 5vw, 4.4rem);">Tailor made trip</h1>
            <p class="lead" style="margin: 0.7rem 0 1rem;">Five short parts. Send them on WhatsApp, or by email if you prefer.</p>
            <form class="form" id="custom-trip" method="post" action="<?= e(url('/send-enquiry')) ?>">
                <input type="hidden" name="type" value="custom">
                <input type="hidden" name="return" value="/custom-trip">
                <p class="honeypot"><label>Company website<input name="company_website" tabindex="-1" autocomplete="off"></label></p>
                <fieldset class="form-part"><legend>Destinations</legend><label class="field"><span>Where to</span><input name="destination" required></label></fieldset>
                <fieldset class="form-part"><legend>When</legend><label class="field"><span>Month</span><select name="travel_month"><?php foreach (travel_months() as $month): ?><option><?= e($month) ?></option><?php endforeach; ?></select></label></fieldset>
                <fieldset class="form-part"><legend>Who</legend><label class="field"><span>Travellers</span><select name="travellers"><?php foreach (traveller_options() as $option): ?><option><?= e($option) ?></option><?php endforeach; ?></select></label></fieldset>
                <fieldset class="form-part"><legend>Style</legend>
                    <label class="field"><span>Budget in AED</span><input name="budget" inputmode="numeric"></label>
                    <label class="field"><span>Trip style</span><select name="style"><?php foreach (trip_types() as $label): ?><option><?= e($label) ?></option><?php endforeach; ?></select></label>
                    <label class="field"><span>Hotel level</span><select name="hotel"><option>Simple and central</option><option>Comfortable</option><option>A quieter, higher level</option></select></label>
                </fieldset>
                <fieldset class="form-part"><legend>Contact</legend>
                    <label class="field"><span>Name</span><input name="name" required></label>
                    <label class="field"><span>Phone</span><input name="phone" required></label>
                    <label class="field"><span>Notes</span><textarea name="message" rows="4" required minlength="10"></textarea></label>
                </fieldset>
                <div class="card-actions">
                    <button class="btn btn--primary" type="submit">Send by email</button>
                    <button class="btn btn--ghost" type="submit" formmethod="get" formaction="<?= e(url('/enquire')) ?>">Continue on WhatsApp</button>
                </div>
            </form>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
