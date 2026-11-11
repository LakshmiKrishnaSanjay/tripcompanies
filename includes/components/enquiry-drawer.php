<?php
declare(strict_types=1);
?>
<div class="drawer" id="enquiry-drawer" hidden>
    <form class="drawer__panel" method="get" action="<?= e(url('/enquire')) ?>" data-enquiry-form>
        <div class="cluster" style="justify-content: space-between;">
            <h2 class="display" style="font-size: 2.2rem;">Enquire on WhatsApp</h2>
            <button class="icon-btn" type="button" data-drawer-close aria-label="Close"><?= icon('close') ?></button>
        </div>
        <p class="lead" data-enquiry-title style="margin: 0.6rem 0 1rem;"></p>
        <input type="hidden" name="package_slug" value="">
        <input type="hidden" name="package" value="">
        <input type="hidden" name="experience" value="">
        <input type="hidden" name="visa" value="">
        <input type="hidden" name="kind" value="package">
        <div class="form-row">
            <label class="field"><span>Travel month</span>
                <select name="month" required>
                    <?php foreach (travel_months() as $month): ?><option><?= e($month) ?></option><?php endforeach; ?>
                </select>
            </label>
            <label class="field"><span>Adults</span>
                <select name="adults"><?php foreach (traveller_options() as $option): ?><option><?= e($option) ?></option><?php endforeach; ?></select>
            </label>
            <label class="field"><span>Children</span>
                <select name="children"><option>0</option><?php foreach (traveller_options() as $option): ?><option><?= e($option) ?></option><?php endforeach; ?></select>
            </label>
            <label class="field"><span>Your name</span><input name="name" required maxlength="80"></label>
        </div>
        <div class="card-actions" style="margin-top: 1rem;">
            <button class="btn btn--primary" type="submit">Open WhatsApp</button>
            <a class="btn btn--ghost" href="<?= e(url('/contact?topic=callback')) ?>">Request a callback</a>
        </div>
        <p class="label" style="margin-top: 0.8rem;">The WhatsApp message quotes the price in AED.</p>
    </form>
</div>
