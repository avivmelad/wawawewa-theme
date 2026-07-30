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
	<defs>
		<linearGradient id="brand-logo-mark-gradient" x1="0" y1="0" x2="1" y2="1">
			<stop offset="0%" stop-color="#f1e2bd"></stop>
			<stop offset="55%" stop-color="#b8892e"></stop>
			<stop offset="100%" stop-color="#7a5a1f"></stop>
		</linearGradient>
	</defs>
	<circle cx="24" cy="24" r="22" fill="none" stroke="#141312" stroke-width="1.5"></circle>
	<path d="M24,8 L8,38 M24,8 L40,38 M15.47,24 L32.53,24" stroke="#141312" stroke-width="4" fill="none" stroke-linecap="square" stroke-linejoin="miter"></path>
	<path d="M8,19 L14,37 L24,23 L34,37 L40,19" stroke="url(#brand-logo-mark-gradient)" stroke-width="4" fill="none" stroke-linecap="square" stroke-linejoin="miter"></path>
</svg>
