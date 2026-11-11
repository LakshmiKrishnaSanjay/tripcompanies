# Cursor Prompt — Tripcompanies Website

Copy everything below the line into Cursor.

---

Build a premium, fully responsive marketing website for **Tripcompanies**, a Dubai-based travel agency.

**Tech stack (strict):** plain **PHP 8 + HTML5 + CSS3 + vanilla JavaScript** only. No frameworks, no Node/npm, no build step, no React/Vue/Next, no Tailwind, no TypeScript, no database. It must run on any standard shared hosting (cPanel/Apache) by just uploading the files.
- PHP is used only for includes (shared header/footer), looping over content arrays, and the contact form mailer.
- Styling: one hand-written `assets/css/style.css` using CSS custom properties, Flexbox and Grid. Mobile-first media queries.
- JavaScript: one `assets/js/main.js` (vanilla ES6) for the menu, sticky header, hero slider, tabs, filters, accordions, carousel, scroll-reveal (IntersectionObserver) and WhatsApp links. No jQuery.
- Icons: inline SVG (or the Lucide/Feather SVG files copied into `assets/icons/`). Fonts from Google Fonts via `<link>`.
- All content lives in PHP array files under `/data` so the client can edit packages easily without touching the layout.

## 1. Brand facts (use exactly)

- Brand name: **Tripcompanies** (written as one word; logo shows "trip companies")
- Domain: **tripcompanies.com**
- Tagline / hashtag from their social: **#BeyondTheRoutine**
- Location: **Dubai, United Arab Emirates**
- Phone & WhatsApp: **+971 54 558 2123**
- Email: **pooja.tripcompanioes@gmail.com** (put in `/data/site.php` as a variable — it may be corrected later)
- Instagram: https://www.instagram.com/tripcompanies
- Industry: Tourism — Inbound packages, Outbound packages, Visa services
- Visa destinations to feature: Schengen, UK, USA, Canada, Turkey, Australia, Japan, China, Saudi Arabia (+ "and many more")
- Target audience: UAE residents travelling abroad, and Europeans visiting the UAE
- Markets served: Europe, Africa (and UAE inbound)
- Packages: Yes — **seasonal packages** (they change by season)
- Style requested: **Premium**
- **Primary conversion: "WhatsApp Us"** — every CTA should lead to WhatsApp

WhatsApp link: `https://wa.me/971545582123?text=` + URL-encoded prefilled message. Make a PHP helper `wa_link($message)` in `includes/functions.php` (using `rawurlencode`) and use context-aware messages, e.g. "Hi Tripcompanies, I'm interested in the Schengen visa service."

## 2. Colour system (from their logo + premium direction)

