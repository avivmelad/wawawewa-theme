<?php

/**
 * Strip: About / brand — split image + copy panel.
 *
 * Reads sub fields from the current `page_sections` flexible content row
 * (about layout) — see acf-json/group_wawawewa_home_page_sections.json.
 * The copy side is a dark "chrome" panel per the design, matching the
 * drawer nav / mini-cart / newsletter band treatment.
 *
 * @package wawawewa
 */

$image      = get_sub_field('about_image');
$image_side = get_sub_field('about_image_side');
$eyebrow    = get_sub_field('about_eyebrow');
$heading    = get_sub_field('about_heading');
$body       = get_sub_field('about_body');
$link       = get_sub_field('about_link');

if (! $image && ! $heading && ! $body) {
	return;
}

// Same fallback as the Categories strip: no custom image set yet shouldn't
// leave the section empty — fall back to WooCommerce's own placeholder image.
$image_url = $image ? $image['url'] : wc_placeholder_img_src('large');
$image_alt = $image ? $image['alt'] : ($heading ? $heading : get_bloginfo('name'));

$strip_class = 'strip-about';

if ('end' === $image_side) {
	$strip_class .= ' strip-about--image-end';
}
?>
<section class="<?php echo esc_attr($strip_class); ?>" data-reveal>
	<div class="strip-about__image">
		<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" />
	</div>

	<div class="strip-about__copy">
		<?php if ($eyebrow) : ?>
			<div class="strip-about__eyebrow"><?php echo esc_html($eyebrow); ?></div>
		<?php endif; ?>

		<?php if ($heading) : ?>
			<h2 class="strip-about__heading"><?php echo esc_html($heading); ?></h2>
		<?php endif; ?>

		<?php if ($body) : ?>
			<p class="strip-about__body"><?php echo esc_html($body); ?></p>
		<?php endif; ?>

		<?php if ($link) : ?>
			<a class="strip-about__link" href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target'] ? $link['target'] : '_self'); ?>">
				<?php echo esc_html($link['title']); ?> ←
			</a>
		<?php endif; ?>
	</div>
</section>
