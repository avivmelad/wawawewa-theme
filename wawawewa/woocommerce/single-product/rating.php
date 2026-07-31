<?php
/**
 * Single product rating — overrides WooCommerce's default
 * `templates/single-product/rating.php`.
 *
 * Plain ★/☆ glyphs + review count, matching the Futuristic v2 design,
 * instead of WooCommerce's default icon-font star-rating widget. Uses real
 * `get_average_rating()`/`get_review_count()` — unlike the homepage
 * Testimonials strip's hardcoded 5 stars (which has no real rating data
 * behind it), this is genuine review data, so it's rounded to the nearest
 * whole star rather than always shown as full.
 *
 * @package wawawewa
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! wc_review_ratings_enabled() ) {
	return;
}

$rating_count = $product->get_rating_count();

if ( ! $rating_count ) {
	return;
}

$average = $product->get_average_rating();
$rounded = round( $average );
$stars   = str_repeat( '★', $rounded ) . str_repeat( '☆', 5 - $rounded );
?>
<div class="single-product__rating">
	<span class="single-product__rating-stars"><?php echo esc_html( $stars ); ?></span>
	<span class="single-product__rating-count">
		<?php
		printf(
			/* translators: %s: number of reviews. */
			esc_html( _n( '(%s ביקורת)', '(%s ביקורות)', $rating_count, 'wawawewa' ) ),
			esc_html( $rating_count )
		);
		?>
	</span>
</div>
