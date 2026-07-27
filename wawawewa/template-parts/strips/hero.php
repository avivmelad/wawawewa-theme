<?php

/**
 * Strip: Hero.
 *
 * Reads sub fields from the current `page_sections` flexible content row
 * (hero layout) — see acf-json/group_wawawewa_home_page_sections.json.
 *
 * @package wawawewa
 */

$logo         = get_sub_field('hero_logo');
$eyebrow      = get_sub_field('hero_eyebrow');
$heading      = get_sub_field('hero_heading');
$subcopy      = get_sub_field('hero_subcopy');
$cta_primary  = get_sub_field('hero_cta_primary');
$cta_secondary = get_sub_field('hero_cta_secondary');
$image        = get_sub_field('hero_image');
?>
<section class="strip-hero">
	<div class="strip-hero__inner">
		<?php if ($logo) : ?>
			<img class="strip-hero__logo" src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>" />
		<?php endif; ?>

		<?php if ($eyebrow) : ?>
			<span class="strip-hero__eyebrow"><?php echo esc_html($eyebrow); ?></span>
		<?php endif; ?>

		<?php if ($heading) : ?>
			<h1 class="strip-hero__heading"><?php echo esc_html($heading); ?></h1>
		<?php endif; ?>

		<?php if ($subcopy) : ?>
			<p class="strip-hero__subcopy"><?php echo esc_html($subcopy); ?></p>
		<?php endif; ?>

		<?php if ($cta_primary || $cta_secondary) : ?>
			<div class="strip-hero__ctas">
				<?php if ($cta_primary) : ?>
					<a class="button button--primary" href="<?php echo esc_url($cta_primary['url']); ?>" target="<?php echo esc_attr($cta_primary['target'] ? $cta_primary['target'] : '_self'); ?>">
						<?php echo esc_html($cta_primary['title']); ?>
					</a>
				<?php endif; ?>

				<?php if ($cta_secondary) : ?>
					<a class="button button--secondary" href="<?php echo esc_url($cta_secondary['url']); ?>" target="<?php echo esc_attr($cta_secondary['target'] ? $cta_secondary['target'] : '_self'); ?>">
						<?php echo esc_html($cta_secondary['title']); ?>
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
