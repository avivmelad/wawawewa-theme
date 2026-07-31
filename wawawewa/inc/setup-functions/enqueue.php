<?php

$theme_data = wp_get_theme();
define('THEME_VERSION', 1.0);

/**
 * Enqueue scripts and styles.
 */
function wawawewa_scripts()
{
	//Fonts
	wp_enqueue_style('wawawewa-fonts', 'https://fonts.googleapis.com/css2?family=Heebo:wght@500;700;800;900&family=Assistant:wght@400;500;600;700&family=Unbounded:wght@700;800;900&family=JetBrains+Mono:wght@500;700&display=swap', array(), null);

	//Css
	wp_style_add_data('wawawewa-style', 'rtl', 'replace');
	wp_enqueue_style('wawawewa-style', get_template_directory_uri() . '/dist/css/style.min.css', array('wawawewa-fonts'), THEME_VERSION);


	//Js
	wp_enqueue_script('wawawewa-general-script', get_template_directory_uri() . '/dist/js/general-script.min.js', array('jquery'), THEME_VERSION, true);
	wp_enqueue_script('wawawewa-navigation', get_template_directory_uri() . '/js/navigation.js', array(), THEME_VERSION, true);
	wp_enqueue_script('wawawewa-mini-cart', get_template_directory_uri() . '/js/mini-cart.js', array(), THEME_VERSION, true);
	wp_enqueue_script('wawawewa-reveal', get_template_directory_uri() . '/js/reveal.js', array(), THEME_VERSION, true);
	wp_enqueue_script('wawawewa-wc-notice-toast', get_template_directory_uri() . '/js/wc-notice-toast.js', array(), THEME_VERSION, true);

	$is_home_page = is_page_template('page-templates/home-page.php');
	$is_product   = function_exists('is_product') && is_product();

	if ($is_home_page || $is_product) {
		// Shared between the homepage and the single product page.
		wp_enqueue_script('wawawewa-particles', get_template_directory_uri() . '/js/particles.js', array(), THEME_VERSION, true);
		wp_enqueue_script('wawawewa-product-tilt', get_template_directory_uri() . '/js/product-tilt.js', array(), THEME_VERSION, true);
		wp_enqueue_script('wawawewa-faq-accordion', get_template_directory_uri() . '/js/faq-accordion.js', array(), THEME_VERSION, true);
	}

	if ($is_home_page) {
		wp_enqueue_script('wawawewa-hero-interactions', get_template_directory_uri() . '/js/hero-interactions.js', array(), THEME_VERSION, true);
		wp_enqueue_style('swiper-css', get_template_directory_uri() . '/dist/css/swiper-bundle.min.css', array(), THEME_VERSION);
		wp_enqueue_script('swiper-js', get_template_directory_uri() . '/dist/js/swiper-bundle.min.js', array(), THEME_VERSION, true);
		wp_enqueue_script('wawawewa-marquee', get_template_directory_uri() . '/js/marquee.js', array('swiper-js'), THEME_VERSION, true);
	}

	if ($is_product) {
		wp_enqueue_script('wawawewa-product-quantity-stepper', get_template_directory_uri() . '/js/product-quantity-stepper.js', array(), THEME_VERSION, true);
	}
	wp_localize_script('wawawewa-ajax-scripts', 'ajax_obj', array('ajaxurl' => admin_url('admin-ajax.php')));
	// wp_enqueue_script('select2', get_template_directory_uri() . '/dist/js/select2.min.js', array('jquery'), THEME_VERSION);
	// wp_enqueue_style('select2', get_template_directory_uri() . '/dist/css/select2.min.css', array(), THEME_VERSION);

	// wp_enqueue_script('wawawewa-gform-script', get_template_directory_uri() . '/dist/js/gform-script.min.js', array('jquery'), THEME_VERSION, true);]
	// wp_enqueue_script('rad-ajax-scripts', get_template_directory_uri() . '/dist/js/ajax-scripts.min.js', array('jquery'), THEME_VERSION, true);

	// The wp_localize_script allows us to output the ajax_url path for our script to use.


	// if (is_post_type_archive('resource') || is_singular('resource')) {
	// 	wp_enqueue_script('rad-resources', get_template_directory_uri() . '/dist/js/resources.min.js', array('jquery'), THEME_VERSION, true);
	// }
}
add_action('wp_enqueue_scripts', 'wawawewa_scripts');
