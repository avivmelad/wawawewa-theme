/**
 * File product-tilt.js.
 *
 * 3D cursor-tilt hover effect for product cards (`[data-tilt]`), used by the
 * homepage Best sellers strip. Skipped under prefers-reduced-motion and below
 * the `mobile` breakpoint (480px, see sass/abstracts/variables/_breakpoints.scss)
 * — same cutoff as js/hero-interactions.js, since this is a mouse-hover effect
 * that doesn't apply on touch/mobile.
 */
( function() {
	if (
		window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ||
		window.matchMedia( '(max-width: 480px)' ).matches
	) {
		return;
	}

	document.querySelectorAll( '[data-tilt]' ).forEach( function( card ) {
		const image = card.querySelector( 'img' );

		card.addEventListener( 'mousemove', function( event ) {
			const rect = card.getBoundingClientRect();
			const px = ( event.clientX - rect.left ) / rect.width - 0.5;
			const py = ( event.clientY - rect.top ) / rect.height - 0.5;

			card.style.transform = 'perspective(600px) rotateX(' + ( py * -7 ) + 'deg) rotateY(' + ( px * 7 ) + 'deg)';

			if ( image ) {
				image.style.transform = 'scale(1.08)';
			}
		} );

		card.addEventListener( 'mouseleave', function() {
			card.style.transform = '';

			if ( image ) {
				image.style.transform = '';
			}
		} );
	} );
}() );
