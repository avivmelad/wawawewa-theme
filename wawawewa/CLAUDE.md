# wawawewa — WordPress/WooCommerce Theme

## What this is

A WordPress theme for the `wawawewa` online store, built on the `_s` ("underscores") starter theme with WooCommerce support wired in. It is the front-end theme only — product/order data lives in WooCommerce (a plugin), not in this repo.

The full build plan and roadmap live in [`docs/store-build-plan.md`](docs/store-build-plan.md) — read it before starting new work to see what stage the project is at and what's next. Keep it updated as milestones are completed or the plan changes.

Live checkbox status for every phase of the build is tracked in [`docs/checklist.md`](docs/checklist.md) — check items off there as soon as that piece of work lands, in the same commit/session, not as a deferred cleanup step.

**Current mission tracking**: while actively working on a multi-step task (e.g. "the header"), keep a scratch file at `docs/current-mission.md` — a short goal statement plus a step checklist, updated after every step so work can resume mid-task even across a session break. This file is temporary: once the whole mission is finished, delete it (its outcome should already be reflected in `docs/checklist.md` / `docs/store-build-plan.md`, so nothing is lost). If `docs/current-mission.md` exists when a session starts, read it first — it means a mission was left in progress.

**Any change made while `docs/current-mission.md` exists must be logged there before the task is considered done, in the same turn** — not just the originally-planned steps. This includes small, unplanned fixes requested mid-mission (a CSS layout tweak, a one-line hook fix) — append them as their own bullet rather than skipping the log because they felt too small to count as "a step."

## Current status

Niche and visual identity are now decided: home goods/décor, "Black & Gold" luxury direction (currently the "v2" light/cream palette — see the Design references table below), Hebrew (RTL) first. A high-fidelity homepage design has been delivered; header and footer are implemented site-wide, and every planned homepage flexible-content strip is now built (Hero, Marquee, Best sellers, Categories/Lookbook, Testimonials, About, FAQ) — see `docs/checklist.md` section 5. Still open: filling in real content for each strip in wp-admin and verifying on staging (see `docs/current-mission.md` if it still exists). See the "Implementation status" checkpoint under Design direction in [`docs/store-build-plan.md`](docs/store-build-plan.md) for exactly what's done and what's left.

## Design references (Claude Design)

Every mockup file the user has provided for this project lives in **one Claude Design project**, imported via the `DesignSync` tool (not a manual fetch/paste each time). **Before asking the user to re-paste a design prompt, try pulling the file directly first** — check the table below for the exact filename, then:

