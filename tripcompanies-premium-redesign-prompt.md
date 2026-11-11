# Cursor Prompt — Make Tripcompanies Feel Premium

Copy everything below the line into Cursor (same project, keep PHP + HTML + CSS + vanilla JS).

---

The site works, but it looks like a generic template instead of a premium travel house. Every section uses the same pattern (gold eyebrow → serif H2 → paragraph → row of equal white rounded cards with a shadow → big red pill button). Redesign the visual layer to feel like a luxury boutique travel brand (think editorial travel magazine / high-end hotel site). Keep the PHP structure, data files, WhatsApp links and all content. Do not add frameworks.

## 1. Restraint with colour
- Crimson `#EC0A44` is for the logo, ONE primary CTA per screen, and tiny accents only. Remove crimson from card buttons, icon circles and large bands.
- Remove the pink `brand-soft` icon circles entirely. Icons become thin 1.25px line icons in gold or ink, no background.
- Main palette becomes: ivory `#FAF7F2`, warm stone `#E9E1D4`, midnight `#14121F`, champagne gold `#C9A86A` for hairlines/details. Crimson appears sparingly so it feels special.
- Replace the full crimson "CTA band" with a full-bleed photo (Dubai desert at dusk or Santorini) with a dark gradient and a white serif headline; the WhatsApp button sits on top as a white button.

## 2. Typography — bigger, lighter, more editorial
- Headings: switch to **Cormorant Garamond** (500/600, plus italic) for display, keep Playfair only if needed. H1 `clamp(3rem, 7vw, 6.5rem)`, H2 `clamp(2.25rem, 4.5vw, 4rem)`, line-height 1.02–1.1, weight 500 (not bold).
- Use italic serif for one emphasised word in headings, e.g. "Journeys that *follow* the weather".
- Body: Inter 16–17px, weight 400, colour `#4A4656`, max line length 60ch.
- Eyebrows: 11px, uppercase, letter-spacing 0.28em, gold — keep, but use on fewer sections.
- Buttons: 14–15px, weight 500, uppercase with 0.12em tracking, height 52px, **square or 2px radius** (no fat pills). Secondary CTAs become text links with a thin underline + arrow that slides on hover.

## 3. Photography is the luxury
- Replace every image with correct, high-end photos (fix: Baku card shows a honey jar, Desert Safari shows a green mountain road, Swiss Alps photo isn't Switzerland). Use Unsplash photos that match the destination exactly, warm and editorial, no stock-looking people.
- Hero: one full-screen slow **Ken Burns** image (or muted looping video of Dubai/Europe), lighter overlay — gradient only on the bottom-left 50% so the photo stays bright and rich, not murky. Remove the visible arrows, dots and "Pause" pill; replace with a thin progress line + slide number "01 / 03" in the corner, small and elegant.
- Remove the dashed flight-path line from the hero (it looks like clip-art). Keep it at most once, very subtle (opacity 0.25, gold, 1px) in "How it works".
- Package images: tall aspect ratio (4:5), image takes 70% of the card, image scales 1.05 slowly on hover.
- Add `srcset` sizes 640/1024/1600/2400 so mobile is fast.

## 4. Break the template rhythm — vary each section's layout
- **Service selector** (overlapping hero): replace the three white cards with one slim glass bar (backdrop-blur, ivory 70%) split into 3 columns with hairline dividers: Outbound Holidays · Inbound UAE · Visa Services.
- **Seasonal packages**: editorial layout — one large featured package (left, 60% width, tall image with text overlaid at the bottom), two smaller stacked on the right. Season tabs become a minimal text switcher with an animated gold underline. Card content: destination (eyebrow), title in serif, "7 Days · From AED 12,900" on one line, and a text link "Enquire →". **Remove** checkmark lists and full-width red buttons from cards.
- **Visa services**: two-column layout — left side large serif headline + short text + one CTA; right side a clean list of countries with flag, name and a thin divider line between rows (like a hotel menu), arrow appears on hover. No boxy tiles.
- **Inbound UAE**: full-bleed horizontal scroller of tall image cards with text over the image (white serif title, small duration), no white card body, no price buttons.
- **Why Tripcompanies**: replace the four cards with a split section — large photo on one side, on the other 4 numbered points (01–04) separated by hairlines, no boxes.
- **How it works**: three columns with huge outlined numerals (gold, 120px, serif), short text, no animation delay — content must be visible immediately (currently the section looks empty until the stagger finishes).
- **Testimonials**: one large quote at a time in italic serif (32–40px), name + trip below in small caps, remove star icons and card boxes.
- **Instagram**: masonry/offset grid with slight gaps, hover shows the Instagram icon.

## 5. Trust signals (premium buyers look for these)
Add a slim strip below the hero: "Dubai-based travel desk · Visa support for 30+ countries · Tailor-made itineraries · Replies within 1 hour on WhatsApp" with gold separators. Leave placeholders (clearly commented in code) for: DTCM/licence number, IATA, years in business, partner airline/hotel logos (grey, monochrome).

## 6. Space, details and motion
- Section padding: `clamp(96px, 12vw, 180px)` top/bottom. More whitespace everywhere; container max-width 1280px, wide gutters.
- Replace drop shadows with either no shadow or a very soft one (`0 30px 60px -30px rgba(20,18,31,.18)`). Corner radius 4–8px max (not 16–24px) — sharper reads more premium.
- Hairline dividers (1px, `rgba(20,18,31,.1)` / gold on dark) between sections and list items.
- Subtle film grain overlay on dark sections and the hero (CSS SVG noise, opacity 0.04).
- Motion: slow, quiet — fade + 16px rise, 700ms, `cubic-bezier(.2,.7,.2,1)`, stagger 80ms max. Nothing should stay invisible for more than ~300ms after entering the viewport. Respect `prefers-reduced-motion`.
- Header: transparent on hero with white logo; on scroll becomes ivory with hairline bottom border (no heavy shadow). Nav links 13px uppercase tracked; the header CTA is a small outlined "WhatsApp" button, not a big red pill.
- Floating WhatsApp button: smaller (52px), midnight background with gold ring, no pulse; add bottom padding to the footer so it never covers text.

## 7. Footer
Larger brand moment: big serif line "Travel, beyond the routine." across the top of the footer, then the link columns, hairline divider, small legal row. Fix the email to whatever is in `data/site.php`.

## 8. Mobile
- Hero text starts lower third, no big empty space at the top; headline ~44px.
- Show the full logo (mark + "trip companies") in the header, not just the icon.
- Featured package becomes full-width; other cards in a swipe carousel with snap.
- Keep tap targets ≥ 44px.

Apply this across all pages (home, outbound, inbound, visa, packages, package detail, about, contact) so the whole site shares the new design language. Update `style.css` tokens first, then components, then page layouts.
