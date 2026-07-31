/**
 * File faq-accordion.js.
 *
 * Single-open accordion — used by the homepage FAQ strip and the single
 * product page's Description/Shipping/Care rows (`.accordion` component,
 * sass/components/_accordion.scss). Opening one row closes any other open
 * row within the same list. Toggles the native `hidden` attribute on the
 * answer (not a CSS transition) — simple and keeps closed answers out of
 * the accessibility tree for free.
 */
( function() {
	document.querySelectorAll( '[data-faq-accordion]' ).forEach( function( list ) {
		list.querySelectorAll( '[data-faq-toggle]' ).forEach( function( button ) {
			button.addEventListener( 'click', function() {
				const item = button.closest( '.accordion__item' );
				const answer = document.getElementById( button.getAttribute( 'aria-controls' ) );
				const isOpen = 'true' === button.getAttribute( 'aria-expanded' );

				list.querySelectorAll( '[data-faq-toggle]' ).forEach( function( otherButton ) {
					if ( otherButton === button ) {
						return;
					}

					otherButton.setAttribute( 'aria-expanded', 'false' );
					otherButton.closest( '.accordion__item' ).classList.remove( 'is-open' );
					document.getElementById( otherButton.getAttribute( 'aria-controls' ) ).hidden = true;
				} );

				button.setAttribute( 'aria-expanded', isOpen ? 'false' : 'true' );
				item.classList.toggle( 'is-open', ! isOpen );
				answer.hidden = isOpen;
			} );
		} );
	} );
}() );
