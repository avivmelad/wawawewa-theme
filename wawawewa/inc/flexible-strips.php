<?php

/**
 * ACF Flexible Content dispatcher for page section "strips".
 *
 * Each flexible content layout gets one render function here
 * (wawawewa_strip_{layout}), which in turn calls the matching
 * template-parts/strips/{layout}.php partial. See the "Flexible content
 * page sections" convention in CLAUDE.md.
 */

/**
 * Loop a page's flexible content field and render each row's strip.
 *
 * @param string $selector Flexible content field name. Default 'page_sections'.
 */
function wawawewa_render_strips($selector = 'page_sections')
{
	if (! have_rows($selector)) {
		return;
	}

	while (have_rows($selector)) {
		the_row();

		if (get_sub_field('strip_hidden')) {
			continue;
		}

		$function = 'wawawewa_strip_' . get_row_layout();

		if (function_exists($function)) {
			call_user_func($function);
		}
	}
}

/**
 * Strip: Hero.
 */
function wawawewa_strip_hero()
{
	get_template_part('template-parts/strips/hero');
}

/**
 * Strip: Marquee.
 */
function wawawewa_strip_marquee()
{
	get_template_part('template-parts/strips/marquee');
}

/**
 * Strip: Best sellers.
 */
function wawawewa_strip_best_sellers()
{
	get_template_part('template-parts/strips/best-sellers');
}

/**
 * Strip: Categories (Lookbook).
 */
function wawawewa_strip_categories()
{
	get_template_part('template-parts/strips/categories');
}
