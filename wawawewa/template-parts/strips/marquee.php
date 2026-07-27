<?php

/**
 * Strip: Marquee — infinite scrolling text strip.
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
	<div class="strip-marquee__track">
		<div class="strip-marquee__set">
			<?php foreach ($items as $item) : ?>
				<span class="strip-marquee__item"><?php echo esc_html($item); ?></span>
			<?php endforeach; ?>
		</div>
		<div class="strip-marquee__set" aria-hidden="true">
			<?php foreach ($items as $item) : ?>
				<span class="strip-marquee__item"><?php echo esc_html($item); ?></span>
			<?php endforeach; ?>
		</div>
	</div>
</div>
