<?php
/**
 * The template for displaying product content in the single-product page,
 * rebuilt in the "Futuristic v2" direction.
 *
 * Overrides WooCommerce's default `templates/content-single-product.php` —
 * calls the same `woocommerce_template_single_*()` functions WooCommerce
 * itself uses (so title/rating/price/excerpt/variations-form/add-to-cart
 * all keep working exactly as WooCommerce intends, including AJAX add-to-cart
 * and the native variations form for variable products), just arranged in
 * our own two-column grid instead of WC's default stacked hook order.
 *
 * @package wawawewa
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( post_password_required() ) {
	echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}

$care_instructions = get_field( 'product_care_instructions' );
$shipping_returns   = get_field( 'product_shipping_returns_text', 'option' );
$trust_badges       = array_filter( array(
	get_field( 'product_trust_badge_1', 'option' ),
	get_field( 'product_trust_badge_2', 'option' ),
	get_field( 'product_trust_badge_3', 'option' ),
) );

$product_categories = get_the_terms( $product->get_id(), 'product_cat' );
$primary_category   = $product_categories && ! is_wp_error( $product_categories ) ? reset( $product_categories ) : null;

$accordions = array();

if ( $product->get_description() ) {
	$accordions[] = array(
		'title' => __( 'תיאור מלא', 'wawawewa' ),
		'body'  => wc_format_content( $product->get_description() ),
	);
}

if ( $shipping_returns ) {
	$accordions[] = array(
		'title' => __( 'משלוח והחזרות', 'wawawewa' ),
		'body'  => wpautop( esc_html( $shipping_returns ) ),
	);
}

if ( $care_instructions ) {
	$accordions[] = array(
		'title' => __( 'מידות וטיפוח', 'wawawewa' ),
		'body'  => wpautop( esc_html( $care_instructions ) ),
	);
}

$accordion_id = 'product-accordion-' . wp_unique_id();
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'single-product', $product ); ?>>

	<canvas class="particles-canvas" data-particles aria-hidden="true"></canvas>

	<?php do_action( 'woocommerce_before_single_product' ); ?>

	<div class="single-product__layout">
		<div class="single-product__gallery">
			<?php do_action( 'woocommerce_before_single_product_summary' ); ?>
		</div>

		<div class="single-product__summary summary entry-summary">
			<div class="single-product__stock-badge <?php echo $product->is_in_stock() ? 'is-in-stock' : 'is-out-of-stock'; ?>">
				<span class="single-product__stock-dot" aria-hidden="true"></span>
				<span>
					<?php echo $product->is_in_stock() ? esc_html__( '◆ במלאי', 'wawawewa' ) : esc_html__( '◆ אזל מהמלאי', 'wawawewa' ); ?>
				</span>
			</div>

			<?php if ( $primary_category ) : ?>
				<a class="single-product__category" href="<?php echo esc_url( get_term_link( $primary_category ) ); ?>">
					<?php echo esc_html( $primary_category->name ); ?>
				</a>
			<?php endif; ?>

			<?php woocommerce_template_single_title(); ?>
			<?php woocommerce_template_single_rating(); ?>
			<?php woocommerce_template_single_price(); ?>
			<?php woocommerce_template_single_excerpt(); ?>
			<?php woocommerce_template_single_add_to_cart(); ?>

			<?php if ( $trust_badges ) : ?>
				<div class="single-product__trust-badges">
					<?php foreach ( $trust_badges as $badge ) : ?>
						<div class="single-product__trust-badge">
							<div class="single-product__trust-badge-icon" aria-hidden="true">◆</div>
							<div><?php echo esc_html( $badge ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( $accordions ) : ?>
				<div class="accordion single-product__accordion" data-faq-accordion>
					<?php foreach ( $accordions as $index => $row ) :
						$row_id  = $accordion_id . '-' . $index;
						$is_open = 0 === $index;
						?>
						<div class="accordion__item<?php echo $is_open ? ' is-open' : ''; ?>">
							<button
								type="button"
								class="accordion__question"
								id="<?php echo esc_attr( $row_id . '-question' ); ?>"
								aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>"
								aria-controls="<?php echo esc_attr( $row_id . '-answer' ); ?>"
								data-faq-toggle
							>
								<span><?php echo esc_html( $row['title'] ); ?></span>
								<span class="accordion__sign" aria-hidden="true"></span>
							</button>
							<div
								class="accordion__answer"
								id="<?php echo esc_attr( $row_id . '-answer' ); ?>"
								role="region"
								aria-labelledby="<?php echo esc_attr( $row_id . '-question' ); ?>"
								<?php echo $is_open ? '' : 'hidden'; ?>
							>
								<?php echo wp_kses_post( $row['body'] ); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<?php woocommerce_output_related_products(); ?>

	<?php do_action( 'woocommerce_after_single_product' ); ?>
</div>