The logo is white on a vivid crimson (#EC0A44). Keep crimson as the hero brand colour, and pair it with deep midnight, warm ivory and a champagne-gold accent so it feels luxury rather than loud.

Define as CSS custom properties in `:root` at the top of `style.css`:

| Token | Hex | Use |
|---|---|---|
| `brand` (Crimson) | `#EC0A44` | Primary buttons, key highlights, logo badge |
| `brand-dark` | `#B8072F` | Button hover, pressed states |
| `brand-soft` | `#FDE8EE` | Tinted section backgrounds, badges |
| `ink` (Midnight) | `#14121F` | Headings, footer, dark sections, overlays |
| `ink-2` | `#2A2638` | Secondary dark surfaces, cards on dark |
| `ivory` | `#FAF7F2` | Main page background |
| `sand` | `#EFE7DA` | Alternate section background |
| `gold` (Champagne) | `#C9A86A` | Thin lines, icons, "Premium"/"Seasonal" labels, star ratings, small accents only |
| `muted` | `#6B6778` | Body copy secondary text |
| `whatsapp` | `#25D366` | Only for the floating WhatsApp button icon ring |

Rules: crimson for action, gold for luxury detail (never large fills), midnight for depth. Body text on ivory must meet WCAG AA. Hero images get a midnight→transparent gradient overlay so white text reads clearly.

## 3. Typography

- Headings: **Playfair Display** (elegant serif — matches the serif "We Are Tripping Soon" style in their posts), weights 600/700
- Body/UI: **Inter** (or Plus Jakarta Sans), 400/500/600
- Load via Google Fonts `<link>` with `preconnect` and `display=swap`. Large confident hero type (clamp ~48–80px), generous letter-spacing on small uppercase eyebrow labels in gold.

## 4. Visual motifs

- **Dashed flight-path lines** with a small plane icon and map-pin markers (their Instagram uses this) — use as SVG decorations between sections and in the hero, animated stroke-dashoffset on scroll.
- Rounded corners 16–24px, soft large shadows, subtle grain/noise on dark sections.
- Full-bleed, high-quality destination photography (use Unsplash placeholders: Dubai skyline, Paris, London, Swiss Alps, Istanbul, Tokyo, Santorini, desert safari). Put image URLs in the data files.
- Smooth reveals (fade-up, stagger) with CSS transitions triggered by IntersectionObserver in vanilla JS; respect `prefers-reduced-motion`.

## 5. Layout reference

The client likes **arabian-adventures.com** — take inspiration from its *structure* (big hero slider, clear category navigation, rows of bookable cards with "From AED X" pricing and badges, strong CTAs), but do not copy its design, copy or assets. Ours should feel more boutique and premium.

## 6. Pages & sections

### Global
- **Sticky header** (`includes/header.php`): logo left (use `assets/img/logo.svg` placeholder — white mark on crimson circle; I will replace it), nav: Home, Outbound Holidays, Inbound UAE, Visa Services, Seasonal Packages, About, Contact. Right: crimson "WhatsApp Us" pill button. Transparent over hero, turns ivory with blur + shadow on scroll. Mobile: full-screen slide-in menu.
- **Floating WhatsApp button** bottom-right on every page, with a gentle pulse and a tooltip "Chat with a travel expert".
- **Footer** (`includes/footer.php`, midnight background): logo, short about line, quick links, visa destinations list, contact (Dubai, phone, email), Instagram link, gold hairline divider, © year Tripcompanies.

### Home (`index.php`)
1. **Hero** — full-screen image slider (3 slides: "Explore Europe This Season", "Discover the Magic of Dubai", "Visas Made Simple"), Playfair headline, gold eyebrow "#BeyondTheRoutine", two CTAs: "WhatsApp Us" (crimson) + "View Packages" (outline white). Animated dashed flight path across the hero.
2. **Quick service selector** — 3 elegant cards overlapping the hero bottom: Outbound Packages, Inbound UAE Tours, Visa Services (icon, one line, arrow).
3. **Seasonal Packages** — season tabs (Winter / Spring / Summer / Autumn) filtering package cards. Card: image, destination, duration (e.g. "6N / 7D"), 3 inclusions with icons, "From AED X" price, gold "Seasonal" badge, "Enquire on WhatsApp" button (prefilled with package name).
4. **Visa Services strip** — flag/country grid for Schengen, UK, USA, Canada, Turkey, Australia, Japan, China, Saudi Arabia + "Many more". Each tile opens WhatsApp with "I need a visa for {country}".
5. **Inbound UAE experiences** (for European visitors) — horizontal scroll cards: Desert Safari, Dubai City Tour, Abu Dhabi Grand Mosque tour, Dhow Cruise, Burj Khalifa, Theme Parks.
6. **Why Tripcompanies** — 4 points with gold icons: Dubai-based experts, Tailored itineraries, End-to-end visa support, 24/7 WhatsApp assistance.
7. **How it works** — 3 steps connected by a dashed flight path: Message us on WhatsApp → Get a custom quote → Pack your bags.
8. **Testimonials** — carousel (placeholder reviews, clearly marked as sample content in code comments).
9. **Instagram teaser** — "Follow our journeys @tripcompanies" with image grid + follow button.
10. **Big CTA band** — crimson background, white Playfair headline "Your next trip starts with a message", WhatsApp button (white).

### Outbound Holidays (`outbound.php`)
Hero, filter chips by region (Europe, Asia, Middle East, Africa) and season, package grid, CTA.

### Inbound UAE (`inbound.php`)
Aimed at European travellers: hero "Experience the UAE", experience cards, multi-day UAE package cards, CTA.

### Visa Services (`visa.php`)
Hero, country cards with: processing time placeholder, required documents accordion, "Apply via WhatsApp" button. FAQ accordion.

### Seasonal Packages (`packages.php`) + Package detail (`package.php?slug=...`)
Season tabs and filters work client-side with vanilla JS (`data-season` / `data-region` attributes on cards). The detail page reads the slug with `$_GET['slug']`, looks it up in `data/packages.php`, sanitises it, and returns a styled 404 if not found. Add an `.htaccess` rewrite so `/packages/swiss-alps-paris` maps to `package.php?slug=swiss-alps-paris`, and clean URLs without `.php` for all pages.
Listing with season tabs. Detail page: image gallery, overview, day-by-day itinerary accordion, inclusions/exclusions, price box (sticky on desktop) with "Enquire on WhatsApp".

### About (`about.php`)
Story, mission, values, Dubai office highlight.

### Contact (`contact.php`)
WhatsApp as the primary big card, plus phone, email, Dubai location with embedded Google Map (Dubai), and an enquiry form (name, phone, destination, travel month, travellers, message) with two submit options:
- **"Send on WhatsApp"** (primary) — vanilla JS builds the message from the fields and opens WhatsApp.
- **"Send by Email"** — posts to `send-enquiry.php`, which validates and sanitises input server-side, includes a honeypot field + simple rate limit (session timestamp) against spam, sends with PHP `mail()` to the site email (make it easy to swap to PHPMailer SMTP later), and shows a styled success/error message. Also validate in JS before submit.

## 7. File structure & data

```
/
├── index.php, outbound.php, inbound.php, visa.php, packages.php, package.php, about.php, contact.php, 404.php
├── send-enquiry.php
├── .htaccess            (clean URLs, 404 page, gzip, browser caching)
├── sitemap.xml, robots.txt
├── includes/
│   ├── config.php       (site constants)
│   ├── functions.php    (wa_link(), e() for htmlspecialchars, helpers)
│   ├── head.php         (meta tags, per-page title/description/OG via variables set before include)
│   ├── header.php, footer.php, whatsapp-float.php
│   └── components/      (package-card.php, visa-tile.php, experience-card.php, section-heading.php, flight-path.php)
├── data/
│   ├── site.php         (brand, contacts, socials, nav)
│   ├── packages.php     (returns array of packages)
│   ├── visas.php
│   └── experiences.php
└── assets/
    ├── css/style.css
    ├── js/main.js
    ├── img/  (logo.svg, og-image.jpg, placeholders)
    └── icons/
```

- `data/packages.php` — each item: `slug, title, destination, region, season, nights, days, price_from, currency ('AED'), image, gallery[], highlights[], inclusions[], exclusions[], itinerary[ [day, title, desc] ]` — seed 8 realistic sample packages (e.g. Swiss Alps & Paris, Istanbul & Cappadocia, Georgia Getaway, Bali Escape, London Explorer, Japan Cherry Blossom, Baku Winter, Kenya Safari)
- `data/visas.php` — country, flag emoji/code, processing time, documents[]
- `data/experiences.php` — inbound UAE experiences
- Components are PHP partials that take variables (e.g. `$package`) and are included inside `foreach` loops.
- Always escape output with `e()` (`htmlspecialchars`).

## 8. Quality requirements

- Mobile-first, perfect at 360px, tablet, desktop; no horizontal scroll.
- Lighthouse 90+ (WebP images with `width`/`height`, `loading="lazy"`, `defer` on the script, font-display swap, minimal CSS/JS).
- SEO: unique title/description per page, Open Graph tags, static `sitemap.xml` and `robots.txt`, JSON-LD `TravelAgency` schema with Dubai address + phone, canonical URLs.
- Accessibility: semantic HTML, keyboard-usable menu/tabs/accordions/slider, focus states (gold ring), alt text, aria labels on icon buttons, AA contrast.
- Reusable CSS classes: `.btn`, `.btn--primary`, `.btn--outline`, `.section-heading` (gold eyebrow + Playfair title), `.card`, `.badge`, `.tabs`, `.accordion`, `.container`. Use BEM naming.
- Works without JavaScript for core content (JS only enhances).
- PHP 8 compatible, no Composer dependencies, no errors/notices with `error_reporting(E_ALL)`.
- No lorem ipsum — write warm, premium travel copy in English.
- Include a short `README.md` explaining how to edit packages in `data/packages.php` and how to upload to cPanel.

Start with `includes/` (config, functions, head, header, footer, floating WhatsApp), `style.css` tokens and base styles, and `main.js`. Then build `index.php`, then the remaining pages.
