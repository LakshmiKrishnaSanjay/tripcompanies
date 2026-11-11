# Cursor Prompt — Tripcompanies: Outbound Launch Scope and Destination Plan

Copy everything below the line into Cursor, after the current task has finished.

---

The client has confirmed the launch scope. Apply this change to the Tripcompanies site as it stands now. This is a content and scope update only: do not redesign anything or change the stack, brand, layouts or components. If something below refers to a page or file that doesn't exist, skip that item and tell me.

## 1. Launch scope: outbound only

The site launches with **outbound holidays from the UAE only**. Inbound UAE tours and standalone visa services will return later, so hide them without deleting their code.

Add to `includes/config.php`:

```php
const FEATURE_INBOUND = false;
const FEATURE_VISA    = false;
```

While a flag is `false`, remove that service from:
- header navigation, mega menus and the mobile menu
- search tabs (if only Holidays remains, show the search without tabs)
- home page sections, hero slides, service shortcuts and promo banners
- footer columns and links
- `sitemap.xml`, internal links and JSON-LD service listings

Direct requests to `/inbound`, `/inbound/*`, `/visa` and `/visa/*` return a temporary 302 redirect to `/outbound`.

Keep the visa information note on individual package and destination pages, because it helps outbound travellers. It must link to WhatsApp, not to `/visa`.

Update site-wide copy, page titles and meta descriptions so nothing promises inbound tours or standalone visa services. For example, change "Holidays & Visas from Dubai" to "Holiday Packages from Dubai". Copy should address UAE residents travelling abroad.

## 2. Approved destinations

These 8 countries in 5 regions are the only destinations on the site. Use the region names exactly as written.

| Region | Countries |
|---|---|
| South Caucasus | Armenia, Azerbaijan, Georgia |
| Central Asia | Kazakhstan |
| Southeast Asia | Singapore, Malaysia |
| Western Asia and Southeastern Europe | Turkey |
| East Africa | Kenya |

- Update `data/destinations.php` to contain exactly these 8 records, with slugs `armenia`, `azerbaijan`, `georgia`, `kazakhstan`, `singapore`, `malaysia`, `turkey`, `kenya`.
- Move every package and destination outside this list into `data/archive/` so it is preserved but no longer loaded. Slugs for removed destinations and packages must return 404.
- Replace old regions (Europe, Asia, Africa and similar) everywhere: Holidays mega menu, `/outbound`, the destinations index, filters, footer and autocomplete.
- A mega-menu column or region section shows its countries in the order above. Display regions in the table's order.
- Remove any home page copy, hero slide, deal or image that refers to a place outside this list, such as Paris, London, the Swiss Alps, Tokyo or Bali. Also remove generic claims about "Europe" and "worldwide" destinations.

## 3. Sample packages

Create at least 2 packages per destination, keeping the existing package data structure and marking every record as sample content. Prices, dates and hotel names are placeholders for the client to replace.

Use these routes as the basis:

| Country | Sample package ideas |
|---|---|
| Armenia | Yerevan with Garni and Geghard; Yerevan, Lake Sevan and Dilijan |
| Azerbaijan | Baku city break; Baku, Gabala and Shahdag |
| Georgia | Tbilisi and Mtskheta; Tbilisi, Gudauri, Kazbegi and Batumi |
| Kazakhstan | Almaty and Shymbulak; Almaty, Big Almaty Lake and Charyn Canyon |
| Singapore | Singapore city and Sentosa; Singapore family break |
| Malaysia | Kuala Lumpur and Genting; Kuala Lumpur and Langkawi |
| Turkey | Istanbul city break; Istanbul and Cappadocia |
| Kenya | Nairobi and Maasai Mara safari; Maasai Mara, Lake Nakuru and Amboseli |

Spread the packages across seasons and active deals so that no season tab, deal page, region or filter is empty. Each destination page must list its own packages.

## 4. Destination content

Write original copy for each destination page. Use these currencies: Armenia AMD, Azerbaijan AZN, Georgia GEL, Kazakhstan KZT, Singapore SGD, Malaysia MYR, Turkey TRY, Kenya KES.

Do not state visa rules, processing times, flight durations or "visa-free" claims as facts, because they vary by passport and change over time. Use a neutral line: "Visa requirements depend on your nationality and UAE residency. Message us on WhatsApp and we'll check for you." Leave flight time as an empty field for the client to confirm, and don't render it while empty.

## 5. Images

Every destination and package needs a photo that actually shows that country or route, such as:
- Armenia: Khor Virap with Mount Ararat
- Azerbaijan: Baku Flame Towers
- Georgia: Gergeti Trinity Church
- Kazakhstan: Big Almaty Lake or Charyn Canyon
- Singapore: Marina Bay
- Malaysia: Petronas Towers or Langkawi
- Turkey: Cappadocia balloons or Istanbul
- Kenya: Maasai Mara wildlife

Don't repeat an image on the same page, and write accurate alt text.

## 6. Acceptance checks

Report the result of each:
- [ ] Search the rendered pages and `/data` for removed destinations and regions; none appear outside `data/archive/`.
- [ ] No inbound or standalone visa link, section or search tab is visible anywhere, on desktop or mobile.
- [ ] `/inbound` and `/visa` temporarily redirect to `/outbound`.
- [ ] Setting either feature flag to `true` restores that service without code changes.
- [ ] All 8 destination pages return 200 and show at least 2 packages each.
- [ ] Removed slugs return 404, and search, filters and autocomplete only offer the 8 countries.
- [ ] Every WhatsApp enquiry contains the correct package.
- [ ] `sitemap.xml` lists only live pages, and there are no PHP warnings or console errors.
