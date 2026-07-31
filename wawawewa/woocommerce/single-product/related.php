<?php
/**
 * Related products — overrides WooCommerce's default
 * `templates/single-product/related.php`.
 *
 * The query/algorithm is still 100% WooCommerce's own (`$related_products`,
 * `$args` passed in by `woocommerce_output_related_products()` — see
 * `woocommerce_output_related_products_args` filter in inc/woocommerce.php
 * for the 4-columns/4-posts count). Only the card markup is custom, reusing
 * the same `.product-card` component as the homepage Best-sellers strip
 * (sass/components/_product-card.scss) for a consistent look — no shine/
 * quick-view overlay from the mockup, since no quick-view modal exists;
 * `[data-tilt]` reuses the same desktop-only hover as Best-sellers instead.
 *
 * @package wawawewa
 */

defined( 'ABSPATH' ) || exit;

if ( ! $related_products ) {
	return;
}
?>
<section class="single-product__related-section">
	<div class="single-product__related-heading" data-reveal>
		<div class="single-product__related-eyebrow"><?php esc_html_e( '◆ YOU_MAY_ALSO_LIKE', 'wawawewa' ); ?></div>
		<h2 class="single-product__related-title"><?php esc_html_e( 'מוצרים דומים', 'wawawewa' ); ?></h2>
	</div>

	<div class="single-product__related-grid">
		<?php foreach ( $related_products as $related_product ) :
			$product_id = $related_product->get_id();
			?>
			<div class="product-card" data-reveal data-tilt>
				<a class="product-card__image" href="<?php echo esc_url( get_permalink( $product_id ) ); ?>">
					<?php echo $related_product->get_image( 'woocommerce_thumbnail' ); ?>
				</a>
				<div class="product-card__body">
					<a class="product-card__name" href="<?php echo esc_url( get_permalink( $product_id ) ); ?>">
						<?php echo esc_html( $related_product->get_name() ); ?>
					</a>
					<div class="product-card__price"><?php echo wp_kses_post( $related_product->get_price_html() ); ?></div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
