# Current mission: Homepage — "Futuristic" redesign

Temporary scratch file — delete once the homepage-sections mission is fully done (see CLAUDE.md "Current mission tracking").

## Goal
Rework the homepage (and site-wide header) from the plain Black & Gold layout into the "Futuristic" direction — same palette, new interaction language — per `docs/store-build-plan.md` → "Design evolution". Desktop done, mobile pass for Hero + header now done too.

## Decisions made
- Custom cursor (mockup's `cursor:none` + ring/dot follower): **skipped**, kept the native cursor (UX/accessibility tradeoff).
- Site-wide header restyle: **yes** — gradient wordmark, translucent sticky background, JetBrains Mono drawer label all apply everywhere, not just the homepage.
- Build scope so far: **Hero + site-wide header + shared infrastructure only** (particle canvas, scroll-reveal utility), desktop and mobile. Marquee, best sellers, categories/lookbook, testimonials, about, FAQ are still pending — separate future missions, same visual language (both breakpoints).

## Steps
- [x] Added JetBrains Mono font (`inc/setup-functions/enqueue.php`) + `$font__mono` (`sass/abstracts/variables/_typography.scss`)
- [x] Added gold gradient color tokens (`$color__brand-gold-light`/`-dark`, `sass/abstracts/variables/_colors.scss`)
- [x] Header: gradient-text wordmark, translucent sticky background, re-added drawer footer label as "SYS.MENU // 2026" in mono (`header.php`, `sass/components/header/_header.scss`)
- [x] Global `::selection` gold highlight (`sass/base/elements/_body.scss`)
- [x] Reusable scroll-reveal utility: `[data-reveal]` + `js/reveal.js` + `sass/utilities/_reveal.scss` — enqueued site-wide, safe no-op where unused
- [x] Particle-network canvas (`js/particles.js`, `.homepage-particles` in `page-templates/home-page.php`) — homepage-only, skipped under `prefers-reduced-motion`
- [x] Hero rebuilt: corner brackets, pulsing-dot badge (reuses existing eyebrow field), heading now supports `<br>`/`<span class="hl">` highlight (field type changed text→textarea, output via `wp_kses_post`), magnetic CTA buttons (`js/hero-interactions.js`), subtle hero parallax, image gradient-fade + optional badge field (`hero_image_badge`)
- [x] Fixed horizontal-scroll bug from the hero parallax transform (`overflow-x: hidden` on `body`)
- [x] Mobile pass, matching "Homepage Futuristic Mobile": drawer nav goes full-width edge-to-edge below the `mobile` breakpoint (was fixed 340px); hero corner brackets/badge/logo/heading/image-badge all scaled down at `mobile`; universal tap-feedback (`.button:active { transform: scale(0.97) }`); also converted a legacy hardcoded `37.5em` header media query to `mq(tablet-small)` while in the file
- [ ] Fill in real Hero content (including highlight markup) in wp-admin and verify on staging — RTL first, then desktop, then mobile
- [ ] Next section to redesign in this direction (marquee is next in the design's top-to-bottom order)

- [x] Explicitly disabled hero parallax, magnetic-button drag, and button tap-scale below the `mobile` breakpoint (480px) — user found the movement effects unwanted on mobile even though they were expected to no-op there; `js/hero-interactions.js` now bails out entirely under `(max-width: 480px)`, and `.button:active` scale in `sass/components/buttons/_buttons.scss` is wrapped in `@include mq(mobile, min)`

## Notes
- Old single `page_header` ACF field on the homepage is superseded by the `page_sections` flexible content field — no longer read anywhere.
- Particle count (46) is unchanged for mobile (still ambient background, not a "moving button/screen" effect — left alone).
- Both desktop (`Homepage Futuristic.dc.html`) and mobile (`Homepage Futuristic Mobile.dc.html`) mockups in the Claude Design project (`עיצוב חנות אינטרנטית`, id `6e15106a-a49d-45e9-85cb-b7e220f17f7e`) cover every remaining section — marquee, best sellers, categories, testimonials, about, FAQ, newsletter/footer — not just Hero. When starting each of those as its own future mission, pull both files for that section (desktop + mobile) rather than desktop-only, so the mobile pass happens in the same mission instead of a separate follow-up.
