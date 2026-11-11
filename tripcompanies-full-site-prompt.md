# Cursor Prompt — Tripcompanies: Full Travel Agency Website Build

Copy everything below the line into Cursor.

---

## 1. Role and objective

Act as a senior front-end and PHP developer who has shipped travel agency websites. Upgrade the existing Tripcompanies site (running at `http://localhost:8080/`) from a brochure-style page into a complete, commercial travel agency website.

The client's reference sites are Arabian Adventures, Holiday Factory and AFC Holidays. Match the **functionality, page types, section types and browsing experience** expected from those sites. Do not reproduce their branding, colours, copy, images, logos or exact layouts. All content and visual design must be original to Tripcompanies.

**Business facts**
- Dubai-based travel agency: outbound holidays, inbound UAE tours, visa services.
- Customers: UAE residents travelling abroad, and Europeans visiting the UAE.
- Packages change by season.
- Primary conversion: **WhatsApp enquiry** (`+971 54 558 2123`). There is no online payment.

## 2. Constraints

- **Stack:** PHP 8, HTML5, CSS3, vanilla JavaScript only. No frameworks, npm, build step, database or Composer. Must run on standard cPanel/Apache hosting.
- Keep the existing `/data`, `/includes`, `/assets` organisation, `.htaccess` clean URLs and current page URLs.
- **Keep the existing brand system unchanged:** crimson/gold CSS tokens, Cormorant Garamond + Poppins, the logo files, and the working light/dark toggle. Do not introduce colours from the reference sites. Every new component must work in both themes using the existing tokens.
- Do not add new animation libraries in this pass. This is a commercial site, so speed and clarity come first.

**Do not build (out of scope):** online payments, cart or checkout, customer accounts and login, booking management, live flight or hotel APIs, an AI package builder, loyalty points, gift cards, mobile app promotion, Arabic translation, prize-draw popups, or a spin-the-wheel offer.

### Honest content rule (mandatory)

Never invent business claims. Add `data/trust.php` with nullable fields: `licence_number`, `years_in_business`, `travellers_served`, `google_rating`, `google_review_count`, `visa_success_rate`, `response_time`, `opening_hours`, `office_address`, `awards[]`, `partners[]`.

- A trust element renders **only** when its field has a real value. If a whole section has no data, omit the section.
- Remove these existing unverified claims unless they are set in `data/trust.php`: "Visa support for 30+ countries", "Replies within 1 hour", "24/7".
- Show airline or partner logos only when listed in `partners[]`.
- Show a "was" price or "Save X%" only when `price_was` is set on that package.
- Mark all seeded packages, prices, departure dates, visa details and reviews with `'is_sample' => true`. Add `SHOW_SAMPLE_CONTENT` in `includes/config.php`. When false, sample records do not render.

## 3. Current defects to fix first

1. **Home hero photo is invisible.** The slide image loads and its slide has opacity 1, yet the hero displays as solid black on desktop. Find the layer covering it and fix it in both themes.
2. **WhatsApp is missing from the desktop header**, although it is the site's primary action. No visible `wa.me` link exists there at 1440px.
3. Fix these from the previous review if still present:
   - no side padding in the mobile hero
   - labels below 12px, or below 4.5:1 contrast
   - the same photo repeated on one page

## 4. Information architecture

| Page | URL | Status |
|---|---|---|
| Home | `/` | Rebuild |
| All packages (search results) | `/packages` | Rebuild |
| Package detail | `/packages/{slug}` | Upgrade |
| Deals hub | `/deals` | New |
| Seasonal deal page | `/deals/{slug}` | New |
| Destinations index | `/destinations` | New |
| Destination landing page | `/destinations/{slug}` | New |
| Outbound holidays | `/outbound` | Upgrade (region landing) |
| Inbound UAE | `/inbound` | Upgrade |
| UAE experience detail | `/inbound/{slug}` | New |
| Visa services | `/visa` | Upgrade |
| Visa country detail | `/visa/{slug}` | New |
| Tailor-made trip request | `/custom-trip` | New |
| About | `/about` | Upgrade |
| How to book | `/how-to-book` | New |
| FAQ | `/faq` | New |
| Blog list and article | `/blog`, `/blog/{slug}` | New |
| Contact | `/contact` | Upgrade |
| Terms, privacy, cancellation policy | `/terms`, `/privacy`, `/cancellation-policy` | New, with clearly marked placeholder text for the client's legal review |

Unknown slugs return the styled 404 page with a real 404 status.

## 5. Global components

**Utility bar** (above header, desktop): phone, WhatsApp, email and opening hours (if set) on the left. Currency selector and theme toggle on the right. Optional one-line announcement driven by `data/site.php`.

