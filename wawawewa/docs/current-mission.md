# Current mission: Homepage — "Futuristic" redesign (desktop)

Temporary scratch file — delete once the homepage-sections mission is fully done (see CLAUDE.md "Current mission tracking").

## Goal
Rework the homepage (and site-wide header) from the plain Black & Gold layout into the "Futuristic" direction — same palette, new interaction language — per `docs/store-build-plan.md` → "Design evolution". Desktop only for now.

## Decisions made
- Custom cursor (mockup's `cursor:none` + ring/dot follower): **skipped**, kept the native cursor (UX/accessibility tradeoff).
- Site-wide header restyle: **yes** — gradient wordmark, translucent sticky background, JetBrains Mono drawer label all apply everywhere, not just the homepage.
- Build scope for this pass: **Hero + site-wide header + shared infrastructure only** (particle canvas, scroll-reveal utility). Marquee, best sellers, categories/lookbook, testimonials, about, FAQ are still pending — separate future missions, same visual language.

## Steps
- [x] Added JetBrains Mono font (`inc/setup-functions/enqueue.php`) + `$font__mono` (`sass/abstracts/variables/_typography.scss`)
- [x] Added gold gradient color tokens (`$color__brand-gold-light`/`-dark`, `sass/abstracts/variables/_colors.scss`)
- [x] Header: gradient-text wordmark, translucent sticky background, re-added drawer footer label as "SYS.MENU // 2026" in mono (`header.php`, `sass/components/header/_header.scss`)
- [x] Global `::selection` gold highlight (`sass/base/elements/_body.scss`)
- [x] Reusable scroll-reveal utility: `[data-reveal]` + `js/reveal.js` + `sass/utilities/_reveal.scss` — enqueued site-wide, safe no-op where unused
- [x] Particle-network canvas (`js/particles.js`, `.homepage-particles` in `page-templates/home-page.php`) — homepage-only, skipped under `prefers-reduced-motion`
- [x] Hero rebuilt: corner brackets, pulsing-dot badge (reuses existing eyebrow field), heading now supports `<br>`/`<span class="hl">` highlight (field type changed text→textarea, output via `wp_kses_post`), magnetic CTA buttons (`js/hero-interactions.js`), subtle hero parallax, image gradient-fade + optional badge field (`hero_image_badge`)
- [ ] Fill in real Hero content (including highlight markup) in wp-admin and verify on staging — desktop first
- [ ] Next section to redesign in this direction (marquee is next in the design's top-to-bottom order)

## Notes
- Old single `page_header` ACF field on the homepage is superseded by the `page_sections` flexible content field — no longer read anywhere.
- Mobile pass for this new design not done yet — previous mobile work (docs history) was against the old plain Hero layout and will need revisiting once this direction is confirmed.
