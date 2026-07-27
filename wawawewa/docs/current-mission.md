# Current mission: Homepage — first section (Hero)

Temporary scratch file — delete once the homepage-sections mission is fully done (see CLAUDE.md "Current mission tracking").

## Goal
Build the homepage using the ACF Flexible Content "strips" architecture (see CLAUDE.md), starting with the Hero section.

## Steps
- [x] `page_sections` flexible content field group + `hero` layout (eyebrow, heading, subcopy, 2 CTAs, full-width image) — `acf-json/group_wawawewa_home_page_sections.json`
- [x] `inc/flexible-strips.php` dispatcher (`wawawewa_render_strips()`) + required from `functions.php`
- [x] `template-parts/strips/hero.php` partial
- [x] Reusable pill `.button`/`.button--primary`/`.button--secondary` component (`sass/components/buttons/_buttons.scss`)
- [x] Hero styling (`sass/pages/_home-page.scss`)
- [x] `page-templates/home-page.php` rebuilt to call the dispatcher; fixed stray `@package RAD` comment
- [ ] Fill in real hero content in wp-admin and verify on staging (RTL check first)
- [ ] Next section to build after this one?

## Notes
- Old single `page_header` ACF field on the homepage is superseded by the `page_sections` flexible content field — no longer read anywhere.
