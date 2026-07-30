<?php

/**
 * Allow SVG uploads to the media library.
 *
 * Restricted to users who can `manage_options` (admins) — SVG files can
 * embed <script>/event-handler XSS payloads, so this is a trust-based
 * control (only trusted admins can upload one), not a content sanitizer.
 * Don't grant this to editor/author roles without adding real sanitization.
 */

if (! function_exists('wawawewa_allow_svg_upload')) {
	/**
	 * Add the SVG mime type for admins.
	 *
	 * @param array $mimes Allowed mime types.
	 * @return array
	 */
	function wawawewa_allow_svg_upload($mimes) {
		if (current_user_can('manage_options')) {
			$mimes['svg'] = 'image/svg+xml';
		}

		return $mimes;
	}
}
add_filter('upload_mimes', 'wawawewa_allow_svg_upload');

if (! function_exists('wawawewa_fix_svg_filetype_check')) {
	/**
	 * WordPress's own mime sniffing doesn't recognize SVGs and rejects the
	 * upload before `upload_mimes` is even consulted — patch the check for
	 * files with a .svg extension specifically.
	 *
	 * @param array  $data     File data (ext, type, proper_filename).
	 * @param string $file     Full path to the file.
	 * @param string $filename The name of the file.
	 * @return array
	 */
	function wawawewa_fix_svg_filetype_check($data, $file, $filename) {
		if (current_user_can('manage_options') && preg_match('/\.svg$/i', $filename)) {
			$data['ext']             = 'svg';
			$data['type']            = 'image/svg+xml';
			$data['proper_filename'] = $filename;
		}

		return $data;
	}
}
add_filter('wp_check_filetype_and_ext', 'wawawewa_fix_svg_filetype_check', 10, 3);

if (! function_exists('wawawewa_svg_attachment_metadata')) {
	/**
	 * Read an uploaded SVG's own width/height (or viewBox) so the media
	 * library grid can size its thumbnail correctly instead of showing a
	 * broken/oversized preview.
	 *
	 * @param array $metadata      Attachment metadata.
	 * @param int   $attachment_id Attachment ID.
	 * @return array
	 */
	function wawawewa_svg_attachment_metadata($metadata, $attachment_id) {
		if ('image/svg+xml' !== get_post_mime_type($attachment_id)) {
			return $metadata;
		}

		$file = get_attached_file($attachment_id);

		if (! $file || ! file_exists($file)) {
			return $metadata;
		}

		$svg = @simplexml_load_file($file);

		if (! $svg) {
			return $metadata;
		}

		$attributes = $svg->attributes();
		$width      = 0;
		$height     = 0;

		if (isset($attributes->width) && isset($attributes->height) && is_numeric((string) $attributes->width)) {
			$width  = (int) $attributes->width;
			$height = (int) $attributes->height;
		} elseif (isset($attributes->viewBox)) {
			$viewbox = explode(' ', (string) $attributes->viewBox);

			if (4 === count($viewbox)) {
				$width  = (int) $viewbox[2];
				$height = (int) $viewbox[3];
			}
		}

		if ($width && $height) {
			$metadata['width']  = $width;
			$metadata['height'] = $height;
		}

		return $metadata;
	}
}
add_filter('wp_generate_attachment_metadata', 'wawawewa_svg_attachment_metadata', 10, 2);

if (! function_exists('wawawewa_svg_media_grid_css')) {
	/**
	 * Scale SVG previews to fit their grid cell in the media library —
	 * without dimensions from the metadata filter above, WP would otherwise
	 * fall back to a fixed-size generic file icon.
	 */
	function wawawewa_svg_media_grid_css() {
		?>
		<style>
			.media-icon img[src$=".svg"],
			.attachment-preview .thumbnail img[src$=".svg"],
			td.media-icon img[src$=".svg"] {
				width: 100% !important;
				height: auto !important;
			}
		</style>
		<?php
	}
}
add_action('admin_head', 'wawawewa_svg_media_grid_css');
