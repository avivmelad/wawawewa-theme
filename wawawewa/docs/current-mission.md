# Current mission: Homepage — first section (Hero)

Temporary scratch file — delete once the homepage-sections mission is fully done (see CLAUDE.md "Current mission tracking").

## Goal
Build the homepage using the ACF Flexible Content "strips" architecture (see CLAUDE.md), starting with the Hero section.

## Steps
- [x] `page_sections` flexible content field group + `hero` layout (optional logo image, eyebrow, heading, subcopy, 2 CTAs as ACF Link fields) — `acf-json/group_wawawewa_home_page_sections.json`
- [x] Hero media radio choice (photo / uploaded video / YouTube), each with its own conditionally-shown ACF field (`hero_image`, `hero_video_file`, `hero_video_youtube`)
- [x] `inc/flexible-strips.php` dispatcher (`wawawewa_render_strips()`) + required from `functions.php`
- [x] `template-parts/strips/hero.php` partial
- [x] Reusable pill `.button`/`.button--primary`/`.button--secondary` component (`sass/components/buttons/_buttons.scss`)
- [x] Hero styling (`sass/pages/_home-page.scss`)
- [x] Hero mobile-responsive pass, matching the "Homepage Wireframes Mobile" design (stacked full-width CTAs, inset+rounded image instead of edge-to-edge, below the `mobile` breakpoint)
- [x] `page-templates/home-page.php` rebuilt to call the dispatcher; fixed stray `@package RAD` comment
- [ ] Fill in real hero content in wp-admin and verify on staging (RTL check first, then mobile)
- [ ] Next section to build after this one?

## Notes
- Old single `page_header` ACF field on the homepage is superseded by the `page_sections` flexible content field — no longer read anywhere.
- Full mobile mockup for the whole homepage (marquee, best sellers, categories/lookbook, testimonials, about, FAQ) was pulled from the Claude Design project (`עיצוב חנות אינטרנטית`, `Homepage Wireframes Mobile.dc.html`) but only used for Hero so far — reference it again when building each remaining section, both desktop and mobile.
