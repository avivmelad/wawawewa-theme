<?php

/**
 * Strip: Hero.
 *
 * Reads sub fields from the current `page_sections` flexible content row
 * (hero layout) — see acf-json/group_wawawewa_home_page_sections.json.
 *
 * @package wawawewa
 */

$logo          = get_sub_field('hero_logo');
$eyebrow       = get_sub_field('hero_eyebrow');
$heading       = get_sub_field('hero_heading');
$subcopy       = get_sub_field('hero_subcopy');
$cta_primary   = get_sub_field('hero_cta_primary');
$cta_secondary = get_sub_field('hero_cta_secondary');
$media_type    = get_sub_field('hero_media_type');
$image         = get_sub_field('hero_image');
$image_badge   = get_sub_field('hero_image_badge');
$video_file    = get_sub_field('hero_video_file');
$video_youtube = get_sub_field('hero_video_youtube');
?>
<section class="strip-hero" data-parallax>
	<span class="strip-hero__corner strip-hero__corner--start" aria-hidden="true"></span>
	<span class="strip-hero__corner strip-hero__corner--end" aria-hidden="true"></span>

	<div class="strip-hero__inner">
		<?php if ($eyebrow) : ?>
			<span class="strip-hero__badge">
				<span class="strip-hero__badge-dot" aria-hidden="true"></span>
				<span class="strip-hero__badge-text"><?php echo esc_html($eyebrow); ?></span>
			</span>
		<?php endif; ?>

		<?php if ($logo) : ?>
			<img class="strip-hero__logo" src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>" />
		<?php endif; ?>

		<?php if ($heading) : ?>
			<h1 class="strip-hero__heading">
				<?php
				// wp_kses_post (not esc_html): editors may add <br> line breaks and
				// <span class="hl"> to highlight a word in gold, per the design.
				echo wp_kses_post($heading);
				?>
			</h1>
		<?php endif; ?>

		<?php if ($subcopy) : ?>
			<p class="strip-hero__subcopy"><?php echo esc_html($subcopy); ?></p>
		<?php endif; ?>

		<?php if ($cta_primary || $cta_secondary) : ?>
			<div class="strip-hero__ctas">
				<?php if ($cta_primary) : ?>
					<a class="button button--primary" data-magnet href="<?php echo esc_url($cta_primary['url']); ?>" target="<?php echo esc_attr($cta_primary['target'] ? $cta_primary['target'] : '_self'); ?>">
						<?php echo esc_html($cta_primary['title']); ?>
					</a>
				<?php endif; ?>

				<?php if ($cta_secondary) : ?>
					<a class="button button--secondary" data-magnet href="<?php echo esc_url($cta_secondary['url']); ?>" target="<?php echo esc_attr($cta_secondary['target'] ? $cta_secondary['target'] : '_self'); ?>">
						<?php echo esc_html($cta_secondary['title']); ?>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>

	<?php if ('upload' === $media_type && $video_file) : ?>
		<div class="strip-hero__media" data-reveal>
			<video controls playsinline>
				<source src="<?php echo esc_url($video_file['url']); ?>" type="<?php echo esc_attr($video_file['mime_type']); ?>" />
			</video>
		</div>
	<?php elseif ('youtube' === $media_type && $video_youtube) : ?>
		<div class="strip-hero__media strip-hero__media--embed" data-reveal>
			<?php
			// $video_youtube is the embed HTML WordPress already fetched/sanitized
			// via its own oEmbed handling (ACF "oembed" field) — not raw user input.
			echo $video_youtube;
			?>
		</div>
	<?php elseif ($image) : ?>
		<div class="strip-hero__media" data-reveal>
			<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
			<span class="strip-hero__media-fade" aria-hidden="true"></span>
			<?php if ($image_badge) : ?>
				<span class="strip-hero__media-badge"><?php echo esc_html($image_badge); ?></span>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</section>
