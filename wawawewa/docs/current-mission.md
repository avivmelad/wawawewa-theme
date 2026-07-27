# Current mission: Header

Temporary scratch file — delete once the header mission is fully done (see CLAUDE.md "Current mission tracking").

## Goal
Finish the site-wide header: ACF-editable logo, cleaned-up placeholder content, sticky behavior.

## Steps
- [x] Add ACF options page ("הגדרות האתר") with a "הדר" tab + `header_logo` image field
- [x] Wire `header.php` to read `header_logo` via `get_field(..., 'option')`, falling back to the WA monogram SVG
- [x] Remove "קולקציית 2026" placeholder text from the drawer nav
- [x] Fix sticky-footer gap on short pages (unrelated but done in this stretch of work)
- [x] Make the header sticky (`position: sticky`, solid background, `z-index`)
- [x] Cart icon opens a mini-cart dropdown (WooCommerce `WC_Widget_Cart` widget, items/empty state, view cart + checkout links) via `js/mini-cart.js`
- [ ] Upload the real logo in wp-admin (currently still falls back to the placeholder SVG)
- [ ] Anything else needed on the header before calling this mission done?

## Notes
- No other header work requested yet — ask before closing out/deleting this file.
