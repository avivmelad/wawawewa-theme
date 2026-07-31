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

$image   = get_sub_field('about_image');
$eyebrow = get_sub_field('about_eyebrow');
$heading = get_sub_field('about_heading');
$body    = get_sub_field('about_body');
$link    = get_sub_field('about_link');

if (! $image && ! $heading && ! $body) {
	return;
}
?>
<section class="strip-about" data-reveal>
	<?php if ($image) : ?>
		<div class="strip-about__image">
			<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
		</div>
	<?php endif; ?>

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
