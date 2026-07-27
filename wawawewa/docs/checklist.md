# wawawewa Store — Build Checklist

Living status tracker for the store build. Detail/rationale for each item lives in [`docs/store-build-plan.md`](store-build-plan.md) — this file is just scannable status.

**Rule: when a checklist item is finished, flip it to `[x]` as part of that same piece of work — don't defer it to a later cleanup pass.**

## 1. Environment & plugin baseline
- [ ] Local/staging WP environment confirmed with WooCommerce active (`class_exists('WooCommerce')` true, `inc/woocommerce.php` loads)
- [ ] Payment gateway installed (decision pending — see build plan step 1)
- [ ] ACF active
- [ ] Gravity Forms active
- [ ] WooCommerce store settings set (currency, base location, tax — placeholders acceptable for now)

## 2. Placeholder catalog & structure
- [ ] Placeholder products/categories created (simple + one variable product)
- [ ] WooCommerce core pages set up (Shop, Cart, Checkout, My Account)

## 3. Theme foundation & branding tokens
- [x] Brand palette (`sass/abstracts/variables/_colors.scss`)
- [x] Typography variables + headings (`sass/abstracts/variables/_typography.scss`, `sass/base/typography/_headings.scss`)
- [x] Breakpoints system (`sass/abstracts/variables/_breakpoints.scss`, `mq()` mixin)
- [x] ACF options page registered ("הגדרות האתר", `inc/setup-functions/options-page.php`) + `acf-json/` folder created
- [x] "הדר" (header) tab + `header_logo` image field added to site settings (`acf-json/group_wawawewa_site_settings.json`); `header.php` reads it via `get_field('header_logo', 'option')` with SVG fallback
- [ ] Real logo image uploaded in wp-admin (currently falls back to the placeholder WA monogram SVG)
- [ ] Remaining global site-settings fields for other areas (footer contact/social, global banners, etc.) as they come up

## 4. Site-wide chrome
- [x] Header: drawer nav, ACF-editable logo, sticky positioning, cart icon + mini-cart dropdown (`header.php`, `js/navigation.js`, `js/mini-cart.js`, `sass/components/header/_header.scss`)
- [x] Header "Futuristic" restyle: gradient wordmark, translucent background, JetBrains Mono drawer label (see build plan "Design evolution")
- [x] Footer: newsletter band + footer bar (`footer.php`, `sass/components/footer/_footer.scss`) — still in the original plain layout, not yet redone in the Futuristic direction

## 5. Homepage content build (ACF Flexible Content "strips" — see CLAUDE.md)
- [x] `page_sections` flexible content field group created, exported to `acf-json/group_wawawewa_home_page_sections.json`
- [x] `inc/flexible-strips.php` created + required from `functions.php` (`wawawewa_render_strips()` dispatcher)
- [x] `template-parts/strips/` partials directory started
- [x] Hero strip, rebuilt in the "Futuristic" direction: corner brackets, pulsing badge, gradient-highlight heading, magnetic CTAs, parallax, photo/video/YouTube media choice with gradient-fade + tag badge (`template-parts/strips/hero.php`, `sass/pages/_home-page.scss`)
- [x] Reusable scroll-reveal utility (`[data-reveal]`, `js/reveal.js`, `sass/utilities/_reveal.scss`) and particle-network canvas (`js/particles.js`) — infrastructure for future sections too
- [ ] Gold marquee strip (Futuristic direction)
- [ ] Best sellers product grid strip (Futuristic direction)
- [ ] Lookbook/categories grid strip (Futuristic direction)
- [ ] Testimonials strip (Futuristic direction)
- [ ] About/brand strip (Futuristic direction)
- [ ] FAQ accordion strip (+ JS module, Futuristic direction)
- [x] Mobile pass for the Futuristic Hero + header (full-width drawer, scaled corner/badge/logo/heading/image-badge sizes, universal `.button:active` tap feedback)
- [x] `page-templates/home-page.php` rebuilt as the flexible-content dispatcher
- [x] Fix stray `@package RAD` comment in `page-templates/home-page.php`

## 6. WooCommerce store pages
- [ ] `woocommerce/` template overrides added where needed
- [ ] Mini-cart wired into `header.php` via `wawawewa_woocommerce_header_cart()`
- [ ] Cart/checkout/my-account styling (`sass/plugins/woocommerce/`)
- [ ] AJAX add-to-cart + cart fragment updates verified
- [ ] Product grid responsiveness verified (1–6 columns)

## 7. Branding & content pass
- [ ] Real logo added (`custom-logo` theme support)
- [ ] `style.css` / `readme.txt` branding cleanup (fix "stroe" typo, real niche description)
- [ ] Real catalog: products, categories, copy
- [ ] `CLAUDE.md` "Current status" updated once homepage lands

## 8. Launch readiness
- [ ] Legal pages (Terms, Privacy, Refund Policy)
- [ ] Tax/shipping rules for real jurisdiction
- [ ] Payment gateway in live mode
- [ ] SSL/HTTPS confirmed on production host
- [ ] Cross-browser/mobile funnel test (browse → cart → checkout → order confirmation)
- [ ] Performance pass: image optimization, caching, confirm `dist/css`/`dist/js` (not source) are what's enqueued
