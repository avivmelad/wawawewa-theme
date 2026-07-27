<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wawawewa
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'wawawewa' ); ?></a>

		<div class="drawer-overlay" data-drawer-overlay></div>

		<nav id="drawer-nav" class="drawer-nav" aria-label="<?php esc_attr_e( 'Primary menu', 'wawawewa' ); ?>" data-drawer>
			<div class="drawer-nav__top">
				<button type="button" class="drawer-nav__close" aria-label="<?php esc_attr_e( 'Close menu', 'wawawewa' ); ?>" data-drawer-close>
					<svg width="26" height="26" viewBox="0 0 24 24" aria-hidden="true">
						<path d="M5 5L19 19M19 5L5 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
					</svg>
				</button>
			</div>
			<?php
			if ( has_nav_menu( 'menu-1' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'container'      => false,
						'menu_class'     => 'drawer-nav__list',
						'depth'          => 1,
					)
				);
			}
			?>
			<div class="drawer-nav__eyebrow"><?php esc_html_e( 'SYS.MENU // 2026', 'wawawewa' ); ?></div>
		</nav>

		<header id="masthead" class="site-header">
			<div class="header-wrapper">
				<button type="button" class="header-hamburger" aria-label="<?php esc_attr_e( 'Open menu', 'wawawewa' ); ?>" aria-controls="drawer-nav" aria-expanded="false" data-drawer-open>
					<span></span>
					<span></span>
					<span class="header-hamburger__accent"></span>
				</button>

				<?php $header_logo = get_field( 'header_logo', 'option' ); ?>
				<a class="header-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php if ( $header_logo ) : ?>
						<img class="header-brand__logo" src="<?php echo esc_url( $header_logo['url'] ); ?>" alt="<?php echo esc_attr( $header_logo['alt'] ? $header_logo['alt'] : get_bloginfo( 'name' ) ); ?>" width="34" height="34" />
					<?php else : ?>
						<?php get_template_part( 'template-parts/brand/logo-mark', null, array( 'size' => 34 ) ); ?>
					<?php endif; ?>
					<span class="header-brand__word header-brand__word--gradient"><?php bloginfo( 'name' ); ?></span>
				</a>

				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
					<div class="header-cart" data-mini-cart>
						<button type="button" class="header-cart__toggle" aria-label="<?php esc_attr_e( 'View your shopping cart', 'wawawewa' ); ?>" aria-haspopup="true" aria-expanded="false" aria-controls="mini-cart-panel" data-mini-cart-toggle>
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
								<path d="M2 3H4.5L5.6 5M5.6 5H21L18.5 13H7.5L5.6 5Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
								<circle cx="9" cy="19" r="1.6" fill="currentColor" />
								<circle cx="17" cy="19" r="1.6" fill="currentColor" />
							</svg>
							<span class="header-cart__count"><?php echo esc_html( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?></span>
						</button>

						<div id="mini-cart-panel" class="header-cart__panel" data-mini-cart-panel>
							<?php the_widget( 'WC_Widget_Cart', array( 'title' => '' ) ); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</header><!-- #masthead -->