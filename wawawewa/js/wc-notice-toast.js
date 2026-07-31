/**
 * File wc-notice-toast.js.
 *
 * Turns WooCommerce's "added to cart" success notice (`.woocommerce-message`,
 * rendered by the theme as a small fixed top-center toast — see
 * sass/plugins/woocommerce/_components.scss) into a brief fade-in/fade-out
 * instead of a static banner: it's just a passing confirmation, not
 * something the shopper needs to dismiss or act on. Error/info notices are
 * untouched — those stay on screen until read/acted on.
 */
( function() {
	const notice = document.querySelector( '.woocommerce-message' );

	if ( ! notice ) {
		return;
	}

	requestAnimationFrame( function() {
		notice.classList.add( 'is-visible' );
	} );

	setTimeout( function() {
		notice.classList.remove( 'is-visible' );
	}, 1000 );
}() );
