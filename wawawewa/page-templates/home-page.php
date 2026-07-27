<?php

/**
 * Template Name: Homepage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wawawewa
 */

get_header();
?>
<main class="site-main">
	<canvas class="homepage-particles" data-particles aria-hidden="true"></canvas>
	<?php wawawewa_render_strips('page_sections'); ?>
</main>

<?php
get_footer();
