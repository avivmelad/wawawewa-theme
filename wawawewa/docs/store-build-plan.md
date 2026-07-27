# wawawewa Online Store — Build Plan

## Context

`wawawewa-theme` is currently an early-stage WordPress theme, generated from the `_s` ("underscores") starter theme, with default WooCommerce compatibility scaffolding already wired in (`inc/woocommerce.php`, `sass/woocommerce.scss`, theme support for the product gallery, related products, cart fragments, etc.). No real branding, niche, or store content exists yet — `style.css` still has the placeholder description "A wordpress theme for wawawewa stroe" and the home page template is empty aside from an ACF hero title.

The goal: turn this scaffold into a working WooCommerce store. Niche/product catalog is intentionally left as a placeholder to fill in later — this plan focuses on the technical build so the storefront is ready the moment products and branding are decided. Platform is WordPress + WooCommerce (own-brand physical products, not dropshipping).

**Stack choices for this build:**
- **SCSS** — already the theme's styling approach (`sass/` compiling to `dist/css`); continue using it for all new styles rather than introducing plain CSS or a different preprocessor.
- **ACF (Advanced Custom Fields)** — already in use (`page-templates/home-page.php` reads an ACF field for the hero title); extend this for structured content (homepage sections, custom product/page fields) rather than hardcoding content in templates.
- **Gravity Forms** — for any non-WooCommerce forms (contact, custom inquiry/wholesale forms, newsletter signup, etc.). WooCommerce's own cart/checkout forms are separate and not replaced by Gravity Forms.
- **Custom Post Types & Taxonomies** — register only if/when the store needs content structures WooCommerce products don't cover (e.g. a "Lookbook"/"Collections" CPT, a "Brand Story"/testimonials CPT, or a taxonomy for filtering beyond WooCommerce's built-in product categories/tags/attributes). Not created speculatively — added when a concrete content need shows up during the niche/branding pass.

## Design direction — FINALIZED: "Black & Gold"

**This supersedes the earlier "bold streetwear" and "blue/green" explorations** previously noted here. The niche is now decided (home goods/décor) and a high-fidelity homepage design was delivered via the Claude Design MCP project `עיצוב חנות אינטרנטית` (id `6e15106a-a49d-45e9-85cb-b7e220f17f7e`), file `Homepage Wireframes.dc.html`, handoff doc `design_handoff_homepage/README.md`. Site language is Hebrew (RTL) — see the RTL/Hebrew section in `CLAUDE.md`.

**Design tokens**
- Colors: bg `#121110`, footer/newsletter bg `#0a0908`, gold `#c9a24b` (hover `#e0bd6e`), text `#f0e9db`, muted text `#b7ac97`, footer muted text `#8a8272`, structural border `1.5px solid #c9a24b`, footer divider `1px solid #3a3327`.
- Type: **Heebo** (700/800/900) for headings, **Assistant** (400–700) for body/UI, **Unbounded** (800) for the "wawawewa" wordmark only. Loaded via Google Fonts.
- Shape: pill buttons (`border-radius:999px`), cards `16–24px` radius, `1.5px` border weight.
- Custom asset: WA monogram inline SVG (ring + interlocking "A"/"W" paths), used in header (34×34) and hero (72×72).

**Homepage sections (top to bottom)**: header (hamburger → slide-out drawer nav, centered WA logo, cart icon+badge) → hero (eyebrow pill, H1, subcopy, 2 CTAs) → full-width hero image → gold marquee strip (pure CSS animation) → best sellers (4-col WooCommerce product grid) → lookbook (asymmetric 3-col image grid) → testimonials (3-col cards) → about/brand strip (split image+copy) → FAQ accordion (single-open) → newsletter band → footer.

**Scope decision**: header/footer are site-wide (not homepage-only) — they're shared templates, so every page gets the dark/gold chrome.

### Implementation status (as of this checkpoint)

Implementation was started and paused mid-way (header + footer done) to be resumed as a dedicated task. The SCSS build is currently in a working state — no known gaps.

