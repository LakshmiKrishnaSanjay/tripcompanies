# Cursor Prompt — Tripcompanies Fix List (review of current build)

Copy everything below the line into Cursor. Keep PHP + HTML + CSS + vanilla JS.

---

Fix these issues on the current Tripcompanies site, in this order.

## A. Bugs / must-fix
1. **Mobile hero has no side padding.** The headline and paragraph touch the left edge of the screen, and the headline runs into the Eiffel Tower. Add `padding-inline: 20px` to the hero content on screens of 768px and narrower, cap the text width at 90%, and add a stronger left/bottom gradient behind the text.
2. **Unreadable small text.** The gold eyebrows and `package-card__dest` labels are 11px gold on ivory with about a 2.1:1 contrast ratio. Make every label at least 12px. For gold on light backgrounds use a darker gold, `#8A6A2E` (4.5:1 or better). Body paragraphs should be at least 16px and `#4A4656`.
3. **Final CTA band.** The white text sits on the bright desert sky and is hard to read. Add a dark gradient overlay from the bottom-left, or use a dusk desert photo. Make the button the crimson primary button, not white.
4. **Footer email typo.** `pooja.tripcompanioes@gmail.com`: confirm the spelling with the client and update `data/site.php`.
5. **Trust strip on mobile.** The first item ("Dubai-based travel desk") has no dash and is misaligned. Show it as a 2×2 grid on mobile, or as an auto-scrolling marquee.

## B. Layout
6. **Seasonal packages.** With only 2 packages per season, the big-plus-small layout looks unbalanced and leaves a large empty space. Either:
   - show 3 packages per season (1 large + 2 stacked), or
   - use 3 equal tall cards.

   All cards need the same style (text over the image). Right now Swiss shows its text over the image and Baku shows it below.
7. **Same photo used too often.** The Dubai skyline photo appears 4 times (hero, inbound card, Why-us, Instagram), and others appear 2–3 times. Every image must be unique on a page.
8. **Testimonials.** Add a photo or an initials avatar, the trip image as a background on one side, and dots showing how many reviews there are. The section currently feels empty.
9. **"Three quiet steps".** The large numbers are too faint. Use a darker gold outline, and show a small icon with each step.
10. **Page length.** The page is about 10,000px tall on desktop and about 10,700px on mobile. Reduce section padding by about 25% and remove the duplicate "Instagram" photos.

## C. Premium feel (client likes dark, glowing, animated sites)
11. Turn the Visa section, the Final CTA and the footer into the "night" sections. Add soft crimson (`#FF2E63`) and violet (`#7B4DFF`) blurred light pools behind them, plus a subtle dot-grid texture. This brings in the glow style the client likes without redoing the whole site.
12. Add GSAP + ScrollTrigger (CDN):
    - The hero headline reveals line by line.
    - Images move with a slight parallax.
    - The UAE experiences scroll sideways as you scroll down on desktop.
    - The visa list lights up row by row as you scroll.
13. Buttons: on hover, the primary crimson button gets a glow `0 0 24px rgba(255,46,99,.45)`. Text links get an underline that slides in.
14. Add a big outlined marquee of the visa countries between the hero and the packages section.
15. Header: replace the outlined "WHATSAPP" box with a small crimson button that has a WhatsApp icon, so the main action stands out.

## D. Content and trust
16. Add real trust signals: licence/DTCM number, years in business, number of happy travellers, and partner logos (airlines/hotels). Leave clearly commented placeholders where the client has to provide the details.
17. Add a short "Meet the team" block (photo + name + role). Personal service is the selling point.
18. Add an FAQ block on the home page (visa timelines, payment, cancellations) for SEO and to answer common questions.

Test at 375px, 768px, 1024px and 1440px after the changes, with no horizontal scroll. Keep the WhatsApp links working.
