# Cursor Prompt — Tripcompanies Footer

Copy everything below the line into Cursor.

---

Replace only the site footer. Change nothing else. Use the markup and CSS below exactly; do not redesign or simplify them. The footer stays dark in both light and dark mode.

In the footer partial, replace the contents of `<footer class="site-footer">` with the markup below:
- Output the country links from the existing destinations data, with a `<span aria-hidden="true">✦</span>` between them and none after the last.
- Use the existing `wa_link()` helper, white logo file and phone/email variables.
- Keep the form's existing action, hidden fields and honeypot markup.
- Output the current year dynamically.

```html
<div class="ft-glow" aria-hidden="true"></div>
<div class="container">
  <div class="ft-top">
    <div>
      <p class="ft-label">Your next trip</p>
      <h2 class="ft-title">Where to <em>next?</em></h2>
    </div>
    <form method="post" action="/send-enquiry">
      <!-- existing hidden fields: type=newsletter, return -->
      <p class="ft-label">Trip notes and seasonal deals</p>
      <div class="ft-pill">
        <input name="email" type="email" required autocomplete="email" placeholder="Your email address" aria-label="Your email address">
        <button type="submit" aria-label="Subscribe">→</button>
      </div>
      <label class="ft-consent"><input type="checkbox" name="consent" value="yes" required><span>I agree to hear from Tripcompanies about trips.</span></label>
      <!-- existing honeypot -->
    </form>
  </div>

  <nav class="ft-dest" aria-label="Destinations"><!-- country links with ✦ separators --></nav>

  <div class="ft-grid">
    <div>
      <a class="logo" href="/"><img src="WHITE_LOGO" alt="Tripcompanies"></a>
      <p>A Dubai desk for holidays abroad, planned for people living in the UAE and handled on WhatsApp.</p>
    </div>
    <div><h3>Explore</h3><ul>
      <li><a href="/packages">All packages</a></li>
      <li><a href="/deals">Deals</a></li>
      <li><a href="/custom-trip">Customized Tours</a></li>
    </ul></div>
    <div><h3>Company</h3><ul>
      <li><a href="/about">About</a></li>
      <li><a href="/how-to-book">How to Book</a></li>
      <li><a href="/blog">Blog</a></li>
      <li><a href="/faq">FAQ</a></li>
    </ul></div>
    <div><h3>Contact</h3><ul>
      <li><a href="WHATSAPP_LINK">WhatsApp</a></li>
      <li><a href="tel:+971545582123">+971 54 558 2123</a></li>
      <li><a href="/contact">Contact us</a></li>
      <li><a href="https://www.instagram.com/tripcompanies">Instagram</a></li>
    </ul></div>
  </div>
</div>

<div class="ft-word" aria-hidden="true">tripcompanies</div>

<div class="container ft-base">
  <p>© YEAR Tripcompanies. All rights reserved.</p>
  <p><a href="/terms">Terms</a><a href="/privacy">Privacy</a><a href="/cancellation-policy">Cancellation policy</a></p>
</div>
```

Remove the old footer CSS (`.footer-news`, `.footer-grid`, `.footer-base` and old `.site-footer` rules), then add this at the end of `style.css`:

