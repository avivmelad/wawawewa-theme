# Current mission: Category/archive page — "Futuristic v2" direction

Temporary scratch file — delete once this mission is fully done (see CLAUDE.md "Current mission tracking"). The prior "Single Product page" mission is code-complete (`docs/checklist.md` section 6 already marks it `[x]`) — its one remaining item, live verification on staging, isn't a blocker and doesn't need its own scratch file; starting fresh here.

## Goal
Build the WooCommerce product category/archive page per `Category Page Futuristic v2.dc.html` (project `6e15106a-a49d-45e9-85cb-b7e220f17f7e`): category header, sidebar filters (sort/price/sub-category), product grid, pagination — reusing real WooCommerce query behavior wherever possible instead of hand-rolling it.

Note for the design-reference table in CLAUDE.md: no `Category Page Futuristic Mobile v2.dc.html` exists yet in the project (only the v1 mobile file, `Category Page Futuristic Mobile.dc.html`) — mobile pass for this page will need that v2 mobile file fetched once it's added, same as the product page mission had to wait for its mobile v2 file.

## Decisions made
- **Filtering approach** (confirmed via AskUserQuestion): real filters via a `<form method="get">` that auto-submits on change, reusing WooCommerce's own query vars — **not** AJAX, **not** a visual-only placeholder.
  - **Sort**: radio inputs use WooCommerce's own accepted `orderby` values directly (`menu_order`/`date`/`price`/`price-desc`) — `WC_Query::product_query()` already reads `$_GET['orderby']` on the main query for `is_shop()`/`is_product_taxonomy()`, zero custom PHP needed.
  - **Price**: WooCommerce's `WC_Query::price_filter_post_clauses()` already reads `$_GET['min_price']`/`$_GET['max_price']` unconditionally on the main query (not just when the price-filter widget is present) — so the 4 mockup price buckets (≤₪100 / ₪100–250 / ₪250–500 / ₪500+) are plain links/radios setting those two GET params, zero custom PHP. Rendered as radios (only one range can be active at a time — WC's price filter is a single min/max range, not stackable buckets) but visually styled as square checkboxes to match the mockup's uniform filter-box look.
  - **Sub-category**: WooCommerce's default taxonomy-archive query already includes descendant terms (`include_children` defaults true for hierarchical taxonomies), so the *parent* category page already shows all subcategory products — the checkboxes exist to *narrow down* to specific subcats. Real custom PHP needed: `pre_get_posts` (`inc/woocommerce.php`) replaces the query's `tax_query` with the selected subcat slugs (`$_GET['subcat'][]`) when any are checked, sanitized via `sanitize_title`. True multi-select (OR relation via one tax_query clause with a terms array).
  - **Clear filters**: plain link back to the category's base URL (no query args) — no JS needed.
- **"New" badge**: no native WooCommerce concept — defined as "published within the last 30 days" (`get_the_time('U')` vs `current_time('timestamp')`). Documented here since it's an arbitrary threshold, not a real data field.
- **Badge priority**: if both true, on-sale wins over new (real transactional info judged more useful to a shopper than recency) — only one badge shown per card, matching the mockup.
- **Product card**: reused the shared `.product-card` component (already used by Best-sellers + related products) rather than a new one, extended with a new `&__badge` element (absolute corner pill) since neither prior usage needed a badge. `woocommerce_template_loop_add_to_cart()` reused for the "הוסף" button — same real AJAX add-to-cart already working on Best-sellers, no custom JS.
- **Quick-view hover overlay + shine sweep** (mockup's card hover): skipped, same rationale as the product page's related-products decision — no quick-view modal exists, and shine-for-its-own-sake was already rejected once this session line; reused the established `[data-tilt]` hover instead for a consistent interaction language across all three product-grid contexts (Best-sellers, related products, category grid).
- **Footer** in the mockup file is a minimal 2-line placeholder (copyright + 3 links) — this is the design tool's simplified chrome for iterating on this one page, not a real second footer design; the page uses the real site-wide `footer.php` (full expanded footer), exactly like every other page.
- **Template**: single `woocommerce/archive-product.php` override handles both the plain shop page and product-category archives (WooCommerce's own default template does the same) — category-specific bits (subcategory list, "CATEGORY" vs "SHOP" breadcrumb/badge label) branch on `is_product_category()` inside it.

## Steps
- [x] Fetched `Category Page Futuristic v2.dc.html` (+ read `image-slot.js`/`support.js` as instructed — confirmed both are design-tool runtime scaffolding only, per CLAUDE.md's existing note; nothing ported from them)
- [x] AskUserQuestion: filtering approach → real GET-based filters (see Decisions)
- [x] `woocommerce/archive-product.php` — full override: breadcrumb (existing shared `woocommerce_breadcrumb()` hook/styling, no new work), category header (eyebrow badge + title + result count), sidebar filter form (sort/price/subcategory/clear), product grid loop (real main query, `.product-card` + badge), pagination (`paginate_links()` styled as circles, preserving active filter GET params via `add_args`)
- [x] `inc/woocommerce.php` — `pre_get_posts` subcategory tax_query override (`wawawewa_category_page_subcat_filter`, priority 20)
- [x] `inc/template-functions.php` — `wawawewa_get_category_page_context()` (current term/title/badge label/subcat terms) + `wawawewa_get_product_grid_badge()` ("new"/"sale" resolution)
- [x] `sass/components/_product-card.scss` — added `&__badge` element (additive, doesn't affect Best-sellers/related usages that don't render it) + `position: relative` on `&__image` so the badge can anchor to it
- [x] `sass/plugins/woocommerce/_archive-product.scss` (new) — category header, sidebar layout + custom radio/checkbox visuals, product grid wrapper, pagination circles; imported from `sass/style.scss`'s WooCommerce section
- [x] `js/category-filters.js` (new) — auto-submit the filter form on change; price radios set hidden `min_price`/`max_price` fields from `data-min`/`data-max` before submitting
- [x] `inc/setup-functions/enqueue.php` — enqueue particles/product-tilt/category-filters on `is_shop() || is_product_taxonomy()` (reuses the same gating pattern as `is_product()`); `faq-accordion` stays scoped to home+product only, since the category page has no accordion
- [ ] Verify on staging once real categories/products exist — RTL first, then desktop, then mobile (mobile pass blocked on the v2 mobile mockup not existing yet — see note above)

## Notes
- Full design spec (colors, spacing, sidebar/grid structure) copied from the fetched `Category Page Futuristic v2.dc.html` mockup this session — re-fetch via DesignSync if a detail needs re-checking rather than trusting this file's paraphrase.
- `npm run lint:scss` / `php -l` could not be run in this session's sandbox (neither `npm` nor `php` were on `PATH`) — the new/edited PHP and SCSS were only manually reviewed. Run `npm run lint:scss` for real before/while verifying on staging, per the standing CLAUDE.md rule.
