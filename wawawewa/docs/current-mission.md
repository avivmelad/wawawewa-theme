# Current mission: Homepage — "Futuristic" redesign

Temporary scratch file — delete once the homepage-sections mission is fully done (see CLAUDE.md "Current mission tracking").

## Goal
Rework the homepage (and site-wide header) from the plain Black & Gold layout into the "Futuristic" direction — same palette, new interaction language — per `docs/store-build-plan.md` → "Design evolution".

## Decisions made
- Custom cursor (mockup's `cursor:none` + ring/dot follower): **skipped**, kept the native cursor (UX/accessibility tradeoff).
- Site-wide header restyle: **yes** — gradient wordmark, translucent sticky background, JetBrains Mono drawer label all apply everywhere, not just the homepage.
- Moving/interactive effects (hero parallax, magnetic buttons, button tap-scale): desktop/tablet only — explicitly disabled below the `mobile` breakpoint (480px) per user request, even though most would have no-op'd anyway on touch.
- Sections are being built one at a time, desktop + mobile together per section, in the design's top-to-bottom order: Hero → Marquee → Best sellers → Categories/Lookbook → Testimonials → About → FAQ.

## Steps
- [x] Added JetBrains Mono font (`inc/setup-functions/enqueue.php`) + `$font__mono` (`sass/abstracts/variables/_typography.scss`)
- [x] Added gold gradient color tokens (`$color__brand-gold-light`/`-dark`, `sass/abstracts/variables/_colors.scss`)
- [x] Header: gradient-text wordmark, translucent sticky background, re-added drawer footer label as "SYS.MENU // 2026" in mono (`header.php`, `sass/components/header/_header.scss`)
- [x] Header wordmark text/image ACF choice (`header_wordmark_type` + conditional fields on the site-settings options page)
- [x] Global `::selection` gold highlight (`sass/base/elements/_body.scss`)
- [x] Reusable scroll-reveal utility: `[data-reveal]` + `js/reveal.js` + `sass/utilities/_reveal.scss` — enqueued site-wide, safe no-op where unused
- [x] Particle-network canvas (`js/particles.js`, `.homepage-particles` in `page-templates/home-page.php`) — homepage-only, skipped under `prefers-reduced-motion`
- [x] Hero rebuilt: corner brackets, pulsing-dot badge (reuses existing eyebrow field), heading now supports `<br>`/`<span class="hl">` highlight (field type changed text→textarea, output via `wp_kses_post`), magnetic CTA buttons (`js/hero-interactions.js`), subtle hero parallax, image gradient-fade + optional badge field (`hero_image_badge`)
- [x] Fixed horizontal-scroll bug from the hero parallax transform (`overflow-x: hidden` on `body`)
- [x] Mobile pass for Hero + header, matching "Homepage Futuristic Mobile": drawer nav goes full-width edge-to-edge below `mobile` (was fixed 340px); hero corner brackets/badge/logo/heading/image-badge scaled down; header wordmark/logo shrink + `white-space: nowrap` to stop wrapping; converted a legacy hardcoded `37.5em` header media query to `mq(tablet-small)` while in the file
- [x] Explicitly disabled hero parallax, magnetic-button drag, and button tap-scale below the `mobile` breakpoint — `js/hero-interactions.js` bails out under `(max-width: 480px)`, `.button:active` scale wrapped in `@include mq(mobile, min)`
- [x] **Marquee strip — done and confirmed working on staging, desktop + mobile.** `marquee_items` repeater (one text per row, ✦ prefix via CSS). A hand-rolled CSS keyframe version (duplicate-track + `translateX(-50%)`) hit a real RTL box-model bug (the technique assumes LTR start-edge alignment) and was replaced with Swiper in continuous-scroll mode instead — vendored `dist/js/swiper-bundle.min.js` + `dist/css/swiper-bundle.min.css` (Swiper 11 from jsDelivr, no npm available here; see CLAUDE.md "Vendored third-party libraries"). `template-parts/strips/marquee.php` repeats the item list 3× server-side so loop mode always has enough real slides regardless of how few phrases are entered. Config in `js/marquee.js`: `loop: true`, `freeMode: { enabled: true, momentum: false }` (required or autoplay can stall), `autoplay: { delay: 1, disableOnInteraction: false }` (delay must be >0 — Swiper treats falsy delay as unconfigured). Clicking the slider itself still paused it even with `disableOnInteraction:false` — fixed with `pointer-events: none` on `.marquee-swiper` in `sass/pages/_home-page.scss` (it's decorative/`aria-hidden` anyway, so blocking clicks from ever reaching Swiper's listeners is correct, not just a workaround). Mobile: `.marquee-swiper` padding 16px→12px and `.strip-marquee__item` font-size 22px→16px below `mobile`, matching the mobile mockup exactly; `spaceBetween`/`speed` in `js/marquee.js` already branch on `isMobile` (96/160 spacing, 9000/11000 speed) and were tuned wider/faster than the mockup's own numbers per explicit request, at both breakpoints — nothing further needed here unless it looks off on a real device.
- [x] Added a `strip_hidden` true/false field ("הסתר סקשן זה") to every layout (`hero`, `marquee`) so editors can hide a section without deleting its content. Checked centrally in `wawawewa_render_strips()` (`inc/flexible-strips.php`) — individual strip partials never need to check it themselves. Documented as mandatory for every future layout in CLAUDE.md "Flexible content page sections".
- [ ] Fill in real Hero + Marquee content in wp-admin and verify on staging — RTL first, then desktop, then mobile
- [ ] Next section to build: Best sellers product grid

## Notes
- Old single `page_header` ACF field on the homepage is superseded by the `page_sections` flexible content field — no longer read anywhere.
- Particle count (46) is unchanged for mobile (still ambient background, not a "moving button/screen" effect — left alone).
- Both desktop (`Homepage Futuristic.dc.html`) and mobile (`Homepage Futuristic Mobile.dc.html`) mockups in the Claude Design project (`עיצוב חנות אינטרנטית`, id `6e15106a-a49d-45e9-85cb-b7e220f17f7e`) cover every remaining section — best sellers, categories, testimonials, about, FAQ, newsletter/footer. Pull both files for each as it's built.
