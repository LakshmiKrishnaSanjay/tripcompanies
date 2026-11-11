# Cursor Prompt — Tripcompanies "Neon Night" Redesign

Copy everything below the line into Cursor. (Replaces the earlier ivory/serif redesign prompt.)

---

Redesign the visual layer of the Tripcompanies site into a **dark, cinematic, light-and-glow** premium travel brand. Keep the existing PHP 8 + HTML + CSS + vanilla JS structure, `/data` files, pages and WhatsApp links. No frameworks, no npm, no build step. Allowed extra libraries (via CDN `<script>` tags only, no bundler): **GSAP 3 + ScrollTrigger** and **Lenis** smooth scroll.

## Brand direction

The client's own businesses (an IT/AI agency, a creative agency, an AI academy) all use the same taste:
- near-black backgrounds
- soft **pools of coloured light** (big blurred radial gradients) behind the content
- **two-colour neon gradients** on headlines, borders and buttons
- frosted-glass cards with thin glowing borders
- smooth scrolling with big, confident animations

Tripcompanies should feel like **Dubai at night**: black sky, neon city light, the brand crimson glowing like a runway light. It should look majestic, not like an IT company. Travel photography stays the hero, and the light effects frame it.

## 1. Colour system (CSS custom properties in `:root`)

| Token | Hex | Role |
|---|---|---|
| `--bg` | `#07060B` | Page background (near-black with a violet undertone) |
| `--bg-2` | `#0E0B16` | Alternate section background |
| `--surface` | `rgba(255,255,255,0.04)` | Glass card fill |
| `--line` | `rgba(255,255,255,0.08)` | Hairline borders |
| `--brand` | `#EC0A44` | Logo crimson (exact brand colour) |
| `--neon` | `#FF2E63` | **Neon crimson**: brighter version used for glows, hovers and gradient start |
| `--violet` | `#7B4DFF` | **Secondary: electric violet**, gradient partner, light pools |
| `--amber` | `#FFB547` | Tertiary "desert sunset" highlight, tiny use only (prices, stars, active dots) |
| `--text` | `#F4F1F8` | Primary text |
| `--muted` | `#9C97AE` | Secondary text |

Signature gradient: `--grad: linear-gradient(120deg, #FF2E63 0%, #C03BFF 50%, #7B4DFF 100%);`

Use the gradient for:
- one key word in each big headline (`background-clip: text`)
- the primary buttons
- the active-tab underline
- animated card borders

Glows:
- `--glow-neon: 0 0 24px rgba(255,46,99,.45), 0 0 60px rgba(255,46,99,.20);`
- `--glow-violet: 0 0 30px rgba(123,77,255,.35);`

Rules:
- Crimson and violet are the light sources. Use them for light, borders, gradients and CTAs, never as flat background blocks.
- Amber appears no more than 2–3 times per screen.
- Body text must meet WCAG AA on `--bg`.

## 2. Lighting and atmosphere (the most important part)

- **Light pools:** each section gets 1–2 absolutely positioned blurred orbs, e.g. `width: 600px; aspect-ratio: 1; background: radial-gradient(circle, rgba(255,46,99,.28), transparent 65%); filter: blur(40px);`. Alternate crimson and violet per section and position them differently each time (top-left, bottom-right, behind a card). Orbs drift slowly (GSAP, 20s yoyo) and move slightly with the mouse on desktop (parallax 10–20px).
- **Dot-grid / star texture:** a very subtle background on dark sections, `radial-gradient(rgba(255,255,255,.06) 1px, transparent 1px) 0 0/28px 28px`, faded out with a mask toward the edges. It reads as a night sky or a map grid.
- **Film grain:** an SVG noise overlay on the whole page at 3–4% opacity.
- **Cursor spotlight (desktop):** cards have a radial highlight that follows the mouse (`--x`, `--y` CSS vars set by JS) plus a gradient border that lights up near the cursor.
- **Light streaks:** in the hero, 2–3 thin animated gradient lines (crimson to violet) sweep diagonally, like light trails from planes taking off at night. They replace the old dashed flight-path line.

## 3. Typography

- Display/headings: **Clash Display** or **Syne** (600/700). Fallback: **Red Hat Display** 700 from Google Fonts. Bold modern sans, tight tracking (-0.02em). Do not use the serif fonts.
- Body/UI: **Inter** 400/500, 16–17px.
- Small labels: uppercase, 12px, letter-spacing 0.2em, with a small glowing dot before them (`● OUR JOURNEYS`).
- Sizes: H1 `clamp(3rem, 8vw, 7.5rem)`, line-height 0.95. H2 `clamp(2.25rem, 5vw, 4.5rem)`.
- Add a soft `text-shadow: 0 0 40px rgba(255,46,99,.25)` on the gradient word only.

## 4. Components

- **Primary button:** gradient fill, white text, 999px radius, height 52px, `box-shadow: inset 0 1px 0 rgba(255,255,255,.35), var(--glow-neon)`. On hover the glow grows and the gradient shifts position. The WhatsApp icon sits on the left.
- **Secondary button:** transparent background with a 1px gradient border (mask technique) and white text. On hover a faint fill appears.
- **Glass card:** `background: var(--surface); border: 1px solid var(--line); backdrop-filter: blur(14px); border-radius: 20px;` plus an inner top highlight `inset 0 1px 0 rgba(255,255,255,.06)`. On hover the border turns into an animated gradient, the card lifts 6px and the image zooms 1.06.
- **Badges:** small glass pills with a coloured dot, e.g. `● Winter`, `● Bestseller`.
- **Header:** transparent at first. On scroll it becomes a floating glass bar (blur, `--line` border, 16px from the top, rounded 999px, max-width 1200px). The logo sits on the left (white mark plus crimson). The CTA is a small gradient "WhatsApp Us" button.
- **Floating WhatsApp button:** 56px, dark glass with a crimson glow ring that breathes slowly (not a jumpy pulse). Add bottom padding to the footer so it never covers text.

