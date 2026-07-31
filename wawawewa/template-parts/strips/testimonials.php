<?php

/**
 * Strip: Testimonials.
 *
 * Reads the `testimonials_items` repeater from the current `page_sections`
 * flexible content row — see acf-json/group_wawawewa_home_page_sections.json.
 * No eyebrow/heading — the design goes straight into the card grid.
 *
 * @package wawawewa
 */

$items = array();

if (have_rows('testimonials_items')) {
	while (have_rows('testimonials_items')) {
		the_row();

		$quote  = get_sub_field('quote');
		$author = get_sub_field('author');

		if ($quote && $author) {
			$items[] = array(
				'quote'  => $quote,
				'author' => $author,
			);
		}
	}
}

if (! $items) {
	return;
}
?>
<section class="strip-testimonials">
	<div class="strip-testimonials__grid">
		<?php foreach ($items as $item) : ?>
			<div class="strip-testimonials__card" data-reveal>
				<div class="strip-testimonials__stars" aria-hidden="true">★★★★★</div>
				<p class="strip-testimonials__quote"><?php echo esc_html($item['quote']); ?></p>
				<div class="strip-testimonials__author"><?php echo esc_html($item['author']); ?></div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
