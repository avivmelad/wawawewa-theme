/**
 * File product-quantity-stepper.js.
 *
 * Progressive enhancement only: wraps WooCommerce's native `.quantity`
 * number input with +/- buttons, matching the Futuristic v2 design. Reads
 * the input's own min/max/step attributes (already set correctly by
 * WooCommerce, e.g. from stock quantity) rather than assuming any values —
 * doesn't touch cart/variation logic at all, the underlying `name="quantity"`
 * input WooCommerce submits is untouched.
 */
( function() {
	document.querySelectorAll( '.quantity' ).forEach( function( wrapper ) {
		const input = wrapper.querySelector( 'input.qty' );

		if ( ! input || wrapper.dataset.stepperReady ) {
			return;
		}

		wrapper.dataset.stepperReady = 'true';

		function step( direction ) {
			const stepValue = parseFloat( input.step ) || 1;
			const min = input.min !== '' ? parseFloat( input.min ) : 1;
			const max = input.max !== '' ? parseFloat( input.max ) : Infinity;
			const current = parseFloat( input.value ) || min;
			const next = Math.min( max, Math.max( min, current + ( direction * stepValue ) ) );

			input.value = next;
			input.dispatchEvent( new Event( 'change', { bubbles: true } ) );
		}

		const decrease = document.createElement( 'button' );
		decrease.type = 'button';
		decrease.className = 'quantity__step quantity__step--down';
		decrease.setAttribute( 'aria-label', 'הפחת כמות' );
		decrease.textContent = '–';
		decrease.addEventListener( 'click', function() {
			step( -1 );
		} );

		const increase = document.createElement( 'button' );
		increase.type = 'button';
		increase.className = 'quantity__step quantity__step--up';
		increase.setAttribute( 'aria-label', 'הגדל כמות' );
		increase.textContent = '+';
		increase.addEventListener( 'click', function() {
			step( 1 );
		} );

		wrapper.insertBefore( decrease, input );
		wrapper.appendChild( increase );
	} );
}() );
