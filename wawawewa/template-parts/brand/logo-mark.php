<?php

/**
 * Template part: WA monogram logo mark (inline SVG).
 *
 * Usage: get_template_part( 'template-parts/brand/logo-mark', null, array( 'size' => 34 ) );
 *
 * @param array $args {
 *     @type int $size Rendered width/height in pixels. Default 34.
 * }
 *
 * @package wawawewa
 */

$size = isset( $args['size'] ) ? (int) $args['size'] : 34;
?>
<svg width="<?php echo esc_attr( $size ); ?>" height="<?php echo esc_attr( $size ); ?>" viewBox="0 0 48 48" class="brand-logo-mark" aria-hidden="true" focusable="false">
	<circle cx="24" cy="24" r="22" fill="none" stroke="#c9a24b" stroke-width="1.5"></circle>
	<path d="M24,8 L8,38 M24,8 L40,38 M15.47,24 L32.53,24" stroke="#c9a24b" stroke-width="4" fill="none" stroke-linecap="square" stroke-linejoin="miter"></path>
	<path d="M8,19 L14,37 L24,23 L34,37 L40,19" stroke="#c9a24b" stroke-width="4" fill="none" stroke-linecap="square" stroke-linejoin="miter"></path>
</svg>
