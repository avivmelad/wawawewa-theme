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

## 4. Site-wide chrome
- [x] Header: drawer nav, logo, cart badge (`header.php`, `js/navigation.js`, `sass/components/header/_header.scss`)
- [x] Footer: newsletter band + footer bar (`footer.php`, `sass/components/footer/_footer.scss`)

## 5. Homepage content build (ACF Flexible Content "strips" — see CLAUDE.md)
- [ ] `page_sections` flexible content field group created, one layout per section, exported as a single file to `acf-json/`
- [ ] `inc/flexible-strips.php` created + required from `functions.php`, one render function per layout
- [ ] `template-parts/strips/` partials, one per layout
- [ ] Hero strip
- [ ] Hero image strip
- [ ] Gold marquee strip
- [ ] Best sellers product grid strip
- [ ] Lookbook grid strip
- [ ] Testimonials strip
- [ ] About/brand strip
- [ ] FAQ accordion strip (+ JS module)
- [ ] `page-templates/home-page.php` rebuilt as the flexible-content dispatcher + `sass/pages/_home-page.scss` rewrite
- [ ] Fix stray `@package RAD` comment in `page-templates/home-page.php`

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
