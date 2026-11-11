# Cursor Prompt — Tripcompanies Light & Dark Mode

Copy everything below the line into Cursor. Use it together with the neon redesign prompt (dark mode = "Neon Night", light mode = "Desert Day"). Keep PHP + HTML + CSS + vanilla JS.

---

Add a **light mode and a dark mode** to the whole Tripcompanies site. **Dark is the default and hero experience** (the client's taste: black, neon glow, light pools). Light mode is an elegant warm-ivory version for daytime readers. Both must feel premium and on-brand. Light mode is not a washed-out copy of dark mode.

## 1. How it works

- Theme is set with `data-theme="dark" | "light"` on `<html>`.
- First visit: dark by default. If you'd rather follow the device, use `prefers-color-scheme`, but still fall back to dark.
- The user's choice is saved in `localStorage` (`tc-theme`) inside try/catch. The site must still work if storage is blocked.
- **No flash of the wrong theme:** add a tiny inline script in `includes/head.php` **before** the CSS loads:
  ```html
  <script>
    (function(){try{var t=localStorage.getItem('tc-theme');document.documentElement.setAttribute('data-theme',t||'dark');}catch(e){document.documentElement.setAttribute('data-theme','dark');}})();
  </script>
  ```
- Add `<meta name="color-scheme" content="dark light">`, and a `theme-color` meta tag that updates on switch (`#07060B` dark / `#FAF7F2` light).
- Theme changes animate smoothly: `transition: background-color .4s, color .4s, border-color .4s, box-shadow .4s`. Skip the transition on first load and when `prefers-reduced-motion` is set.

## 2. Colour tokens

All colours come from CSS variables. **No hard-coded colours anywhere in components.**

```css
:root,
[data-theme="dark"] {
  --bg:        #07060B;
  --bg-2:      #0E0B16;
  --surface:   rgba(255,255,255,0.04);
  --surface-2: rgba(255,255,255,0.07);
  --line:      rgba(255,255,255,0.08);
  --text:      #F4F1F8;
  --muted:     #9C97AE;
  --brand:     #EC0A44;
  --neon:      #FF2E63;
  --violet:    #7B4DFF;
  --amber:     #FFB547;
  --grad:      linear-gradient(120deg,#FF2E63 0%,#C03BFF 50%,#7B4DFF 100%);
  --glow:      0 0 24px rgba(255,46,99,.45), 0 0 60px rgba(255,46,99,.20);
  --orb-1:     rgba(255,46,99,.28);
  --orb-2:     rgba(123,77,255,.30);
  --grid-dot:  rgba(255,255,255,.06);
  --img-overlay: linear-gradient(180deg, rgba(7,6,11,0) 30%, rgba(7,6,11,.85) 100%);
  --shadow:    0 30px 60px -30px rgba(0,0,0,.6);
}

[data-theme="light"] {
  --bg:        #FAF7F2;
  --bg-2:      #F1EADF;
  --surface:   rgba(255,255,255,0.75);
  --surface-2: #FFFFFF;
  --line:      rgba(20,18,31,0.10);
  --text:      #14121F;
  --muted:     #5E5A6E;
  --brand:     #EC0A44;
  --neon:      #D8083E;   /* deeper crimson so it passes contrast on ivory */
  --violet:    #5B32D6;
  --amber:     #B7791F;
  --grad:      linear-gradient(120deg,#EC0A44 0%,#A62BD9 50%,#5B32D6 100%);
  --glow:      0 10px 30px -10px rgba(236,10,68,.35);
  --orb-1:     rgba(236,10,68,.10);
  --orb-2:     rgba(123,77,255,.10);
  --grid-dot:  rgba(20,18,31,.05);
  --img-overlay: linear-gradient(180deg, rgba(20,18,31,0) 35%, rgba(20,18,31,.70) 100%);
  --shadow:    0 30px 60px -30px rgba(20,18,31,.18);
}
```

## 3. What changes per mode

| Element | Dark — "Neon Night" | Light — "Desert Day" |
|---|---|---|
| Background | Near-black with crimson and violet light pools | Warm ivory with very faint, soft colour washes |
| Light pools / orbs | Strong, blurred, drifting | Much softer (10% opacity), more like morning light |
| Cards | Frosted glass, glowing border on hover | White cards, hairline border, soft shadow, crimson border on hover |
| Headline gradient word | Neon gradient + soft text glow | Deeper gradient, **no** text glow |
| Primary button | Gradient + neon glow | Solid crimson + soft drop shadow |
| Dot-grid / grain | Visible stars effect | Barely visible paper texture |
| Logo | White mark version (`logo-white.png`) | Crimson/ink version (`logo-ink.png`) |
| Photos | Dusk/night shots, dark gradient at the bottom | Same photos; overlay only where text sits on top |
| Footer | Black with faint gradient wordmark | Stays **dark** in both modes (anchors the page) |
| Hero | Always dark (photo + overlay) in both modes | Same. The hero stays cinematic in light mode too |

Rules:
- The hero, the image cards and the footer stay dark/photographic in both modes. Only the content sections between them switch. That way light mode still feels premium.
- Every text/background pair must meet **WCAG AA (4.5:1)** in both modes. Check the gold/amber, muted text and gradient text especially.
- The logo swaps automatically with `<picture>` or two `<img>` tags, shown and hidden by `[data-theme]` CSS. No JS flicker.
- Inline SVG icons use `currentColor`, so they follow the theme.
- The WhatsApp brand green stays the same in both modes.

## 4. The toggle

- Place it in the header, next to the WhatsApp button. Make it a 40px round icon button: a **sun** icon in dark mode, a **moon** icon in light mode. The icon rotates and fades on switch (300ms).
- Accessibility: `<button aria-label="Switch to light mode" aria-pressed="...">`, with the label updating on each switch. It must be keyboard-focusable with a visible focus ring.
- Add it to the mobile menu as well, as a labelled row: "Theme: Dark / Light".
- Optional: use the View Transitions API (`document.startViewTransition`) for a circular reveal from the toggle button, with a fallback to the plain fade when it's not supported.

## 5. JS (`assets/js/main.js`)

```js
const root = document.documentElement;
const btns = document.querySelectorAll('[data-theme-toggle]');
function setTheme(t){
  root.setAttribute('data-theme', t);
  try { localStorage.setItem('tc-theme', t); } catch(e) {}
  document.querySelector('meta[name="theme-color"]')?.setAttribute('content', t === 'dark' ? '#07060B' : '#FAF7F2');
  btns.forEach(b => {
    b.setAttribute('aria-pressed', t === 'light');
    b.setAttribute('aria-label', t === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');
  });
}
btns.forEach(b => b.addEventListener('click', () => {
  const next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
  if (document.startViewTransition && !matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.startViewTransition(() => setTheme(next));
  } else { setTheme(next); }
}));
```

GSAP light-pool animations should read their colours from the CSS variables, so they update when the theme changes.

## 6. Checklist

- [ ] Every page (home, outbound, inbound, visa, packages, package detail, about, contact, 404) looks right in both modes.
- [ ] No hard-coded hex colours left in components (search `style.css` for `#` outside `:root`/`[data-theme]`).
- [ ] No flash of the wrong theme on reload or when moving between pages.
- [ ] Contact form inputs, focus states, accordions, tabs and the scroller arrows are readable in both modes.
- [ ] Tested at 375 / 768 / 1024 / 1440px in both modes.
