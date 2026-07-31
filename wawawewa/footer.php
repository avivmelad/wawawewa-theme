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

$newsletter_heading = get_field( 'footer_newsletter_heading', 'option' );
$newsletter_subcopy = get_field( 'footer_newsletter_subcopy', 'option' );
$newsletter_form_id = get_field( 'footer_newsletter_form_id', 'option' );
$copyright_text     = get_field( 'footer_copyright_text', 'option' );
$footer_links       = get_field( 'footer_links', 'option' );
?>

		<div class="newsletter-band">
			<div class="newsletter-band__copy">
				<?php if ( $newsletter_heading ) : ?>
					<h2><?php echo esc_html( $newsletter_heading ); ?></h2>
				<?php endif; ?>
				<?php if ( $newsletter_subcopy ) : ?>
					<p><?php echo esc_html( $newsletter_subcopy ); ?></p>
				<?php endif; ?>
			</div>
			<div class="newsletter-band__form">
				<?php
				if ( $newsletter_form_id && shortcode_exists( 'gravityform' ) ) {
					// Expected fields: single email input styled via .newsletter-band__form .gform_wrapper (see sass/components/footer/_footer.scss).
					echo do_shortcode( '[gravityform id="' . absint( $newsletter_form_id ) . '" title="false" description="false" ajax="true"]' );
				} else {
					// No form ID set yet, or Gravity Forms isn't active — render a disabled placeholder so the section isn't empty.
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
					printf( esc_html( $copyright_text ? $copyright_text : '© wawawewa %s' ), esc_html( gmdate( 'Y' ) ) );
					?>
				</div>
				<?php if ( $footer_links ) : ?>
					<nav class="site-footer__links" aria-label="<?php esc_attr_e( 'קישורי פוטר', 'wawawewa' ); ?>">
						<?php foreach ( $footer_links as $row ) :
							$link = $row['link'];

							if ( ! $link ) {
								continue;
							}
							?>
							<a href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo esc_attr( $link['target'] ? $link['target'] : '_self' ); ?>">
								<?php echo esc_html( $link['title'] ); ?>
							</a>
						<?php endforeach; ?>
					</nav>
				<?php endif; ?>
			</div>
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>

</body>
</html>
