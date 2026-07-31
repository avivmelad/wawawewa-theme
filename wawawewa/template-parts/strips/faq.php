<?php

/**
 * Strip: FAQ accordion.
 *
 * Reads `faq_heading` and the `faq_items` repeater from the current
 * `page_sections` flexible content row — see
 * acf-json/group_wawawewa_home_page_sections.json.
 *
 * Single-open accordion: opening one row closes any other open row, first
 * row open by default (see js/faq-accordion.js). Uses real <button> headers
 * (aria-expanded/aria-controls) rather than the mockup's plain onClick divs,
 * for keyboard accessibility. Item/question/sign/answer markup uses the
 * shared `.accordion` component (sass/components/_accordion.scss) — also
 * reused by the single product page's Description/Shipping/Care rows.
 *
 * @package wawawewa
 */

$heading = get_sub_field('faq_heading');
$items   = array();

if (have_rows('faq_items')) {
	while (have_rows('faq_items')) {
		the_row();

		$question = get_sub_field('question');
		$answer   = get_sub_field('answer');

		if ($question && $answer) {
			$items[] = array(
				'question' => $question,
				'answer'   => $answer,
			);
		}
	}
}

if (! $items) {
	return;
}

$strip_id = 'faq-' . wp_unique_id();
?>
<section class="strip-faq">
	<?php if ($heading) : ?>
		<h2 class="strip-faq__heading"><?php echo esc_html($heading); ?></h2>
	<?php endif; ?>

	<div class="accordion" data-faq-accordion>
		<?php foreach ($items as $index => $item) :
			$row_id     = $strip_id . '-' . $index;
			$is_open    = 0 === $index;
			?>
			<div class="accordion__item<?php echo $is_open ? ' is-open' : ''; ?>">
				<button
					type="button"
					class="accordion__question"
					id="<?php echo esc_attr($row_id . '-question'); ?>"
					aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>"
					aria-controls="<?php echo esc_attr($row_id . '-answer'); ?>"
					data-faq-toggle
				>
					<span><?php echo esc_html($item['question']); ?></span>
					<span class="accordion__sign" aria-hidden="true"></span>
				</button>

				<div
					class="accordion__answer"
					id="<?php echo esc_attr($row_id . '-answer'); ?>"
					role="region"
					aria-labelledby="<?php echo esc_attr($row_id . '-question'); ?>"
					<?php echo $is_open ? '' : 'hidden'; ?>
				>
					<p><?php echo esc_html($item['answer']); ?></p>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
