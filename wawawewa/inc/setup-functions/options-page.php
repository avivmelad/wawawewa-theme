<?php

/**
 * ACF options page for global site settings.
 *
 * Fields added to this page are read anywhere with get_field( $selector, 'option' ).
 */
function wawawewa_acf_options_page()
{
	if (! function_exists('acf_add_options_page')) {
		return;
	}

	acf_add_options_page(
		array(
			'page_title' => esc_html__('הגדרות האתר', 'wawawewa'),
			'menu_title' => esc_html__('הגדרות האתר', 'wawawewa'),
			'menu_slug'  => 'wawawewa-site-settings',
			'capability' => 'edit_posts',
			'redirect'   => false,
		)
	);
}
add_action('acf/init', 'wawawewa_acf_options_page');
