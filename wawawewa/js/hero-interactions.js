/**
 * File hero-interactions.js.
 *
 * Small decorative interactions for the homepage Hero strip: magnetic
 * buttons (`[data-magnet]`) and a subtle mouse-parallax on the hero
 * section itself (`[data-parallax]`). Skipped under prefers-reduced-motion
 * and below the `mobile` breakpoint (480px, see sass/abstracts/variables/_breakpoints.scss)
 * — these are mouse-hover effects that don't belong on touch/mobile.
 */
( function() {
	if (
		window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ||
		window.matchMedia( '(max-width: 480px)' ).matches
	) {
		return;
	}

	document.querySelectorAll( '[data-magnet]' ).forEach( function( el ) {
		el.addEventListener( 'mousemove', function( event ) {
			const rect = el.getBoundingClientRect();
			const x = ( event.clientX - rect.left - rect.width / 2 ) * 0.35;
			const y = ( event.clientY - rect.top - rect.height / 2 ) * 0.35;
			el.style.transform = 'translate(' + x + 'px,' + y + 'px)';
		} );

		el.addEventListener( 'mouseleave', function() {
			el.style.transform = 'translate(0,0)';
		} );
	} );

	const hero = document.querySelector( '[data-parallax]' );

	if ( hero ) {
		document.addEventListener( 'mousemove', function( event ) {
			const rect = hero.getBoundingClientRect();
			const relX = ( event.clientX - rect.left ) / rect.width - 0.5;
			const relY = ( event.clientY - rect.top ) / rect.height - 0.5;
			hero.style.transform = 'translate(' + ( relX * -8 ) + 'px,' + ( relY * -8 ) + 'px)';
		} );
	}
}() );
