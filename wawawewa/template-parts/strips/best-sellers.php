<?php

/**
 * Strip: Best sellers — hand-picked WooCommerce product grid.
 *
 * Reads `best_sellers_products` (ACF relationship field, product IDs) from
 * the current `page_sections` flexible content row — see
 * acf-json/group_wawawewa_home_page_sections.json.
 *
 * @package wawawewa
 */

if (! class_exists('WooCommerce')) {
	return;
}

$eyebrow     = get_sub_field('best_sellers_eyebrow');
$heading     = get_sub_field('best_sellers_heading');
$product_ids = get_sub_field('best_sellers_products');

if (! $product_ids) {
	return;
}
?>
<section class="strip-best-sellers">
	<?php if ($eyebrow || $heading) : ?>
		<div class="strip-best-sellers__heading" data-reveal>
			<?php if ($eyebrow) : ?>
				<div class="strip-best-sellers__eyebrow"><?php echo esc_html($eyebrow); ?></div>
			<?php endif; ?>

			<?php if ($heading) : ?>
				<h2 class="strip-best-sellers__title"><?php echo esc_html($heading); ?></h2>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="strip-best-sellers__grid">
		<?php
		global $product;
		$original_product = $product;

		foreach ($product_ids as $product_id) :
			$product = wc_get_product($product_id);

			if (! $product) {
				continue;
			}
			?>
			<div class="product-card" data-reveal data-tilt>
				<a class="product-card__image" href="<?php echo esc_url(get_permalink($product_id)); ?>">
					<?php echo $product->get_image('woocommerce_thumbnail'); ?>
				</a>
				<div class="product-card__body">
					<a class="product-card__name" href="<?php echo esc_url(get_permalink($product_id)); ?>">
						<?php echo esc_html($product->get_name()); ?>
					</a>
					<div class="product-card__footer">
						<div class="product-card__price"><?php echo wp_kses_post($product->get_price_html()); ?></div>
						<?php woocommerce_template_loop_add_to_cart(); ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
<?php
$product = $original_product;
