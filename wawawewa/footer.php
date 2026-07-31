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

$footer_logo    = get_field( 'header_logo', 'option' );
$wordmark_type  = get_field( 'header_wordmark_type', 'option' );
$wordmark_text  = get_field( 'header_wordmark_text', 'option' );
$wordmark_image = get_field( 'header_wordmark_image', 'option' );

$brand_blurb    = get_field( 'footer_brand_blurb', 'option' );
$social_links   = get_field( 'footer_social_links', 'option' );
$link_columns   = get_field( 'footer_link_columns', 'option' );
$copyright_text = get_field( 'footer_copyright_text', 'option' );
$payment_badges = get_field( 'footer_payment_badges', 'option' );
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
			<div class="site-footer__columns">
				<div class="site-footer__brand">
					<a class="site-footer__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php if ( $footer_logo ) : ?>
							<img src="<?php echo esc_url( $footer_logo['url'] ); ?>" alt="<?php echo esc_attr( $footer_logo['alt'] ? $footer_logo['alt'] : get_bloginfo( 'name' ) ); ?>" width="28" height="28" />
						<?php else : ?>
							<?php get_template_part( 'template-parts/brand/logo-mark', null, array( 'size' => 28 ) ); ?>
						<?php endif; ?>

						<?php if ( 'image' === $wordmark_type && $wordmark_image ) : ?>
							<img class="site-footer__wordmark-image" src="<?php echo esc_url( $wordmark_image['url'] ); ?>" alt="<?php echo esc_attr( $wordmark_image['alt'] ? $wordmark_image['alt'] : get_bloginfo( 'name' ) ); ?>" />
						<?php else : ?>
							<span class="site-footer__word"><?php echo esc_html( $wordmark_text ? $wordmark_text : get_bloginfo( 'name' ) ); ?></span>
						<?php endif; ?>
					</a>

					<?php if ( $brand_blurb ) : ?>
						<p class="site-footer__blurb"><?php echo esc_html( $brand_blurb ); ?></p>
					<?php endif; ?>

					<?php if ( $social_links ) : ?>
						<div class="site-footer__social">
							<?php foreach ( $social_links as $row ) :
								$icon = wawawewa_footer_social_icon( $row['platform'] );

								if ( ! $icon || ! $row['url'] ) {
									continue;
								}
								?>
								<a class="site-footer__social-link" href="<?php echo esc_url( $row['url'] ); ?>" target="_blank" rel="noopener noreferrer">
									<?php echo $icon; // Trusted, hardcoded SVG markup — see wawawewa_footer_social_icon(). ?>
								</a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( $link_columns ) : ?>
					<?php foreach ( $link_columns as $column ) : ?>
						<div class="site-footer__link-column">
							<?php if ( $column['column_title'] ) : ?>
								<div class="site-footer__column-title"><?php echo esc_html( $column['column_title'] ); ?></div>
							<?php endif; ?>

							<?php if ( $column['column_links'] ) : ?>
								<nav class="site-footer__column-links">
									<?php foreach ( $column['column_links'] as $row ) :
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
					<?php endforeach; ?>
				<?php endif; ?>
			</div>

			<div class="site-footer__bottom">
				<div class="site-footer__copyright">
					<?php
					/* translators: %s: current year. */
					printf( esc_html( $copyright_text ? $copyright_text : '© wawawewa %s' ), esc_html( gmdate( 'Y' ) ) );
					?>
				</div>

				<?php if ( $payment_badges ) : ?>
					<div class="site-footer__payments">
						<?php foreach ( $payment_badges as $row ) :
							if ( ! $row['label'] ) {
								continue;
							}
							?>
							<span class="site-footer__payment-badge"><?php echo esc_html( $row['label'] ); ?></span>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>

</body>
</html>
