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
- [x] Marquee strip: `marquee_items` repeater (one text per row, ✦ prefix added via CSS), rendered twice for a seamless loop, paused under `prefers-reduced-motion`, mobile-scaled font/gap/duration (`template-parts/strips/marquee.php`, `inc/flexible-strips.php`, `sass/pages/_home-page.scss`)
- [x] Fixed a visible "jump" in the marquee loop: with only a few short phrases, each half of the track was narrower than the viewport, so the reset was visible. Each half now repeats the item list 4× internally (guarantees full-width coverage regardless of content length) — the genuine content is announced once via a hidden `<ul class="screen-reader-text">`, and the whole visual track is `aria-hidden`. Also widened the gap between phrases (48px→96px desktop, 32px→56px mobile) per request.
- [x] Attempted fix for the RTL "jump": forced `direction: ltr` on `.strip-marquee` — still didn't feel right per user feedback ("too fast", text still not looping cleanly).
- [x] **Replaced the hand-rolled CSS keyframe marquee with Swiper in continuous-scroll mode** (loop: true, autoplay + long linear speed, allowTouchMove: false) — Swiper handles RTL and seamless looping natively, which the CSS approach kept failing at. Vendored `dist/js/swiper-bundle.min.js` + `dist/css/swiper-bundle.min.css` (Swiper 11, downloaded from jsDelivr — no npm available in this environment; see CLAUDE.md "Vendored third-party libraries"). New `js/marquee.js` initializes it on `.marquee-swiper`, enqueued homepage-only. `template-parts/strips/marquee.php` now renders plain `swiper-slide` divs (no more manual 4× repeat hack) with spacing controlled via Swiper's `spaceBetween` option (96px desktop / 56px mobile) instead of CSS gap.
- [x] Fixed Swiper not moving at all: `autoplay: { delay: 0, ... }` — Swiper's autoplay module treats a falsy `delay` (0 counts) as unconfigured and never starts. Changed to `delay: 1`.
- [x] Still not moving after the delay fix — added the missing `freeMode: { enabled: true, momentum: false }` (required for the continuous-ticker trick; without it Swiper tries to snap autoplay transitions to discrete slide positions, which don't line up with `slidesPerView: 'auto'` and can stall entirely), and made slide count robust regardless of admin content by repeating `$items` 3× server-side in `template-parts/strips/marquee.php` (loop mode needs a healthy number of real slides or it can disable itself/have nothing to advance to)
- [ ] Fill in real Hero + Marquee content in wp-admin and verify on staging — RTL first, then desktop, then mobile
- [ ] Next section to build: Best sellers product grid

## Notes
- Old single `page_header` ACF field on the homepage is superseded by the `page_sections` flexible content field — no longer read anywhere.
- Particle count (46) is unchanged for mobile (still ambient background, not a "moving button/screen" effect — left alone).
- Both desktop (`Homepage Futuristic.dc.html`) and mobile (`Homepage Futuristic Mobile.dc.html`) mockups in the Claude Design project (`עיצוב חנות אינטרנטית`, id `6e15106a-a49d-45e9-85cb-b7e220f17f7e`) cover every remaining section — best sellers, categories, testimonials, about, FAQ, newsletter/footer. Pull both files for each as it's built.
