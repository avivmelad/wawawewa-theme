<?php

/**
 * Strip: Hero.
 *
 * Reads sub fields from the current `page_sections` flexible content row
 * (hero layout) — see acf-json/group_wawawewa_home_page_sections.json.
 *
 * @package wawawewa
 */

$eyebrow             = get_sub_field('hero_eyebrow');
$heading             = get_sub_field('hero_heading');
$subcopy             = get_sub_field('hero_subcopy');
$cta_primary_label   = get_sub_field('hero_cta_primary_label');
$cta_primary_url     = get_sub_field('hero_cta_primary_url');
$cta_secondary_label = get_sub_field('hero_cta_secondary_label');
$cta_secondary_url   = get_sub_field('hero_cta_secondary_url');
$image               = get_sub_field('hero_image');
?>
<section class="strip-hero">
	<div class="strip-hero__inner">
		<?php if ($eyebrow) : ?>
			<span class="strip-hero__eyebrow"><?php echo esc_html($eyebrow); ?></span>
		<?php endif; ?>

		<?php if ($heading) : ?>
			<h1 class="strip-hero__heading"><?php echo esc_html($heading); ?></h1>
		<?php endif; ?>

		<?php if ($subcopy) : ?>
			<p class="strip-hero__subcopy"><?php echo esc_html($subcopy); ?></p>
		<?php endif; ?>

		<?php if ($cta_primary_label || $cta_secondary_label) : ?>
			<div class="strip-hero__ctas">
				<?php if ($cta_primary_label) : ?>
					<a class="button button--primary" href="<?php echo esc_url($cta_primary_url ? $cta_primary_url : '#'); ?>">
						<?php echo esc_html($cta_primary_label); ?>
					</a>
				<?php endif; ?>

				<?php if ($cta_secondary_label) : ?>
					<a class="button button--secondary" href="<?php echo esc_url($cta_secondary_url ? $cta_secondary_url : '#'); ?>">
						<?php echo esc_html($cta_secondary_label); ?>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>

	<?php if ($image) : ?>
		<div class="strip-hero__image">
			<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
		</div>
	<?php endif; ?>
</section>
