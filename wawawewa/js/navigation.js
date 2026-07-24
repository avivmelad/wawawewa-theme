/**
 * File navigation.js.
 *
 * Handles opening/closing the slide-out drawer navigation (hamburger button,
 * overlay, close button, outside click, and Escape key).
 */
( function() {
	const drawer = document.querySelector( '[data-drawer]' );
	const overlay = document.querySelector( '[data-drawer-overlay]' );
	const openButton = document.querySelector( '[data-drawer-open]' );
	const closeButton = document.querySelector( '[data-drawer-close]' );

	// Return early if the drawer markup doesn't exist on this page.
	if ( ! drawer || ! overlay || ! openButton ) {
		return;
	}

	function openDrawer() {
		drawer.classList.add( 'is-open' );
		overlay.classList.add( 'is-visible' );
		openButton.setAttribute( 'aria-expanded', 'true' );
	}

	function closeDrawer() {
		drawer.classList.remove( 'is-open' );
		overlay.classList.remove( 'is-visible' );
		openButton.setAttribute( 'aria-expanded', 'false' );
	}

	openButton.addEventListener( 'click', openDrawer );

	if ( closeButton ) {
		closeButton.addEventListener( 'click', closeDrawer );
	}

	overlay.addEventListener( 'click', closeDrawer );

	document.addEventListener( 'keydown', function( event ) {
		if ( 'Escape' === event.key && drawer.classList.contains( 'is-open' ) ) {
			closeDrawer();
		}
	} );
}() );
