# Tripcompanies

A premium marketing site for the Dubai desk at [tripcompanies.com](https://tripcompanies.com). It is plain PHP, HTML, CSS and JavaScript. Upload the folder to cPanel and it runs. There is no build step and no database.

## Edit a package

Open `data/packages.php`. Each trip is one block in the array. Copy a block to add another, and keep the same keys.

- `slug` becomes the address, for example `swiss-alps-paris` is `/packages/swiss-alps-paris`. Use lowercase letters, numbers and hyphens only.
- `season` is `winter`, `spring`, `summer` or `autumn`.
- `region` is `europe`, `asia`, `middle-east`, `africa` or `uae`.
- `type` is `outbound` (holidays from Dubai) or `inbound` (UAE stays for visitors).
- `price_from` is the starting price in AED.
- `image` and `gallery` are full image URLs. The samples use Unsplash. Replace them with photos you host yourself when you can — hotlinked pictures can change.

Seasonal pages, the outbound list and the package page all read this file. You do not need to touch the layout.

Visa countries live in `data/visas.php`. UAE day experiences live in `data/experiences.php`. The phone, WhatsApp number, email and navigation live in `data/site.php`.

The guest notes on the home page are sample layout copy. Replace them in `data/site.php` before you treat them as real reviews.

## Contact email

The public address is `email` in `data/site.php`. Enquiry mail is sent with PHP `mail()` to that address. The From header uses `mail_from`. On some hosts that address must belong to the domain — change `mail_from` if messages never arrive. To switch to SMTP later, replace the inside of `send_enquiry_mail()` in `includes/functions.php`. The form can stay as it is.

WhatsApp links are built by `wa_link()` in `includes/functions.php`.

## Upload to cPanel

1. Upload everything in this folder into `public_html` (the domain root), including `.htaccess`.
2. Confirm the site opens at `https://tripcompanies.com/` without `.php` in the address.
3. Open a package, for example `/packages/swiss-alps-paris`.
4. Send a test enquiry from the contact page. Check the inbox for `email` in `data/site.php`.
5. Replace `assets/img/logo.svg` with the final logo when you have it. It is a white mark on a crimson circle.

The site is meant to live at the domain root. If you put it in a subfolder, set `BASE_PATH` in `includes/config.php` and `RewriteBase` in `.htaccess` to that folder.

## Preview on your computer

From this folder, with PHP 8 installed:

```bash
php -S localhost:8080 router.php
```

Then open `http://localhost:8080`. The `router.php` file is only for that local server. Apache uses `.htaccess` instead.
