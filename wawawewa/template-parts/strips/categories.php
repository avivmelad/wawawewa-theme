<?php

/**
 * Strip: Categories (Lookbook) — asymmetric 3-tile grid linking to real
 * WooCommerce product categories.
 *
 * Reads `category_1`/`category_2`/`category_3` (ACF taxonomy fields, product_cat
 * term IDs) from the current `page_sections` flexible content row — see
 * acf-json/group_wawawewa_home_page_sections.json.
 *
 * @package wawawewa
 */

if (! class_exists('WooCommerce')) {
	return;
}

$eyebrow = get_sub_field('categories_eyebrow');
$heading = get_sub_field('categories_heading');

$term_ids = array_filter(array(
	get_sub_field('category_1'),
	get_sub_field('category_2'),
	get_sub_field('category_3'),
));

if (! $term_ids) {
	return;
}
?>
<section class="strip-categories">
	<?php if ($eyebrow || $heading) : ?>
		<div class="strip-categories__heading" data-reveal>
			<?php if ($eyebrow) : ?>
				<div class="strip-categories__eyebrow"><?php echo esc_html($eyebrow); ?></div>
			<?php endif; ?>

			<?php if ($heading) : ?>
				<h2 class="strip-categories__title"><?php echo esc_html($heading); ?></h2>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="strip-categories__grid">
		<?php foreach ($term_ids as $term_id) :
			$term = get_term($term_id, 'product_cat');

			if (! $term || is_wp_error($term)) {
				continue;
			}

			$thumbnail_id = get_term_meta($term_id, 'thumbnail_id', true);
			$image_url    = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, 'large') : wc_placeholder_img_src('large');
			?>
			<a class="strip-categories__item" href="<?php echo esc_url(get_term_link($term)); ?>" data-reveal>
				<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($term->name); ?>" />
				<span class="strip-categories__fade" aria-hidden="true"></span>
				<span class="strip-categories__label"><?php echo esc_html($term->name); ?></span>
			</a>
		<?php endforeach; ?>
	</div>
</section>