**Main header** (sticky, condensing on scroll): logo; navigation; search icon; a clearly visible crimson "WhatsApp Us" button.

**Mega menus**
- **Deals:** the active seasonal campaigns.
- **Holidays:** columns by region (Europe, Eurasia, Asia, Africa) listing destinations, plus one featured package card.
- **UAE Experiences:** categories (Desert, City Tours, Cruises, Attractions, Theme Parks, Transfers) plus one featured card.
- **Visa:** the countries in `data/visas.php`.
- **Custom Trip**
- **About:** About, How to Book, Blog, FAQ, Contact.

Menus open on hover and click, work with the keyboard, and become an accordion drawer on mobile.

**Site search** (shared PHP partial, three tabs):
- *Holidays:* destination autocomplete, travel month, travellers.
- *UAE Experiences:* keyword, category.
- *Visa:* country.

Forms submit with GET to the relevant listing page and are filtered **server-side in PHP**, so results have shareable URLs and work without JavaScript.

**Package card** (one reusable partial, used everywhere): image; duration badge; optional badge (Bestseller, Limited Seats, Honeymoon, Family); destination; title; icon row for inclusions (Flights, Hotel, Transfers, Sightseeing, Visa, with "+N more"); next departure if set; "From AED X per person, twin share"; optional was/save; wishlist heart; primary "Enquire on WhatsApp" and secondary "View details". Cards in a row share equal heights with aligned prices and buttons.

**Experience card:** image, category, title, duration, location, badge, "From AED X", enquiry button.

**Enquiry drawer:** opens from any card. Pre-fills the package, asks month, adults, children and name, then opens WhatsApp with a structured message. A secondary option requests a callback.

**Commerce helpers** (`localStorage`, wrapped in try/catch, hidden when empty):
- Wishlist, with a header counter and a `/packages?view=wishlist` view.
- Recently viewed packages.

**Currency selector:** AED (default), EUR, GBP, USD. Rates come from `data/site.php`. Converted prices are labelled "approx." and the WhatsApp message always quotes AED.

**Contact helpers**
- Desktop: floating WhatsApp button plus a "Request a callback" tab.
- Mobile: sticky bottom bar with WhatsApp, Call and Search, replacing the floating button. It must not cover content.

**Footer:** enquiry/newsletter strip (with consent checkbox); columns for Holidays, UAE Experiences, Visa, Company and Legal; contact details; social links; licence number if set.

## 6. Home page order

Use descriptive, search-friendly headings ("Holiday Packages from Dubai", "Visa Services", "Things to Do in the UAE"). Replace poetic headings like "Three quiet steps". Keep the page dense and scannable.

1. **Hero promo carousel:** up to 3 slides from `data/promotions.php`, each linking to a deal, destination or service. Autoplay with pause control, swipe, and no layout shift.
2. **Search panel** overlapping the bottom of the hero.
3. **Seasonal deals:** pill tabs by active campaign, card carousel, "View all".
4. **Browse by trip type:** Honeymoon, Family, Group Departures, City Breaks, Adventure, Luxury.
5. **Top destinations:** image tiles with name and "From AED X".
6. **Two promo banners:** Tailor-Made Trips, and Visa Assistance.
7. **UAE experiences:** category tabs with card rows.
8. **Visa services:** country tiles, each linking to its visa page.
9. **Why Tripcompanies** and a short **How to Book** in 3 steps.
10. **Trust band:** stats, awards, partners. Renders only with real data.
11. **Traveller reviews:** carousel of photo or text reviews, with destination.
12. **Instagram:** a grid linking to @tripcompanies.
13. **Travel guides:** latest 3 blog articles.
14. **Recently viewed** (hidden when empty).
15. **FAQ** (5 to 6 items) and a **final enquiry form**.

## 7. Key page templates

**`/packages`:** breadcrumb, result count, search summary. Filter sidebar (bottom sheet on mobile): region, destination, season/month, trip type, duration, price range, inclusions. Sort: recommended, price, duration. Pagination at 12 per page. Empty state with a Custom Trip call to action.

**`/packages/{slug}`:** gallery with lightbox; title, badges, duration, route; sticky price and enquiry box (date, travellers, WhatsApp, callback; becomes a bottom bar on mobile); inclusions icon row; tabs or anchors for Overview, Highlights, Day-by-Day Itinerary, Hotels, Included/Excluded, Departure Dates, Visa Information, Terms; reviews; related packages. Breadcrumb.

**`/destinations/{slug}`:** full-width hero with name and tagline, highlight thumbnails; trust strip (if data exists); why visit; packages for that destination; essential information (best time to travel, currency, visa, flying time from Dubai); reviews; FAQ; enquiry form.