```css
.site-footer{position:relative;overflow:hidden;isolation:isolate;margin:0;padding:clamp(56px,6vw,88px) 0 0;background:#08060A;color:#F6F2F3;border-top:1px solid rgba(212,175,106,.28)}
.ft-glow{position:absolute;z-index:-1;left:50%;bottom:-38%;width:90%;height:75%;transform:translateX(-50%);background:radial-gradient(closest-side,rgba(236,10,68,.34),rgba(92,2,25,.22) 55%,transparent);filter:blur(30px);pointer-events:none}
.ft-top{display:grid;grid-template-columns:1.2fr .8fr;gap:clamp(32px,6vw,96px);align-items:end}
.ft-label{margin:0 0 14px;font-size:12px;font-weight:600;letter-spacing:.22em;text-transform:uppercase;color:#D4AF6A}
.site-footer .ft-title{margin:0;font-family:"Cormorant Garamond",Georgia,serif;font-weight:500;font-size:clamp(3.2rem,7.5vw,7rem);line-height:.98;letter-spacing:-.02em;color:#F6F2F3}
.site-footer .ft-title em{font-style:italic;color:#FF2E5F}
.ft-pill{display:flex;align-items:center;gap:8px;padding:6px 6px 6px 24px;border:1px solid rgba(255,255,255,.16);border-radius:999px;background:rgba(255,255,255,.04)}
.ft-pill:focus-within{border-color:#D4AF6A}
.ft-pill input{flex:1;min-width:0;height:48px;padding:0;border:0;outline:0;background:transparent;box-shadow:none;color:#F6F2F3;font-size:16px}
.ft-pill input::placeholder{color:#A79EA3}
.ft-pill button{flex:none;width:48px;height:48px;border:0;border-radius:50%;background:#EC0A44;color:#fff;font-size:20px;cursor:pointer;transition:background .25s,transform .25s}
.ft-pill button:hover{background:#FF2E5F;transform:translateX(2px)}
.ft-consent{display:flex;gap:10px;align-items:flex-start;margin:14px 0 0 24px;font-size:13px;line-height:1.5;color:#A79EA3}
.ft-consent input{flex:none;width:16px;height:16px;margin:2px 0 0;accent-color:#EC0A44}
.ft-dest{display:flex;flex-wrap:wrap;align-items:baseline;gap:6px clamp(14px,2vw,28px);margin-top:clamp(36px,4vw,56px);padding:clamp(20px,2vw,28px) 0;border-block:1px solid rgba(255,255,255,.1);font-family:"Cormorant Garamond",Georgia,serif;font-size:clamp(1.6rem,2.7vw,2.5rem);line-height:1.25}
.ft-dest a{color:#F6F2F3;text-decoration:none;transition:color .25s}
.ft-dest a:hover{color:#FF2E5F}
.ft-dest span{color:#D4AF6A;font-size:.5em}
.ft-grid{display:grid;grid-template-columns:1.7fr 1fr 1fr 1fr;gap:40px;padding:clamp(36px,3.5vw,48px) 0}
.ft-grid img{width:61px;height:auto}
.ft-grid p{margin:16px 0 0;max-width:34ch;font-size:15px;line-height:1.7;color:#A79EA3}
.site-footer .ft-grid h3{margin:0 0 16px;font-family:Poppins,sans-serif;font-size:12px;font-weight:600;letter-spacing:.18em;text-transform:uppercase;color:#D4AF6A}
.ft-grid ul{margin:0;padding:0;list-style:none;display:grid;gap:10px}
.ft-grid a:not(.logo){color:#D9D3D6;font-size:15px;text-decoration:none;transition:color .25s}
.ft-grid a:not(.logo):hover{color:#FF2E5F}
.ft-word{font-family:Poppins,sans-serif;font-weight:600;font-size:13.4vw;line-height:.86;letter-spacing:-.045em;text-align:center;white-space:nowrap;user-select:none;background:linear-gradient(180deg,rgba(255,46,95,.5),rgba(236,10,68,.04) 92%);-webkit-background-clip:text;background-clip:text;color:transparent}
.ft-base{display:flex;flex-wrap:wrap;justify-content:space-between;gap:8px 24px;padding-block:20px 24px;padding-right:96px;font-size:13px;color:#A79EA3}
.ft-base p{margin:0}
.ft-base a{color:inherit;text-decoration:none;margin-left:20px}
.ft-base a:first-child{margin-left:0}
.ft-base a:hover{color:#F6F2F3}
@media(max-width:900px){.ft-top{grid-template-columns:1fr;align-items:start}.ft-grid{grid-template-columns:1fr 1fr}.ft-grid>div:first-child{grid-column:1/-1}}
@media(max-width:768px){.site-footer{padding-bottom:72px}.ft-base{padding-right:0}}
```

Bump the CSS version number so the change shows.
