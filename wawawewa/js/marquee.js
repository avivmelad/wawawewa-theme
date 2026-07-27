/**
 * File marquee.js.
 *
 * Continuous auto-scrolling ticker for the homepage Marquee strip, built on
 * Swiper (dist/js/swiper-bundle.min.js) in loop mode — Swiper handles RTL
 * and seamless looping natively, regardless of how many phrases are entered
 * (unlike a hand-rolled CSS keyframe animation, which broke on both counts).
 */
document.addEventListener( 'DOMContentLoaded', function() {
	const el = document.querySelector( '.marquee-swiper' );

	if ( ! el || typeof Swiper === 'undefined' ) {
		return;
	}

	const reduceMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	const isMobile = window.matchMedia( '(max-width: 480px)' ).matches;

	new Swiper( el, {
		loop: true,
		loopAdditionalSlides: 6,
		slidesPerView: 'auto',
		spaceBetween: isMobile ? 56 : 96,
		allowTouchMove: false,
		speed: isMobile ? 22000 : 30000,
		// freeMode is required for the continuous-ticker trick: without it,
		// Swiper tries to snap autoplay transitions to discrete slide
		// positions, which don't line up cleanly with slidesPerView: 'auto'
		// and can stall the animation entirely.
		freeMode: {
			enabled: true,
			momentum: false,
		},
		// delay must be > 0 — Swiper's autoplay module treats a falsy delay
		// (including 0) as "not configured" and silently never starts.
		autoplay: reduceMotion ? false : {
			delay: 1,
			disableOnInteraction: true,
			pauseOnMouseEnter: false,
		},
	} );
} );
