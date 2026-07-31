<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package wawawewa
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wawawewa_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'wawawewa_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function wawawewa_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'wawawewa_pingback_header' );

/**
 * Inline social-icon SVG for the footer's `footer_social_links` repeater.
 *
 * Only the 3 platforms in the Futuristic v2 design have a matching icon —
 * intentionally not a general-purpose icon set.
 *
 * @param string $platform One of: pinterest, instagram, twitter.
 * @return string Inline SVG markup, or an empty string for an unknown platform.
 */
function wawawewa_footer_social_icon( $platform ) {
	$icons = array(
		'pinterest' => '<path d="M15 3H12.5C10.29 3 8.5 4.79 8.5 7V10H6V13.5H8.5V21H12V13.5H14.5L15 10H12V7.5C12 6.67 12.67 6 13.5 6H15V3Z" fill="currentColor" />',
		'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5" stroke="currentColor" stroke-width="1.6" /><circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.6" /><circle cx="17.3" cy="6.7" r="1.1" fill="currentColor" />',
		'twitter'   => '<path d="M22 5.9c-.7.3-1.5.5-2.3.6.8-.5 1.5-1.3 1.7-2.3-.8.5-1.6.8-2.5 1a4 4 0 0 0-6.8 3.6A11.3 11.3 0 0 1 3.9 4.7a4 4 0 0 0 1.2 5.3c-.6 0-1.2-.2-1.7-.5v.1c0 1.9 1.4 3.6 3.2 4-.6.1-1.2.2-1.8.1.5 1.6 2 2.8 3.8 2.8A8 8 0 0 1 2 18.6 11.3 11.3 0 0 0 8.1 20c7.3 0 11.3-6.1 11.3-11.3v-.5c.8-.6 1.4-1.3 1.9-2.1Z" fill="currentColor" />',
	);

	if ( ! isset( $icons[ $platform ] ) ) {
		return '';
	}

	return '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" aria-hidden="true">' . $icons[ $platform ] . '</svg>';
}
