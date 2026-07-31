/**
 * File category-filters.js.
 *
 * Progressive enhancement for the category-page sidebar (`woocommerce/
 * archive-product.php`): auto-submits the filter `<form>` whenever a sort/
 * price/sub-category input changes, so every filter is a plain GET param
 * WooCommerce's own query already understands — no AJAX. Price options carry
 * `data-min`/`data-max` (there's no single `name` WooCommerce reads for a
 * discrete price bucket, only `min_price`/`max_price`), copied into the
 * form's hidden `min_price`/`max_price` fields before submitting.
 */
( function() {
	document.querySelectorAll( '[data-filter-form]' ).forEach( function( form ) {
		form.querySelectorAll( '[data-price-option]' ).forEach( function( input ) {
			input.addEventListener( 'change', function() {
				const minField = form.querySelector( '[name="min_price"]' );
				const maxField = form.querySelector( '[name="max_price"]' );

				if ( minField ) {
					minField.value = input.dataset.min || '';
				}
				if ( maxField ) {
					maxField.value = input.dataset.max || '';
				}
			} );
		} );

		form.querySelectorAll( 'input' ).forEach( function( input ) {
			input.addEventListener( 'change', function() {
				form.submit();
			} );
		} );
	} );
}() );
