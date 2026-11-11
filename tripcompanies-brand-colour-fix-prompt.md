# Cursor Prompt — Switch to Tripcompanies Brand Colours (Light + Dark)

Copy everything below the line into Cursor. It **overrides the colours** from the earlier neon and light/dark prompts. Keep all layouts, animations, the theme toggle and the PHP structure.

---

**Colour correction:** remove the violet/purple (`#7B4DFF`, `#C03BFF`, `#5B32D6`) and amber colours everywhere. They are not Tripcompanies brand colours. The whole site must be built only from the **logo crimson `#EC0A44`**, its own lighter and deeper shades, and **champagne gold** as the secondary colour. Keep the glow, light-pool, gradient and glass *effects*, but make every one of them crimson and gold.

Crimson glowing on black, with gold details, is the "majestic Dubai at night" look. In light mode the same crimson and gold sit on warm ivory.

## 1. Brand palette

Crimson family (all derived from the logo `#EC0A44`):

| Token | Hex | Use |
|---|---|---|
| `--crimson` | `#EC0A44` | Exact logo colour: logo, primary buttons, key accents |
| `--crimson-neon` | `#FF2E5F` | Brighter, glowing version: glows, hover states, gradient highlight (dark mode) |
| `--crimson-soft` | `#FF6B8B` | Light tint: gradient end, soft highlights on dark |
| `--crimson-deep` | `#B00733` | Pressed/hover in light mode, gradient start in light mode |
| `--crimson-wine` | `#5C0219` | Deep wine: dark-mode light pools and section washes |

Secondary (luxury accent):

| Token | Hex | Use |
|---|---|---|
| `--gold` | `#D4AF6A` | Champagne gold on dark: thin lines, icons, labels, prices, stars |
| `--gold-deep` | `#8A6A2E` | Gold for text on light backgrounds (passes contrast on ivory) |

Gradients:
- **Signature gradient (dark mode):** `linear-gradient(120deg, #B00733 0%, #EC0A44 45%, #FF6B8B 100%)`
- **Signature gradient (light mode):** `linear-gradient(120deg, #8A0529 0%, #EC0A44 55%, #FF2E5F 100%)`
- **Gold hairline:** `linear-gradient(90deg, transparent, #D4AF6A, transparent)`, used for dividers and card top borders.

Rules:
- Crimson = action and light. Gold = luxury detail (thin lines, small labels, icons, prices). Gold is never used for large fills or buttons.
- One gradient word per headline, in crimson tones only.
- No other hues anywhere: no purple, blue, teal, green or orange. The only exception is the WhatsApp icon green.

## 2. Theme tokens (replace the existing `:root` / `[data-theme]` blocks)

