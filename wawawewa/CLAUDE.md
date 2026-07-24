# wawawewa — WordPress/WooCommerce Theme

## What this is

A WordPress theme for the `wawawewa` online store, built on the `_s` ("underscores") starter theme with WooCommerce support wired in. It is the front-end theme only — product/order data lives in WooCommerce (a plugin), not in this repo.

The full build plan and roadmap live in [`docs/store-build-plan.md`](docs/store-build-plan.md) — read it before starting new work to see what stage the project is at and what's next. Keep it updated as milestones are completed or the plan changes.

## Current status

Niche and visual identity are now decided: home goods/décor, "Black & Gold" luxury direction, Hebrew (RTL) first. A high-fidelity homepage design has been delivered; header and footer are implemented site-wide, homepage content sections and ACF fields are not yet built. See the "Implementation status" checkpoint under Design direction in [`docs/store-build-plan.md`](docs/store-build-plan.md) for exactly what's done and what's left. Ask to resume "the homepage design implementation" to continue.

## Stack

- **WordPress theme**, PHP. Write modern PHP consistent with the existing codebase.
- **WooCommerce** for all commerce logic (cart, checkout, products, orders). Never duplicate what WooCommerce already provides — hook into it via `inc/woocommerce.php`.
- **SCSS** compiled with `node-sass` → CSS at the theme root (`style.css`, `woocommerce.css`, `style-rtl.css`). Never hand-edit the compiled `.css` files directly — edit the `sass/` source.
- **ACF (Advanced Custom Fields)** for structured/editable content (see `page-templates/home-page.php` for the existing pattern).
- **Gravity Forms** for any non-WooCommerce forms (contact, inquiry, newsletter). Don't hand-roll form handling that Gravity Forms already covers.
- **Yoast SEO** for SEO (decided). Payment gateway is not yet decided — see `docs/store-build-plan.md` step 1.
- **Jetpack** (`inc/jetpack.php`) is unused, leftover `_s` starter-theme scaffolding — it only activates if the Jetpack plugin happens to be installed. Not part of the required plugin stack; don't build new features assuming it's active.
- Custom Post Types / taxonomies are added only when a concrete content need appears — not speculatively (see build plan for rationale).

## RTL / Hebrew

The site launches in **Hebrew first** — RTL is the primary, default direction, not a secondary concern to bolt on later. Build and test every new page/component with RTL as the expected default.

- `header.php` already calls `language_attributes()`, which correctly outputs `dir="rtl"` automatically when the site's language is Hebrew — no change needed there.
- **Styling workflow**: SCSS is authored LTR-first (current convention — kept as-is per team decision), and `npm run compile:rtl` (rtlcss) generates the RTL stylesheet. WordPress auto-swaps it in via `wp_style_add_data( 'wawawewa-style', 'rtl', 'replace' )` in `inc/setup-functions/enqueue.php` (this was recently fixed — it previously pointed at a style handle that was never registered, so the RTL swap silently never fired).
- **Known gap — needs a build step before the RTL swap actually works**: the theme enqueues `dist/css/style.min.css`, but `npm run compile:rtl` currently runs rtlcss against the root-level `style.css` and outputs `style-rtl.css` at the theme root — a file WordPress never loads for the frontend. Someone needs to add a step that runs rtlcss against `dist/css/style.min.css` to produce `dist/css/style-rtl.min.css` instead (whatever currently compiles that dist file — see `.vscode/settings.json`'s Live Sass Compile config). Until that exists, don't assume the automatic RTL stylesheet swap is doing anything in production.
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
  utilities/                accessibility, alignment helpers
  woocommerce.scss          WooCommerce-specific overrides
  style.scss                entry point, imports the above
js/                         source JS (customizer.js, navigation.js)
dist/                       compiled build output — never edit directly
page-templates/             custom page templates (e.g. home-page.php, ACF-driven)
template-parts/             reusable template partials
docs/                       project docs (build plan, design notes)
```

Compiled `style.css` / `woocommerce.css` / `style-rtl.css` sit at the theme root because `node-sass` outputs there — this is intentional, not a mistake.

## Conventions

- **Function/hook prefix**: `wawawewa_` for all custom functions (matches the theme's text domain). Follow this for any new function.
- **Text domain**: `wawawewa` — wrap all user-facing strings in `esc_html__()` / `esc_html_e()` etc. with this domain.
- **WooCommerce hooks**: add new WooCommerce customizations to `inc/woocommerce.php`, following the existing pattern of small, single-purpose hooked functions (see `wawawewa_woocommerce_header_cart()` etc.).
- **New SCSS**: add partials under the matching `sass/` subfolder (component vs. page vs. layout) and `@import` them from `sass/style.scss` (or `sass/woocommerce.scss` for storefront-specific styles) — don't create new top-level Sass entry points. See the RTL / Hebrew section below for directional property rules (this matters on every new rule, not just RTL-specific work).
- **Security**: always escape output (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_*`) and use WordPress's built-in sanitization/nonce APIs for any form handling outside Gravity Forms.
- Reuse existing theme support / hooks already declared in `functions.php` and `inc/woocommerce.php` (custom-logo, product gallery, related products args, cart fragments, etc.) rather than re-implementing them.

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

## Testing

No automated tests exist in this project (no `/tests` directory, no PHPUnit or Jest config). Don't go looking for a test suite — it isn't there. Verification is manual, per the Local development environment section above. If automated tests are added later, update this section with how to run them.

## ACF fields

Field groups must be exported to `acf-json/` (create at the theme root if it doesn't exist yet) and committed to git. This is what keeps fields in sync between your machine and staging instead of them existing only in one wp-admin database and silently "disappearing" on the other environment.

- After adding or editing a field group in wp-admin, let ACF re-sync/export the JSON before considering the change done.
- Commit the resulting `acf-json/*.json` file alongside whatever PHP/template code uses the field — they're one logical change.

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
