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

// The CSS loop (translateX 0 -> -50%) only works seamlessly if each half of
// the track is at least as wide as the viewport. A handful of short phrases
// wouldn't fill the screen on their own, so each half repeats the list
// several times — harmless when there are already enough items, and what
// keeps the animation from visibly "jumping" when there are only a few.
$repeats = 4;
?>
<div class="strip-marquee">
	<ul class="screen-reader-text">
		<?php foreach ($items as $item) : ?>
			<li><?php echo esc_html($item); ?></li>
		<?php endforeach; ?>
	</ul>

	<div class="strip-marquee__track" aria-hidden="true">
		<?php for ($half = 0; $half < 2; $half++) : ?>
			<div class="strip-marquee__set">
				<?php for ($repeat = 0; $repeat < $repeats; $repeat++) : ?>
					<?php foreach ($items as $item) : ?>
						<span class="strip-marquee__item"><?php echo esc_html($item); ?></span>
					<?php endforeach; ?>
				<?php endfor; ?>
			</div>
		<?php endfor; ?>
	</div>
</div>
