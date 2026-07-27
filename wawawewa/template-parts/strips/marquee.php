<?php

/**
 * Strip: Marquee — infinite scrolling text strip (Swiper loop mode).
 *
 * Reads the `marquee_items` repeater from the current `page_sections`
 * flexible content row — see acf-json/group_wawawewa_home_page_sections.json.
 *
 * @package wawawewa
 */

$items = array();

if (have_rows('marquee_items')) {
	while (have_rows('marquee_items')) {
		the_row();

		$text = get_sub_field('text');

		if ($text) {
			$items[] = $text;
		}
	}
}

if (! $items) {
	return;
}
?>
<div class="strip-marquee">
	<ul class="screen-reader-text">
		<?php foreach ($items as $item) : ?>
			<li><?php echo esc_html($item); ?></li>
		<?php endforeach; ?>
	</ul>

	<div class="swiper marquee-swiper" aria-hidden="true">
		<div class="swiper-wrapper">
			<?php foreach ($items as $item) : ?>
				<div class="swiper-slide strip-marquee__item"><?php echo esc_html($item); ?></div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
