/**
 * File mini-cart.js.
 *
 * Toggles the header mini-cart dropdown (button, outside click, Escape key).
 */
( function() {
	const wrapper = document.querySelector( '[data-mini-cart]' );
	const toggle = document.querySelector( '[data-mini-cart-toggle]' );
	const panel = document.querySelector( '[data-mini-cart-panel]' );

	if ( ! wrapper || ! toggle || ! panel ) {
		return;
	}

	function closeMiniCart() {
		wrapper.classList.remove( 'is-open' );
		toggle.setAttribute( 'aria-expanded', 'false' );
	}

	function toggleMiniCart() {
		const isOpen = wrapper.classList.toggle( 'is-open' );
		toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
	}

	toggle.addEventListener( 'click', function( event ) {
		event.preventDefault();
		toggleMiniCart();
	} );

	document.addEventListener( 'click', function( event ) {
		if ( wrapper.classList.contains( 'is-open' ) && ! wrapper.contains( event.target ) ) {
			closeMiniCart();
		}
	} );

	document.addEventListener( 'keydown', function( event ) {
		if ( 'Escape' === event.key && wrapper.classList.contains( 'is-open' ) ) {
			closeMiniCart();
		}
	} );
}() );