1. `DesignSync` `get_project` with the project ID below to confirm access (it won't show up in `list_projects` — that call only lists *design-system* type projects, and this one is `PROJECT_TYPE_PROJECT`).
2. `DesignSync` `list_files` to see the current file list (design files get added/renamed over time — this project ID is the durable part, not the exact filename list below).
3. `DesignSync` `get_file` with the exact path to read one file's full markup.

**Project**: `עיצוב חנות אינטרנטית` — ID `6e15106a-a49d-45e9-85cb-b7e220f17f7e`.

| File | Covers |
|---|---|
| `Homepage Futuristic v2.dc.html` | **Current**, desktop — same layout/interactions as `Homepage Futuristic.dc.html` below, but with the **current color palette**: light/cream main canvas + dark "chrome" accent panels (nav drawer, mini-cart, about-copy side, newsletter band), instead of the all-dark v1 palette. Implement new sections' colors against this file; layout/structure still comes from the desktop/mobile pair below. **This file gets edited by the user over time** (e.g. the footer was expanded on 2026-07-31 to add a brand blurb/social icons/link-columns/payment badges after already being implemented once without them) — if something you build against it later looks different from what's live, re-fetch rather than trusting an earlier read in this session. |
| `Homepage Futuristic Mobile v2.dc.html` | Same as above, mobile viewport (390×844 iOS frame, light `dark={false}` device frame). Colors confirmed identical to the desktop v2 file. Its expanded footer differs slightly from desktop's (2 link columns instead of 3, no "החברה" column, fewer links per column) — treated as the same responsive content stacking to fewer visual columns on a narrow screen, not as separate content to maintain; the built footer uses one ACF-driven set of columns for both breakpoints. |
| `Homepage Futuristic.dc.html` | Desktop layout/interactions reference — every section top to bottom (header, hero, marquee, best sellers, categories/lookbook, testimonials, about, FAQ, newsletter/footer). Colors here are the superseded v1 dark palette — use v2 above for colors instead. |
| `Homepage Futuristic Mobile.dc.html` | Same as above, mobile viewport (390×844 iOS frame). Always pull both files together when building a new section's layout, then apply the v2 files' colors. |
| `Homepage Wireframes.dc.html` / `Homepage Wireframes Mobile.dc.html` | Superseded — the original plain "Black & Gold" layout before the "Futuristic" direction (see `docs/store-build-plan.md`). Only relevant for historical context. |
| `Category Page Futuristic v2.dc.html` | Category/archive page, Futuristic v2 palette — not yet implemented. Check for a v1 vs v2 discrepancy the same way the homepage/product files had one before implementing. |
| `Category Page Futuristic.dc.html` / `Category Page Futuristic Mobile.dc.html` | Category/archive page, Futuristic v1 (dark) direction — superseded by the v2 file above for colors. |
| `Category Page.dc.html` | Superseded plain category page. |
| `Product Page Futuristic v2.dc.html` | **Current**, desktop — single product page, Futuristic v2 (light/cream) direction. Implemented 2026-07-31: gallery (restyled WC native gallery, no template override needed — theme already declares `wc-product-gallery-zoom`/`-lightbox`/`-slider` support), stock badge, category, title, real star rating, price, excerpt, WC's native variations form (styled, not replaced), quantity/add-to-cart, trust badges, 3 accordions (description/shipping/care), related products (real WC query, restyled cards). See `docs/current-mission.md` for the full decision breakdown. |
| `Product Page Futuristic Mobile v2.dc.html` | Same as above, mobile viewport (390×844 iOS frame). Implemented 2026-07-31 — every font-size/spacing value matched exactly; one real mismatch caught and fixed: trust badges keep 3 columns on mobile (tighter gap/padding/font), not the single-column stack that had been guessed before this file was fetched. |
| `Product Page Futuristic.dc.html` | Single product page, Futuristic v1 (dark) direction — superseded by the v2 file above. |
| `Color Direction - White Black Gold.dc.html` | Not yet read/checked — appeared in the project's file list during the product-page work; likely a palette reference doc. Check it before it's needed for something, rather than assuming it's covered by the v2 palette already extracted. |
| `wawawewa-icon.svg` / `wawawewa-icon-gold.svg` | Not yet read/checked — appeared in the project's file list during the product-page work; possibly a source asset for the WA monogram (`template-parts/brand/logo-mark.php` currently hand-codes the SVG paths instead of using a file asset). Check before assuming the current inline SVG is final. |
| `image-slot.js`, `support.js`, `ios-frame.jsx`, `design_handoff_homepage/*` | Design-tool runtime/handoff scaffolding only (placeholder image slots, the mobile device frame, a README). Never port these into the theme — they're read-only reference, not theme code. The real theme uses ACF image fields + plain `<img>`/WooCommerce output instead. |

Concrete pixel/spacing/font specs already extracted from the homepage Futuristic files (so far: Hero, Marquee, Best sellers, Categories, Testimonials, About, FAQ, Newsletter) are recorded in `docs/current-mission.md` under "Design specs pulled from Claude Design" — check there first before re-fetching a file that's already been read once this project.

**When the user gives a new design prompt/URL in the future**: add a row to the table above (file name + one-line description of what it covers) rather than only acting on it in-session, so the next session can self-serve the same way.

## Stack

- **WordPress theme**, PHP. Write modern PHP consistent with the existing codebase.
- **WooCommerce** for all commerce logic (cart, checkout, products, orders). Never duplicate what WooCommerce already provides — hook into it via `inc/woocommerce.php`.
- **SCSS** compiled with `node-sass` → CSS at the theme root (`style.css`, `style-rtl.css`), and via the VS Code Live Sass Compile extension → `dist/css/style.min.css` (the one actually enqueued — see `inc/setup-functions/enqueue.php`). **Single entry point**: `sass/style.scss` compiles everything, including WooCommerce styling (`sass/plugins/woocommerce/*`) — there is no separate `woocommerce.scss`/`woocommerce.css` anymore (removed 2026-07-31 so saving one file refreshes all compiled CSS, instead of needing to remember to also touch a second entry point). Never hand-edit the compiled `.css` files directly — edit the `sass/` source.
- **ACF (Advanced Custom Fields)** for structured/editable content (see `page-templates/home-page.php` for the existing pattern).
- **Gravity Forms** for any non-WooCommerce forms (contact, inquiry, newsletter). Don't hand-roll form handling that Gravity Forms already covers.
- **Yoast SEO** for SEO (decided). Payment gateway is not yet decided — see `docs/store-build-plan.md` step 1.
- **Jetpack** (`inc/jetpack.php`) is unused, leftover `_s` starter-theme scaffolding — it only activates if the Jetpack plugin happens to be installed. Not part of the required plugin stack; don't build new features assuming it's active.
- Custom Post Types / taxonomies are added only when a concrete content need appears — not speculatively (see build plan for rationale).

## RTL / Hebrew

The site launches in **Hebrew first** — RTL is the primary, default direction, not a secondary concern to bolt on later. Build and test every new page/component with RTL as the expected default.

- `header.php` already calls `language_attributes()`, which correctly outputs `dir="rtl"` automatically when the site's language is Hebrew — no change needed there.
- **Styling workflow — no separate RTL stylesheet in production**: `wp_style_add_data('wawawewa-style', 'rtl', 'replace')` in `inc/setup-functions/enqueue.php` would tell WordPress to swap `dist/css/style.min.css` for `dist/css/style-rtl.min.css` on RTL sites, but nothing in the build actually produces that `dist/css/style-rtl.min.css` file (`npm run compile:rtl` runs rtlcss against the root-level `style.css` and writes `style-rtl.css` to the theme root instead — a file the frontend never loads). Requesting the swapped URL 404s.
- **Current fix (intentional, keep as-is)**: in `enqueue.php`, `wp_style_add_data(...)` is called *before* `wp_enqueue_style(...)` registers the `wawawewa-style` handle. `wp_style_add_data()` silently no-ops when the handle isn't registered yet, so the RTL swap never attaches and WordPress just serves `dist/css/style.min.css` directly for every visitor, RTL included — no 404. **Do not "fix" this by reordering the two calls back** (enqueue-then-add-data) — that re-enables the swap and reintroduces the 404, since there's still no pipeline producing `dist/css/style-rtl.min.css`.
- **Practical implication**: there is currently one stylesheet for both directions. Any RTL-specific override must live in the same SCSS that compiles into `dist/css/style.min.css` (via the VS Code Live Sass Compile extension per `.vscode/settings.json`), scoped with the `.rtl` class WordPress already adds to `<body>` via `body_class()` (see `header.php`) when the site locale is RTL — not in a separate rtlcss-generated file.
- **Writing new SCSS**: prefer logical CSS properties (`margin-inline-start`/`-end`, `padding-inline-*`, `text-align: start`/`end`, `inset-inline-*`) over physical `left`/`right` wherever a property should flip with direction — most rules then need no RTL-specific override at all.
- Reserve physical `left`/`right` plus the existing `/*rtl:ignore*/` rtlcss comment pattern (see `sass/utilities/_alignments.scss`) only for things that are semantically fixed regardless of direction — e.g. `.alignleft`/`.alignright`, which are literal left/right by definition, not direction-relative.
- When testing any new page or component, check it in Hebrew (RTL) as the primary case — don't treat LTR as the default and RTL as "does it flip ok."

## Directory structure

```
inc/                       theme setup, hooked via functions.php
  custom-header.php
  customizer.php
  jetpack.php
  template-functions.php
  template-tags.php
  woocommerce.php           all WooCommerce theme integration lives here
  setup-functions/
    enqueue.php              script/style enqueuing
    cpt.php                  (add here if/when a CPT is needed — see build plan)
sass/                       SCSS source, 7-1-style architecture
  generic/                  normalize, box-sizing
  base/                     base element styles
  abstracts/                variables, mixins (no CSS output)
  components/                reusable UI pieces
  layouts/                  layout partials (sidebar/no-sidebar/content-sidebar)
  pages/                    page-specific styles (e.g. _home-page.scss)
  utilities/                accessibility, alignment helpers, scroll-reveal, particle canvas
  plugins/woocommerce/      WooCommerce-specific overrides, imported into style.scss like any other partial
  style.scss                single entry point, imports everything above (including WooCommerce)
js/                         source JS (customizer.js, navigation.js)
dist/                       compiled build output — never edit directly
page-templates/             custom page templates (e.g. home-page.php, ACF-driven)
woocommerce/                WooCommerce template overrides (mirrors the plugin's own templates/ structure)
template-parts/             reusable template partials
docs/                       project docs (build plan, design notes)
```

Compiled `style.css` / `style-rtl.css` sit at the theme root because `node-sass` outputs there — this is intentional, not a mistake.

**Vendored third-party libraries** (e.g. `dist/js/swiper-bundle.min.js`, `dist/css/swiper-bundle.min.css`) are the exception to "never edit `dist/` directly" — there's no local source to compile them from; they're downloaded pre-built and committed as-is. To update one, re-download the same file from its CDN (e.g. `https://cdn.jsdelivr.net/npm/<package>@<version>/...`) and overwrite it — don't hand-edit it, and don't confuse it with theme build output.

## Conventions

- **Function/hook prefix**: `wawawewa_` for all custom functions (matches the theme's text domain). Follow this for any new function.
- **Text domain**: `wawawewa` — wrap all user-facing strings in `esc_html__()` / `esc_html_e()` etc. with this domain.
- **WooCommerce hooks**: add new WooCommerce customizations to `inc/woocommerce.php`, following the existing pattern of small, single-purpose hooked functions (see `wawawewa_woocommerce_header_cart()` etc.).
- **New SCSS**: add partials under the matching `sass/` subfolder (component vs. page vs. layout vs. `plugins/woocommerce/` for storefront-specific styles) and `@import` them from `sass/style.scss` — the single entry point for everything, including WooCommerce. Don't create new top-level Sass entry points. See the RTL / Hebrew section below for directional property rules (this matters on every new rule, not just RTL-specific work).
- **Security**: always escape output (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_*`) and use WordPress's built-in sanitization/nonce APIs for any form handling outside Gravity Forms.
- Reuse existing theme support / hooks already declared in `functions.php` and `inc/woocommerce.php` (custom-logo, product gallery, related products args, cart fragments, etc.) rather than re-implementing them.

## Responsive breakpoints

All screen-size breakpoints for the theme are centralized in [`sass/abstracts/variables/_breakpoints.scss`](sass/abstracts/variables/_breakpoints.scss) as a `$breakpoints` map, from `mobile-max` (360px, smallest supported width) up to `desktop-max` (1920px, largest supported width). It's imported globally via `sass/abstracts/_abstracts.scss`, so it's available in every SCSS partial without an extra `@import`.

- **Never hardcode a pixel value in a media query.** Always go through the `mq($name, $type: max)` mixin defined in that same file, e.g.:
  ```scss
  @include mq(tablet) { ... }        // max-width: 768px
  @include mq(tablet, min) { ... }   // min-width: 768px
  ```
- If a new breakpoint name is genuinely needed, add it to the `$breakpoints` map in `_breakpoints.scss` rather than writing a one-off `@media` query inline — keep this file as the single source of truth so every page/component stays consistent.
- Run `npm run lint:scss` after adding/editing breakpoints or any SCSS that consumes them.

## Commands

Run from this directory (`wawawewa/`).

```bash
npm run watch          # compile SCSS on change (dev)
npm run compile:css    # one-off compile + stylelint --fix
npm run compile:rtl    # regenerate style-rtl.css from style.css
npm run lint:scss      # stylelint on sass/**/*.scss
npm run lint:js        # eslint on js/*.js
```

For PHP, this theme has no Composer tooling — check syntax/style with `phpcs.xml.dist` (WordPress coding standards) using whatever PHPCS install is available in the environment (e.g. `phpcs --standard=phpcs.xml.dist .`).

Always run the relevant lint command after editing PHP, SCSS, or JS — this repo enforces `phpcs.xml.dist`, `.eslintrc`, and `.stylelintrc.json`, and CI/review will flag violations.

## Local development environment

There is no local WordPress install (no Local/Docker/MAMP config in this repo). The real workflow is **SFTP-to-staging**: `.vscode/sftp.json` (VS Code SFTP extension) uploads on save directly to the staging server at `ftp.wawawewa.co.il` (`wp-content/themes/wawawewa/`).

- **Security**: `.vscode/` is gitignored — keep it that way. Before committing, double-check `git status` doesn't show anything under `.vscode/`; SFTP credentials must never end up tracked (this has happened before under a misspelled folder name, so don't assume the gitignore rule alone is enough — verify).
- **Version targets**: PHP 8.1+ (WooCommerce's own minimum), latest stable WordPress, latest stable WooCommerce. Confirm the actual staging server versions and update this section once known — `readme.txt`'s `Requires PHP: 5.6` / `Tested up to: 5.4` are stale defaults inherited from the `_s` starter theme, not real requirements.
- **Verifying a change works**: save the file (SFTP auto-uploads) → reload the staging URL → manually walk the relevant page or flow. Run `npm run watch` during SCSS work so compiled CSS uploads alongside source changes.

## Git workflow

- Work on `aviv-dev`, merge to `main` when stable. No PR/review process currently — this is a solo-dev project.
- Commit messages: short and imperative, describing the actual change (e.g. "Add cart mini-widget", "Fix product grid spacing on mobile") — not placeholder messages like "Molcho" or "First push".
- No CI runs automatically on push. The lint commands above are the manual gate — run them before committing.
- **After finishing a task, stage the changed files (`git add`) and draft a commit message here in chat — do not run `git commit`.** The user reviews the staged changes and message and commits it themselves (via their own git client/IDE). This applies to every task unless the user explicitly asks for the commit to be made directly.

## Testing

No automated tests exist in this project (no `/tests` directory, no PHPUnit or Jest config). Don't go looking for a test suite — it isn't there. Verification is manual, per the Local development environment section above. If automated tests are added later, update this section with how to run them.

## ACF fields

Field groups must be exported to `acf-json/` (create at the theme root if it doesn't exist yet) and committed to git. This is what keeps fields in sync between your machine and staging instead of them existing only in one wp-admin database and silently "disappearing" on the other environment.

- **Always use `get_field()`, never `the_field()`.** `get_field()` returns the value so it can be escaped properly (`esc_html()`, `esc_url()`, etc.) before output; `the_field()` echoes raw, unescaped output directly and bypasses the theme's escaping convention (see Security in Conventions above). This applies everywhere a field is read, including the options page below.

- After adding or editing a field group in wp-admin, let ACF re-sync/export the JSON before considering the change done.
- Commit the resulting `acf-json/*.json` file alongside whatever PHP/template code uses the field — they're one logical change.
- **Hand-editing a field group JSON directly (no local WP install, so this is the normal workflow here) requires bumping its top-level `"modified"` key to a newer Unix timestamp** every time you change it. ACF's "Sync available" detection on the Field Groups list compares this value against the database record's last-modified time — without it (or with a stale value), ACF has nothing to compare and silently never offers a sync, even though the fields have genuinely changed. Get a fresh value with `date +%s` (Bash) and set it as the last key before the closing `}`. This bit us once already — don't skip it.
- **Editing a field group already in wp-admin's database**: after bumping `modified` and re-uploading, go to **ACF → Field Groups** (the list screen, not the individual editor) and use the **Sync** action to pull the JSON into the database. Do not open the field group and click **Save Changes** first — that pushes the (older) database version back out and can overwrite the JSON changes you just made.

### Global site settings (ACF options page)

Global/site-wide fields (things that aren't tied to a specific post/page — e.g. footer contact details, social links, global banners) belong on the ACF **options page**, registered in `inc/setup-functions/options-page.php` (`wawawewa_acf_options_page()`, hooked on `acf/init`, required from `functions.php`) via `acf_add_options_page()`. This requires **ACF Pro** (already assumed by this project for flexible content/repeaters — see the build plan).

- Admin menu label / page title: **הגדרות האתר** (Hebrew, matches the site's RTL-first convention) — `menu_slug` is `wawawewa-site-settings`.
- Any field group attached to this options page reads anywhere in templates via `get_field( $selector, 'option' )` — no post ID needed.
- Field groups for this page are exported to `acf-json/` exactly like any other field group (see above).
- Fields are organized into ACF **Tab** fields per site area — e.g. the `הדר` (header) tab currently holds `header_logo` (image field, read in `header.php` via `get_field( 'header_logo', 'option' )`, falling back to the default WA monogram SVG in `template-parts/brand/logo-mark.php` when no image is set). Add new tabs the same way as new global-settings areas come up (footer, contact info, etc.) rather than one flat field list.

### Flexible content page sections ("strips")

ACF-driven page templates (starting with the homepage, `page-templates/home-page.php`) build their body content from a **single ACF Flexible Content field** (e.g. `page_sections`), not one field group per section. Each layout in that field is one design section — a "strip" (Hero, Hero Image, Marquee, Best Sellers, Lookbook, Testimonials, About/Brand, FAQ, etc.).

- **`inc/flexible-strips.php`** holds every strip's render function, one per layout, using the `wawawewa_` prefix, e.g. `wawawewa_strip_hero( $layout )`, `wawawewa_strip_faq( $layout )`. Require this file from `functions.php` alongside the other `inc/` includes (`template-tags.php`, `template-functions.php`, etc.).
- The page template loops the flexible content field (`have_rows('page_sections')` / `get_field('page_sections')`) and dispatches each row's `acf_fc_layout` to the matching function in `flexible-strips.php` — don't hardcode section markup directly in the page template.
- Each strip's actual HTML lives in its own `template-parts/strips/{layout-name}.php` partial, called from the matching function in `flexible-strips.php` — keeps markup out of the dispatch file, consistent with the existing `template-parts/` convention (see `template-parts/brand/logo-mark.php`).
- The flexible content field group (covering all layouts) is exported as a single file under `acf-json/`, per the ACF fields convention above — not one field group per strip.
- **Adding a new strip** is always the same three-step pattern: add a layout to the flexible content field (re-synced to `acf-json/`), add a render function to `flexible-strips.php`, add a partial under `template-parts/strips/`.
- **Every layout must include a `strip_hidden` true/false field** (labelled "הסתר סקשן זה" — see the `hero`/`marquee` layouts for the exact field definition to copy). `wawawewa_render_strips()` in `flexible-strips.php` checks this centrally and skips rendering the row entirely when true — individual strip partials never need to check it themselves. This lets editors hide a section without deleting its content.

## Plugins

| Plugin | Status | Role |
|---|---|---|
| WooCommerce | Required | Commerce engine — cart, checkout, products, orders |
| ACF | Required | Structured/editable content (see `page-templates/home-page.php`) |
| Gravity Forms | Required | Non-WooCommerce forms (contact, inquiry, newsletter) |
| Yoast SEO | Decided | SEO |
| Jetpack | Inactive/optional | `inc/jetpack.php` scaffolding only; not actually in use |
| Payment gateway | TBD | Not yet decided — see `docs/store-build-plan.md` step 1 |

## Working notes

- No real branding, niche, or product catalog exists yet (see build plan, "Design direction" and step 5). Don't hardcode placeholder content as if it's final — keep it clearly swappable (ACF fields, placeholder product data) until the real catalog/branding is set.
- When adding WooCommerce template overrides, only override the specific template files that need theme-specific markup (place them in a `woocommerce/` folder at the theme root, mirroring WooCommerce's own `templates/` structure) — don't copy files wholesale if the defaults are fine.
