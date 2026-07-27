/**
 * File reveal.js.
 *
 * Fades/slides elements in once they scroll into view. Pair any element
 * with the `data-reveal` attribute (see sass/utilities/_reveal.scss) —
 * reusable across sections, not just the homepage.
 */
( function() {
	const elements = document.querySelectorAll( '[data-reveal]' );

	if ( ! elements.length ) {
		return;
	}

	if ( ! window.IntersectionObserver || window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		elements.forEach( function( el ) {
			el.classList.add( 'is-visible' );
		} );
		return;
	}

	const observer = new IntersectionObserver( function( entries ) {
		entries.forEach( function( entry ) {
			if ( entry.isIntersecting ) {
				entry.target.classList.add( 'is-visible' );
				observer.unobserve( entry.target );
			}
		} );
	}, { threshold: 0.15 } );

	elements.forEach( function( el ) {
		observer.observe( el );
	} );
}() );