## 5. Sections (home), each with its own layout

1. **Hero:** full-screen. Use a cinematic night photo or muted looping video (Dubai skyline at night, or the view from an aircraft window at dusk) under a dark gradient. A crimson light pool sits bottom-left and a violet one top-right, with the light streaks.
   - Headline: "Travel **beyond** the routine" (gradient on "beyond"), with the letters revealed by a GSAP stagger.
   - Sub-line, plus two CTAs.
   - A small glass "destination ticker" in the bottom-right loops through destinations: Paris → Istanbul → Tokyo → Baku…
   - A scroll indicator.
   - No slider arrows, dots or Pause button.
2. **Marquee band:** a huge outlined text marquee scrolling slowly: `SCHENGEN · UK · USA · CANADA · TURKEY · JAPAN · AUSTRALIA · CHINA · SAUDI ARABIA ·`. The outline uses the gradient stroke, and scroll speed controls its velocity.
3. **Trust strip:** 4 glowing stats with count-up on scroll: `30+ visa destinations`, `Dubai-based desk`, `24/7 WhatsApp`, `Tailor-made trips`. Leave commented placeholders for licence/IATA and partner logos (white, 40% opacity).
4. **Seasonal packages:**
   - Season switcher: glass pill tabs whose gradient underline slides between them.
   - Layout: one large featured card plus a horizontal scroller of tall image cards. Text sits over the image on a dark gradient: destination, title, "7D · From **AED 12,900**" (price in amber), and a small "Enquire →" link.
   - Remove the checkmark lists and the full-width red buttons.
5. **Visa services:** a pinned section (GSAP ScrollTrigger pin). On the left a big headline: "Visas, handled **calmly**". On the right a list of countries that light up one by one as you scroll. Each row shows the flag, country name, a thin line and a glowing arrow on hover, and opens WhatsApp.
6. **Inbound UAE (for European visitors):** a horizontal scroll driven by vertical scrolling (pin plus x-translate). It shows big image cards: Desert Safari, Dubai Night City, Grand Mosque, Dhow Cruise, Burj Khalifa, Theme Parks. Each card has a crimson/violet light bleed at its edge.
7. **Why Tripcompanies:** a bento grid of 4 glass tiles in different sizes, each with a large line icon glowing in gradient and a short text.
8. **How it works:** three steps connected by an animated glowing line that draws itself on scroll (SVG stroke-dashoffset). Numbers 01/02/03 in big gradient outline type. The content must be visible immediately, so do not delay it behind animation.
9. **Testimonials:** a single large quote in a glass card with a soft violet glow behind it, and auto-rotating avatars or initials.
10. **Instagram:** a masonry grid. On hover each image gets a crimson glow border and the IG icon.
11. **Final CTA:** a black section with a huge crimson+violet light pool in the centre. The headline "Your next trip starts with **one message**" is large, with a gradient WhatsApp button.
12. **Footer:** dark. A giant faded "TRIPCOMPANIES" wordmark runs along the bottom with a gradient fill at 8% opacity. Then the link columns, hairlines, contact details and the email from `data/site.php`.

Apply the same system to all inner pages. Each page hero is a shorter version with its own light pools and a photo. Package detail pages get a glass sticky price box.

## 6. Photography

- Choose moody, high-contrast images: dusk, night, golden hour, city lights, desert sunsets. Avoid flat daylight stock.
- **Every image must match its destination.** Fix these: Baku currently shows a honey jar, Desert Safari shows a green mountain road, and the Swiss Alps photo isn't Switzerland.
- Apply a consistent grade: `filter: saturate(1.1) contrast(1.05)` plus a dark gradient at the bottom of every card so the text reads.
- Add `srcset` with 640/1024/1600/2400 widths, `loading="lazy"` (except the hero), and preload the hero image.

## 7. Motion (GSAP + ScrollTrigger + Lenis)

- Lenis smooth scroll across the site (lerp 0.1).
- Headline reveal: lines slide up from a mask, staggered 0.08s, ease `power4.out`.
- Sections: fade and rise 40px on enter, scrub off.
- Images: parallax inside their frame (-8% to 8%).
- Magnetic effect on the primary buttons (desktop).
- Page-load intro: a 1s black screen where the logo glows in, then fades to the hero. Show it only on the first visit per session (use `sessionStorage`).
- Respect `prefers-reduced-motion`: disable Lenis, the parallax and the marquee, and show all content statically.
- Performance: animate only `transform`/`opacity`, use `will-change` sparingly, keep orbs to two per section, and disable mouse effects on touch devices.

## 8. Mobile

- Keep the light pools but make them smaller, and use fewer blur layers for performance.
- The hero headline is about 48px, text sits in the lower half, and there is no big empty gap at the top.
- Horizontal sections become swipe carousels with scroll-snap. The pinned sections unpin on mobile and become normal stacked lists.
- Show the full logo (mark plus "trip companies") in the header.
- Tap targets must be at least 44px.

Order of work:
1. Update the `style.css` tokens, base styles and glass/glow utilities.
2. Header, footer and floating WhatsApp.
3. Rebuild the home sections.
4. Apply the system to the inner pages.
5. Add the motion layer last, so the site still looks complete without JS.
