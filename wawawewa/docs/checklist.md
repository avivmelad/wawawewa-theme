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
- [x] Wordmark text/image radio choice (`header_wordmark_type` + conditional `header_wordmark_text`/`header_wordmark_image`) — replaces the hardcoded site-name text next to the logo
- [ ] Real logo image uploaded in wp-admin (currently falls back to the placeholder WA monogram SVG)
- [x] "פוטר" (footer) tab added to site settings — newsletter heading/subcopy/Gravity Forms ID, copyright text, brand blurb, social links repeater, link-columns repeater (nested Link fields), and payment badges repeater, replacing all the hardcoded footer content in `footer.php`
- [ ] Remaining global site-settings fields for other areas (contact info, global banners, etc.) as they come up

## 4. Site-wide chrome
- [x] Header: drawer nav, ACF-editable logo, sticky positioning, cart icon + mini-cart dropdown (`header.php`, `js/navigation.js`, `js/mini-cart.js`, `sass/components/header/_header.scss`)
- [x] Header "Futuristic" restyle: gradient wordmark, translucent background, JetBrains Mono drawer label (see build plan "Design evolution")
- [x] Footer: newsletter band + expanded dark footer (brand/blurb/social + link columns + copyright/payment bottom row), fully ACF-editable and matching the current v2 design (`footer.php`, `sass/components/footer/_footer.scss`)

## 5. Homepage content build (ACF Flexible Content "strips" — see CLAUDE.md)
- [x] `page_sections` flexible content field group created, exported to `acf-json/group_wawawewa_home_page_sections.json`
- [x] `inc/flexible-strips.php` created + required from `functions.php` (`wawawewa_render_strips()` dispatcher)
- [x] `template-parts/strips/` partials directory started
- [x] Hero strip, rebuilt in the "Futuristic" direction: corner brackets, pulsing badge, gradient-highlight heading, magnetic CTAs, parallax, photo/video/YouTube media choice with gradient-fade + tag badge (`template-parts/strips/hero.php`, `sass/pages/_home-page.scss`)
- [x] Reusable scroll-reveal utility (`[data-reveal]`, `js/reveal.js`, `sass/utilities/_reveal.scss`) and particle-network canvas (`js/particles.js`) — infrastructure for future sections too
- [x] Gold marquee strip (Futuristic direction), desktop + mobile — `marquee_items` repeater field, one text per row, rendered via Swiper in continuous-loop mode (`template-parts/strips/marquee.php`, `js/marquee.js`, vendored `dist/js/swiper-bundle.min.js`) after a hand-rolled CSS keyframe version proved unreliable on RTL; mobile font/padding scaled to match the mobile mockup, spacing/speed tuned wider/faster than the mockup per request at both breakpoints
- [x] Best sellers product grid strip (Futuristic direction) — manual ACF relationship field picks products; reuses WooCommerce's own image/price/add-to-cart (`template-parts/strips/best-sellers.php`, `js/product-tilt.js`), desktop tilt-hover + mobile tap-scale
- [x] Lookbook/categories grid strip (Futuristic direction) — 3 ACF taxonomy fields picking real WooCommerce product categories (native category thumbnail image + `get_term_link()`), asymmetric 1.3fr/1fr/1fr grid on desktop, stacked on mobile (`template-parts/strips/categories.php`, `sass/pages/_home-page.scss`)
- [x] Testimonials strip (Futuristic direction) — `testimonials_items` ACF repeater (`quote`, `author`), static 5-star line per the mockup, 3-col desktop / 2-col tablet / stacked mobile (`template-parts/strips/testimonials.php`, `sass/pages/_home-page.scss`)
- [x] About/brand strip (Futuristic direction) — all content ACF fields (`about_image`, `about_eyebrow`, `about_heading`, `about_body`, `about_link` Link field), split image+copy grid, copy side is a dark chrome panel matching drawer/mini-cart/newsletter (`template-parts/strips/about.php`, `sass/pages/_home-page.scss`)
- [x] FAQ accordion strip (Futuristic direction) — `faq_items` ACF repeater (`question`, `answer`), single-open accordion with real `<button>` headers (`aria-expanded`/`aria-controls`, `js/faq-accordion.js`), first row open by default (`template-parts/strips/faq.php`, `sass/pages/_home-page.scss`)
- [x] Mobile pass for the Futuristic Hero + header (full-width drawer, scaled corner/badge/logo/heading/image-badge sizes, universal `.button:active` tap feedback)
- [x] Recolored everything built so far to the "v2" light/cream palette (current main design, see build plan "Design evolution — v2") — header/mini-cart/drawer, footer, buttons, Hero/Marquee/Best-sellers, default logo SVG, particle canvas; verified mobile mockup uses identical colors, no separate mobile pass needed
- [x] `page-templates/home-page.php` rebuilt as the flexible-content dispatcher
- [x] Fix stray `@package RAD` comment in `page-templates/home-page.php`
- [ ] Fill in real content for every strip in wp-admin (Hero, Marquee text, Best-sellers product picks, Categories' 3 real WooCommerce categories, Testimonials, About copy/image, FAQ questions, footer content) and verify on staging — RTL first, then desktop, then mobile, for each

## 6. WooCommerce store pages
- [x] Single product page rebuilt in the Futuristic v2 direction (`woocommerce/content-single-product.php`, `woocommerce/single-product/related.php`, `woocommerce/single-product/rating.php`, `sass/plugins/woocommerce/_single-product.scss`) — see `docs/current-mission.md` for the full breakdown
- [ ] `woocommerce/` template overrides for other pages (cart, checkout, my-account) added where needed
- [x] Mini-cart wired into `header.php` via custom `.header-cart` markup (not the sample `wawawewa_woocommerce_header_cart()` helper, which is unused leftover scaffolding)
- [ ] Cart/checkout/my-account styling (`sass/plugins/woocommerce/`)
- [x] AJAX add-to-cart + cart fragment updates verified (header cart count + mini-cart, see checklist section 4 history)
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