```css
:root,
[data-theme="dark"] {
  --bg:          #08060A;                 /* near-black, faint warm undertone */
  --bg-2:        #120A0E;                 /* slightly wine-tinted black */
  --surface:     rgba(255,255,255,0.04);
  --surface-2:   rgba(255,255,255,0.07);
  --line:        rgba(255,255,255,0.08);
  --line-gold:   rgba(212,175,106,0.35);
  --text:        #F6F2F3;
  --muted:       #A79EA3;
  --accent:      #FF2E5F;                 /* crimson-neon */
  --accent-2:    #D4AF6A;                 /* gold */
  --btn-bg:      linear-gradient(120deg,#B00733 0%,#EC0A44 45%,#FF6B8B 100%);
  --grad-text:   linear-gradient(120deg,#EC0A44 0%,#FF2E5F 50%,#FF6B8B 100%);
  --glow:        0 0 24px rgba(255,46,95,.45), 0 0 64px rgba(236,10,68,.22);
  --text-glow:   0 0 40px rgba(255,46,95,.30);
  --orb-1:       rgba(236,10,68,.30);      /* crimson light pool */
  --orb-2:       rgba(92,2,25,.55);        /* deep wine light pool */
  --orb-3:       rgba(212,175,106,.10);    /* faint gold haze, max 1 per page section */
  --grid-dot:    rgba(255,255,255,.06);
  --img-overlay: linear-gradient(180deg, rgba(8,6,10,0) 30%, rgba(8,6,10,.88) 100%);
  --shadow:      0 30px 60px -30px rgba(0,0,0,.65);
}

[data-theme="light"] {
  --bg:          #FAF7F2;                 /* warm ivory */
  --bg-2:        #F3ECE2;
  --surface:     rgba(255,255,255,0.80);
  --surface-2:   #FFFFFF;
  --line:        rgba(26,10,16,0.10);
  --line-gold:   rgba(138,106,46,0.35);
  --text:        #1A0A10;                 /* near-black with crimson undertone */
  --muted:       #5F5359;
  --accent:      #D8083E;                 /* deeper crimson for contrast on ivory */
  --accent-2:    #8A6A2E;                 /* gold-deep */
  --btn-bg:      linear-gradient(120deg,#8A0529 0%,#EC0A44 55%,#FF2E5F 100%);
  --grad-text:   linear-gradient(120deg,#8A0529 0%,#D8083E 55%,#EC0A44 100%);
  --glow:        0 12px 30px -10px rgba(236,10,68,.35);
  --text-glow:   none;
  --orb-1:       rgba(236,10,68,.08);
  --orb-2:       rgba(255,107,139,.10);
  --orb-3:       rgba(212,175,106,.12);
  --grid-dot:    rgba(26,10,16,.05);
  --img-overlay: linear-gradient(180deg, rgba(26,10,16,0) 35%, rgba(26,10,16,.70) 100%);
  --shadow:      0 30px 60px -30px rgba(26,10,16,.18);
}
```

## 3. Where to apply it

- **Light pools / orbs:** every section uses crimson (`--orb-1`) plus deep wine (`--orb-2`). Optionally add one faint gold haze (`--orb-3`) in the hero or the final CTA. Replace every violet orb.
- **Headline gradient word:** use `--grad-text` with `background-clip: text`, and `--text-glow` in dark mode only.
- **Primary buttons:** `--btn-bg` with white text and the `--glow` shadow. On hover the glow grows and the gradient shifts.
- **Secondary buttons:** a 1px **gold** gradient border with text in `--text`. On hover a faint crimson fill appears.
- **Card borders on hover:** an animated crimson gradient border. Cards also get a thin gold hairline along the top edge.
- **Cursor spotlight on cards:** the radial highlight is `rgba(255,46,95,.12)` in dark mode and `rgba(236,10,68,.06)` in light mode.
- **Light streaks in the hero:** crimson to soft pink, with a tiny gold sparkle at the tip.
- **Marquee of visa countries:** outline stroke in crimson gradient (dark) or deep crimson (light). Gold dots separate the countries.
- **Eyebrow labels:** `--accent-2` (gold), with a small crimson glowing dot in front.
- **Prices ("From AED 12,900"):** gold.
- **Stats / counters:** numbers in the crimson gradient, labels in muted text.
- **Step numbers (01/02/03):** gold outline numerals. The connecting line that draws itself on scroll is crimson.
- **Testimonial stars and quote marks:** gold.
- **Active tab underline, focus rings and progress bars:** crimson.
- **Floating WhatsApp button:** dark glass with a slowly breathing crimson glow ring. The icon is white (or WhatsApp green).
- **Footer:** stays dark in both modes. The giant wordmark is filled with the crimson gradient at 8% opacity, and gold hairlines separate the columns.
- **Hero, image cards and footer:** stay dark/photographic in both modes (unchanged from before).

## 4. Checklist

- [ ] Search `style.css` and `main.js` (including GSAP colour values) for `7B4DFF`, `C03BFF`, `5B32D6`, `FFB547`, `violet`, `purple` and `amber`. Remove or replace every match.
- [ ] Every colour in components comes from the tokens above. No stray hex values outside `:root` / `[data-theme]`.
- [ ] Text contrast meets WCAG AA (4.5:1) in both modes, especially gold text on ivory (use `--gold-deep`) and muted text.
- [ ] Both modes look right on every page at 375 / 768 / 1024 / 1440px.
- [ ] The theme toggle, no-flash script and saved preference still work.
