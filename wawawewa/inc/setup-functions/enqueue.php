<?php

$theme_data = wp_get_theme();
define('THEME_VERSION', 1.0);

/**
 * Enqueue scripts and styles.
 */
function wawawewa_scripts()
{
	//Css
	wp_style_add_data('wawawewa-style-rtl', 'rtl', 'replace');
	wp_enqueue_style('wawawewa-style', get_template_directory_uri() . '/dist/css/style.min.css', array(), THEME_VERSION);

	//Js
	wp_enqueue_script('wawawewa-general-script', get_template_directory_uri() . '/dist/js/general-script.min.js', array('jquery'), THEME_VERSION, true);
	wp_localize_script('wawawewa-ajax-scripts', 'ajax_obj', array('ajaxurl' => admin_url('admin-ajax.php')));
	// wp_enqueue_script('select2', get_template_directory_uri() . '/dist/js/select2.min.js', array('jquery'), THEME_VERSION);
	// wp_enqueue_style('select2', get_template_directory_uri() . '/dist/css/select2.min.css', array(), THEME_VERSION);


	// wp_enqueue_script('swiper-js', get_template_directory_uri() . '/dist/js/swiper9-bundle.min.js', array('jquery'), THEME_VERSION);
	// wp_enqueue_style('swiper-css', get_template_directory_uri() . '/dist/css/swiper9-bundle.min.css', array(), THEME_VERSION);

	// wp_enqueue_script('wawawewa-gform-script', get_template_directory_uri() . '/dist/js/gform-script.min.js', array('jquery'), THEME_VERSION, true);]
	// wp_enqueue_script('rad-ajax-scripts', get_template_directory_uri() . '/dist/js/ajax-scripts.min.js', array('jquery'), THEME_VERSION, true);

	// The wp_localize_script allows us to output the ajax_url path for our script to use.


	// if (is_post_type_archive('resource') || is_singular('resource')) {
	// 	wp_enqueue_script('rad-resources', get_template_directory_uri() . '/dist/js/resources.min.js', array('jquery'), THEME_VERSION, true);
	// }
}
add_action('wp_enqueue_scripts', 'wawawewa_scripts');