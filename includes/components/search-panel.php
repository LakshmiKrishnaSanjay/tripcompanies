<?php
declare(strict_types=1);
/** @var string $id */
$id = preg_replace('/[^a-z0-9_-]/', '', (string) ($id ?? 'search')) ?? 'search';
$destinations = destinations_all();
$categories = experience_categories();
$visas = visas_all();
$showInbound = feature_on('FEATURE_INBOUND');
$showVisa = feature_on('FEATURE_VISA');
$tabCount = 1 + ($showInbound ? 1 : 0) + ($showVisa ? 1 : 0);
?>
<div class="search-panel__box" data-search>
    <?php if ($tabCount > 1): ?>
    <div class="tabs" role="tablist">
        <button class="tab" type="button" role="tab" id="<?= e($id) ?>-tab-holidays" aria-selected="true" aria-controls="<?= e($id) ?>-holidays" data-search-tab>Holidays</button>
        <?php if ($showInbound): ?>
        <button class="tab" type="button" role="tab" id="<?= e($id) ?>-tab-uae" aria-selected="false" aria-controls="<?= e($id) ?>-uae" data-search-tab>UAE Experiences</button>
        <?php endif; ?>
        <?php if ($showVisa): ?>
        <button class="tab" type="button" role="tab" id="<?= e($id) ?>-tab-visa" aria-selected="false" aria-controls="<?= e($id) ?>-visa" data-search-tab>Visa</button>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <form class="search-form is-active" id="<?= e($id) ?>-holidays" method="get" action="<?= e(url('/packages')) ?>">
        <label class="field"><span>Destination</span>
            <input name="destination" list="<?= e($id) ?>-destinations" placeholder="Georgia" autocomplete="off">
        </label>
        <datalist id="<?= e($id) ?>-destinations">
            <?php foreach ($destinations as $destination): ?>
                <option><?= e((string) $destination['name']) ?></option>
            <?php endforeach; ?>
        </datalist>
        <label class="field"><span>Travel month</span>
            <select name="month">
                <option value="">Any month</option>
                <?php foreach (travel_months() as $month): ?>
                    <option><?= e($month) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="field"><span>Travellers</span>
            <select name="travellers">
                <option value="">Any</option>
                <?php foreach (traveller_options() as $option): ?>
                    <option><?= e($option) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button class="btn btn--primary" type="submit">Search holidays</button>
    </form>
    <?php if ($showInbound): ?>
    <form class="search-form" id="<?= e($id) ?>-uae" method="get" action="<?= e(url('/inbound')) ?>">
        <label class="field"><span>Keyword</span><input name="q" type="search"></label>
        <label class="field"><span>Category</span>
            <select name="category">
                <option value="">All</option>
                <?php foreach ($categories as $category): ?>
                    <option><?= e($category) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button class="btn btn--primary" type="submit">Search experiences</button>
    </form>
    <?php endif; ?>
    <?php if ($showVisa): ?>
    <form class="search-form" id="<?= e($id) ?>-visa" method="get" action="<?= e(url('/visa')) ?>">
        <label class="field"><span>Country</span>
            <select name="country">
                <option value="">All countries</option>
                <?php foreach ($visas as $visa): ?>
                    <option value="<?= e((string) $visa['slug']) ?>"><?= e((string) $visa['country']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button class="btn btn--primary" type="submit">Search visas</button>
    </form>
    <?php endif; ?>
</div>
