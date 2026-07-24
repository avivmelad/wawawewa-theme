<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wawawewa
 */

?>

		<div class="newsletter-band">
			<div class="newsletter-band__copy">
				<h2><?php esc_html_e( 'הצטרפו למועדון', 'wawawewa' ); ?></h2>
				<p><?php esc_html_e( '10% הנחה על ההזמנה הראשונה, ישר למייל', 'wawawewa' ); ?></p>
			</div>
			<div class="newsletter-band__form">
				<?php
				if ( shortcode_exists( 'gravityform' ) ) {
					/**
					 * Replace form_id with the real newsletter Gravity Form ID once it's built in wp-admin.
					 * Expected fields: single email input styled via .newsletter-band__form .gform_wrapper (see sass/components/footer/_footer.scss).
					 */
					echo do_shortcode( '[gravityform id="1" title="false" description="false" ajax="true"]' );
				} else {
					// Gravity Forms isn't active yet — render a disabled placeholder so the section isn't empty.
					?>
					<div class="newsletter-band__placeholder">
						<input type="email" placeholder="<?php esc_attr_e( 'האימייל שלך', 'wawawewa' ); ?>" disabled />
						<span class="newsletter-band__submit"><?php esc_html_e( 'הרשמה', 'wawawewa' ); ?></span>
					</div>
					<?php
				}
				?>
			</div>
		</div>

		<footer id="colophon" class="site-footer">
			<div class="site-footer__inner">
				<div class="site-footer__copyright">
					<?php
					/* translators: %s: current year. */
					printf( esc_html__( '© wawawewa %s', 'wawawewa' ), esc_html( gmdate( 'Y' ) ) );
					?>
				</div>
				<nav class="site-footer__links" aria-label="<?php esc_attr_e( 'קישורי פוטר', 'wawawewa' ); ?>">
					<a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php esc_html_e( 'תקנון', 'wawawewa' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/shipping/' ) ); ?>"><?php esc_html_e( 'משלוחים', 'wawawewa' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'יצירת קשר', 'wawawewa' ); ?></a>
				</nav>
			</div>
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>

</body>
</html>