**Done:**
- `sass/abstracts/variables/_colors.scss` — brand palette added, sitewide `$color__background-body`/`$color__text-main`/link colors repointed to it.
- `sass/abstracts/variables/_typography.scss` — added `$font__heebo`, `$font__assistant`, `$font__unbounded`; `$font__main` now leads with Assistant.
- `sass/base/typography/_headings.scss` — h1–h6 now use Heebo/800 sitewide.
- `inc/setup-functions/enqueue.php` — Google Fonts enqueued; `js/navigation.js` now enqueued directly (it wasn't wired into the build pipeline before — `dist/js/general-script.min.js` is the only script that was actually being bundled/enqueued).
- `template-parts/brand/logo-mark.php` — new reusable WA monogram SVG partial.
- `header.php` — fully rebuilt: hamburger → slide-out drawer (via `wp_nav_menu( 'menu-1' )`) → centered logo+wordmark → cart badge.
- `js/navigation.js` — rewritten from the old dropdown-toggle pattern to drawer open/close (button, overlay, close button, outside click, Escape key).
- `sass/components/header/_header.scss` — header/hamburger/drawer/overlay styles, using `:dir(rtl)`/`:dir(ltr)` + logical properties so it's correct in Hebrew (primary) without depending on rtlcss for the transform-based slide animation.
- `footer.php` — rebuilt: newsletter band (Gravity Forms shortcode with a disabled-input fallback if Gravity Forms isn't active yet — swap the placeholder `form_id="1"` for the real form once built in wp-admin) + footer bar (copyright + תקנון/משלוחים/יצירת קשר links, currently pointing at placeholder `/terms/`, `/shipping/`, `/contact/` URLs pending real pages).
- `sass/components/footer/_footer.scss` — newsletter band + footer bar styles.
- `sass/components/_components.scss` — imports `header/header` and `footer/footer`; build is not currently broken.

**Not started yet:**
1. `page-templates/home-page.php` rebuild as an ACF **Flexible Content** dispatcher — one `page_sections` flexible content field, one layout per homepage section (hero, hero image, marquee, best sellers, lookbook, testimonials, about/brand strip, FAQ), each rendered via a function in the new `inc/flexible-strips.php` calling a `template-parts/strips/{layout-name}.php` partial. See the "Flexible content page sections" convention in `CLAUDE.md` for the exact pattern. Also rewrite `sass/pages/_home-page.scss` + new FAQ accordion JS module, and fix the stray `@package RAD` doc comment in the page template (copy-paste leftover, should be `@package wawawewa`).
2. Single flexible content field group (covering all strip layouts above) exported as one file under a new `acf-json/` folder + `acf/settings/save_json`/`load_json` hooks — not one field group per section.
3. `style.css` / `readme.txt` branding description cleanup (fix the "stroe" typo, reflect the real home-goods/décor niche).
4. Update `CLAUDE.md`'s "Current status" section once the above lands.
5. Run `npm run lint:scss` / `npm run lint:js` and do a final read-through.

Full implementation plan with file-by-file detail is preserved and can be re-derived from this section plus the design reference above; ask to resume "the homepage design implementation" to continue from here.

## Approach

Build in layers: environment → WooCommerce data/config → theme templates/styling → checkout/UX polish → launch readiness. Reuse the existing `_s` conventions already in the repo (the `wawawewa_` function prefix, `inc/` structure, `sass/` partials, `dist/` compiled output) rather than introducing a new architecture.

### 1. Local environment & plugin baseline
- Confirm/set up local WP environment (e.g. Local, wp-env, or existing dev setup) with WooCommerce plugin installed and activated so `class_exists('WooCommerce')` is true and `inc/woocommerce.php` actually loads.
- Install core supporting plugins as needed: a payment gateway (Stripe/PayPal via WooCommerce Payments or official extensions), WooCommerce shipping settings, and an SEO plugin (Yoast/RankMath) — install only what's needed, don't pre-install extras speculatively.
- Install and activate **ACF** (Pro if field groups need repeaters/flexible content for homepage sections) and **Gravity Forms**, since both are already assumed by the theme (ACF) or planned (Gravity Forms) for this build.
- Set WooCommerce store settings: currency, base location, tax setup (placeholder values acceptable until niche/legal jurisdiction is decided).

### 2. Placeholder catalog & structure
- Create a small set of placeholder products/categories in WooCommerce admin (simple + one variable product) purely to exercise every template (shop, category, single product, cart, checkout) during development — swappable later once the real catalog is decided.
- Define the WooCommerce pages (Shop, Cart, Checkout, My Account) via the standard WooCommerce setup wizard so template hooks in `inc/woocommerce.php` have real pages to attach to.

### 3. Theme templates for store pages
- Build out `woocommerce.css`/`sass/woocommerce.scss` (currently likely minimal/default) to match the finalized visual design (see Design direction above) once it's locked; until then, use the existing base typography/colors from `style.css` as the working default.
- Add/verify WooCommerce template overrides only where the default markup needs theme-specific structure — WordPress convention is a `woocommerce/` folder at the theme root overriding files from the plugin's `templates/` directory (e.g. `content-product.php`, `single-product/*`). Don't override files that don't need changes; WooCommerce falls back to its own templates automatically.
- Wire the mini-cart into `header.php` using the existing `wawawewa_woocommerce_header_cart()` helper (already implemented in `inc/woocommerce.php:198-227`, just needs to be called from the header template).
- Flesh out `page-templates/home-page.php` beyond the current bare hero — add a featured-products section using WooCommerce shortcodes/blocks (`[products limit="8" columns="4"]` or the Products block) so the homepage showcases the catalog. Model new homepage sections as ACF field groups (consistent with the existing hero-title field) rather than hardcoded markup, so content is editable without touching PHP.
- If a concrete need for extra content types emerges (collections, lookbook, brand story, etc.), register the CPT/taxonomy in a new `inc/setup-functions/cpt.php` (or similar), following the existing pattern of `inc/setup-functions/enqueue.php` being required from `functions.php`. Pair each CPT with its own ACF field group for structured content.
- Add a contact/inquiry form via Gravity Forms and embed it (shortcode or block) on the relevant page — do not build a custom form handler for anything Gravity Forms already covers.

### 4. Cart, checkout & account UX
- Style cart/checkout/my-account pages using the existing `sass/plugins/woocommerce/` partials as the base, extending rather than replacing.
- Verify AJAX add-to-cart, cart fragment updates (already hooked via `wawawewa_woocommerce_cart_link_fragment`), and mobile responsiveness of the product grid (`product_grid` theme support already configured for 1–6 columns in `inc/woocommerce.php:20-33`).
- Confirm compiled JS in `dist/js` includes any needed WooCommerce interaction scripts (quantity steppers, variation swatches) — check `js/` source and the npm build scripts referenced in `composer.json`/`package.json`.

### 5. Branding & content pass (once niche is decided)
- Replace placeholder theme header description/branding in `style.css` and `readme.txt`.
- Add real logo via the already-configured `custom-logo` theme support (`functions.php:96-104`).
- Swap placeholder products for the real catalog; write real product copy, categories, and homepage content.

### 6. Launch readiness
- Run through WooCommerce's standard pre-launch checklist: legal pages (Terms, Privacy, Refund Policy — required for the checkout to be trustworthy), tax/shipping rules for real jurisdictions, payment gateway in live mode, SSL/HTTPS on the production host.
- Cross-browser/mobile check of the full purchase funnel (browse → cart → checkout → order confirmation email).
- Performance pass: image optimization, caching plugin, and confirm the compiled `dist/css`/`dist/js` (not source Sass/JS) are what's enqueued in production.

## Verification
- After each layer, walk the funnel manually in a browser: view shop → view product → add to cart → checkout with a WooCommerce test payment gateway (e.g. Stripe test mode) → confirm order appears in WooCommerce admin.
- Run the theme's existing lint tooling (`phpcs.xml.dist`, `.eslintrc`, `.stylelintrc.json`) before considering any template/style changes done, since the repo already enforces these.
- Check responsive behavior at mobile/tablet/desktop breakpoints for shop grid, single product page, and checkout form.