**`/deals/{slug}`:** campaign banner, travel window, optional real countdown only if `ends_at` is set, filtered package grid.

**`/inbound/{slug}`:** gallery, duration, pickup, highlights, what's included, what to bring, cancellation note, enquiry box, related experiences. Written for European visitors.

**`/visa` and `/visa/{slug}`:** country grid with visa types; on detail pages, processing time, required documents checklist, process steps, starting fee if set, FAQ and "Apply via WhatsApp". Include a clear note that the final decision rests with the embassy and that no approval is guaranteed.

**`/custom-trip`:** short multi-step form: destinations, dates or month, travellers, budget, trip style, hotel level, contact details. Submit via WhatsApp or email.

**`/how-to-book`, `/faq`, `/blog`:** clean, readable templates. FAQ is grouped by topic with accordions.

## 8. Data layer (PHP arrays in `/data`)

Add or extend: `site.php`, `trust.php`, `promotions.php`, `deals.php`, `destinations.php`, `packages.php`, `experiences.php`, `visas.php`, `reviews.php`, `posts.php`, `faqs.php`.

`packages.php` fields: `slug, title, destination_slug, region, seasons[], deal_slugs[], trip_types[], nights, days, route[], price_from, price_was, currency, price_basis, badge, departures[], inclusion_icons[], gallery[], overview, highlights[], itinerary[], hotels[], included[], excluded[], visa_note, terms, is_featured, is_sample`.

Seed realistic sample data for the destinations already on the site (Switzerland, France, United Kingdom, Turkey, Georgia, Azerbaijan, Japan, Indonesia, Kenya), with at least 3 packages per active season, so every layout can be judged filled. Every image must match its destination, and no image repeats on a page. Use licensed placeholder photography (Unsplash) referenced from the data files. Never copy images from the reference sites.

Add `includes/functions.php` helpers for filtering, sorting, pagination, price formatting and `wa_link()`. All output goes through `e()`. Validate `$_GET` against known values.

Update `send-enquiry.php` for callback, custom trip and newsletter submissions, keeping server validation, the honeypot and rate limiting.

## 9. Design direction

Keep the current brand identity, but shift the layout from editorial to **premium commercial**:
- Consistent card grid, 1280 to 1360px container, 64 to 96px section spacing.
- Poppins 600 for card titles, prices, filters and all UI. Reserve Cormorant Garamond for H1 and H2 display headings, because it is hard to read at small sizes.
- Body text at least 16px; labels at least 12px; WCAG AA contrast in both themes.
- Every interactive element has hover, focus and active states. Skeletons or fixed aspect ratios prevent layout shift.
- Motion stays subtle: reveal animations must never leave content invisible.
- The site must look complete and dense with real inventory, not like a long landing page.

## 10. SEO and performance

- Unique title, description, canonical and Open Graph tags per page, with titles like "Switzerland Holiday Packages from Dubai | Tripcompanies".
- Exactly one H1 per page; breadcrumbs with `BreadcrumbList`.
- JSON-LD: `TravelAgency`, `Product`/`Offer` for packages (with sample records excluded), `FAQPage`. Add `Review` markup only for real reviews.
- Generate `sitemap.xml` dynamically via `sitemap.php` from the data files (with an `.htaccess` rewrite).
- `srcset`/`sizes`, `loading="lazy"` below the fold, the first hero image preloaded and eager. Target Lighthouse 90+ on mobile.

## 11. Acceptance criteria

Before finishing, verify and report the result of each:
- [ ] Hero photo is visible and WhatsApp is visible in the header, in both themes.
- [ ] Every URL in section 4 returns 200, and an unknown slug returns 404.
- [ ] Search and every filter work with JavaScript disabled, and their URLs are shareable.
- [ ] Every enquiry path opens WhatsApp with the correct package, month and travellers.
- [ ] Mega menus, tabs, carousels, drawers and accordions work by keyboard.
- [ ] No unverified claim renders when `data/trust.php` is empty.
- [ ] `SHOW_SAMPLE_CONTENT = false` removes all sample records without errors or empty gaps.
- [ ] Both themes look correct at 360, 768, 1024 and 1440px with no horizontal scroll.
- [ ] No PHP warnings under `error_reporting(E_ALL)`, and no console errors.

## 12. Build order

1. Fix section 3 defects.
2. Build the data layer and helpers.
3. Build global components (header, mega menus, search, cards, enquiry drawer, footer).
4. Rebuild Home.
5. Build listing and package detail.
6. Build destination, deals, inbound and visa templates.
7. Build the remaining pages.
8. Complete SEO, performance and the acceptance checklist.

Work one step at a time and summarise what changed after each step.
