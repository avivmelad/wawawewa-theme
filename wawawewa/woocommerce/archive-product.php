<?php
/**
 * The template for displaying product archive pages (shop + category/tag
 * taxonomy archives), rebuilt in the "Futuristic v2" direction.
 *
 * Overrides WooCommerce's default `templates/archive-product.php`. Keeps the
 * same `woocommerce_before_main_content`/`woocommerce_after_main_content`
 * hooks the theme already uses on the single-product page (breadcrumb +
 * `<main>` wrapper both come from those, see inc/woocommerce.php), but
 * replaces the default loop/sidebar-widget structure with the mockup's
 * category header + filter sidebar + product grid + pagination, still built
 * on the real main WP_Query (filtering via GET params — see
 * docs/current-mission.md "Decisions made" for why no AJAX/custom query is
 * needed for sort/price, and inc/woocommerce.php for the one custom
 * sub-category tax_query filter).
 *
 * @package wawawewa
 */

defined( 'ABSPATH' ) || exit;

get_header();

$context   = wawawewa_get_category_page_context();
$term      = $context['term'];
$base_link = $term ? get_term_link( $term ) : ( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) );

$sort_options = array(
	'menu_order' => __( 'מומלצים', 'wawawewa' ),
	'date'       => __( 'חדש ביותר', 'wawawewa' ),
	'price'      => __( 'מחיר: מהנמוך לגבוה', 'wawawewa' ),
	'price-desc' => __( 'מחיר: מהגבוה לנמוך', 'wawawewa' ),
);
$current_orderby = isset( $_GET['orderby'] ) ? sanitize_key( wp_unslash( $_GET['orderby'] ) ) : 'menu_order'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

$price_ranges = array(
	array(
		'min'   => '',
		'max'   => '100',
		'label' => __( 'עד ₪100', 'wawawewa' ),
	),
	array(
		'min'   => '100',
		'max'   => '250',
		'label' => __( '₪100 – ₪250', 'wawawewa' ),
	),
	array(
		'min'   => '250',
		'max'   => '500',
		'label' => __( '₪250 – ₪500', 'wawawewa' ),
	),
	array(
		'min'   => '500',
		'max'   => '',
		'label' => __( 'מעל ₪500', 'wawawewa' ),
	),
);
$current_min_price = isset( $_GET['min_price'] ) ? sanitize_text_field( wp_unslash( $_GET['min_price'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$current_max_price = isset( $_GET['max_price'] ) ? sanitize_text_field( wp_unslash( $_GET['max_price'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

$selected_subcats = isset( $_GET['subcat'] ) ? array_map( 'sanitize_title', (array) wp_unslash( $_GET['subcat'] ) ) : array(); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

$has_active_filters = ( 'menu_order' !== $current_orderby ) || '' !== $current_min_price || '' !== $current_max_price || $selected_subcats;

do_action( 'woocommerce_before_main_content' );
?>

<canvas class="particles-canvas" data-particles aria-hidden="true"></canvas>

<div class="category-page">

	<div class="category-page__header">
		<div>
			<div class="category-page__badge">
				<span class="category-page__badge-dot" aria-hidden="true"></span>
				<span><?php echo esc_html( $context['badge_label'] ); ?></span>
			</div>
			<h1 class="category-page__title"><?php echo esc_html( $context['title'] ); ?></h1>
		</div>
		<div class="category-page__count">
			<?php
			printf(
				/* translators: %s: number of products found. */
				esc_html( _n( '%s מוצר בקטגוריה זו', '%s מוצרים בקטגוריה זו', $wp_query->found_posts, 'wawawewa' ) ),
				esc_html( number_format_i18n( $wp_query->found_posts ) )
			);
			?>
		</div>
	</div>

	<div class="category-page__layout">

		<form class="category-page__sidebar" method="get" data-filter-form>

			<div class="category-page__filter-group">
				<div class="category-page__filter-title"><?php esc_html_e( 'מיון', 'wawawewa' ); ?></div>
				<div class="category-page__filter-list">
					<?php foreach ( $sort_options as $key => $label ) : ?>
						<label class="category-page__filter-option">
							<input type="radio" name="orderby" value="<?php echo esc_attr( $key ); ?>" class="category-page__filter-input" <?php checked( $current_orderby, $key ); ?>>
							<span class="category-page__filter-radio" aria-hidden="true"></span>
							<span class="category-page__filter-label"><?php echo esc_html( $label ); ?></span>
						</label>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="category-page__filter-group">
				<div class="category-page__filter-title"><?php esc_html_e( 'מחיר', 'wawawewa' ); ?></div>
				<div class="category-page__filter-list">
					<?php foreach ( $price_ranges as $range ) : ?>
						<label class="category-page__filter-option">
							<input
								type="radio"
								name="price_bucket"
								class="category-page__filter-input"
								data-price-option
								data-min="<?php echo esc_attr( $range['min'] ); ?>"
								data-max="<?php echo esc_attr( $range['max'] ); ?>"
								<?php checked( $current_min_price === $range['min'] && $current_max_price === $range['max'] ); ?>
							>
							<span class="category-page__filter-checkbox" aria-hidden="true"></span>
							<span class="category-page__filter-label"><?php echo esc_html( $range['label'] ); ?></span>
						</label>
					<?php endforeach; ?>
				</div>
				<input type="hidden" name="min_price" value="<?php echo esc_attr( $current_min_price ); ?>">
				<input type="hidden" name="max_price" value="<?php echo esc_attr( $current_max_price ); ?>">
			</div>

			<?php if ( $context['subcats'] ) : ?>
				<div class="category-page__filter-group">
					<div class="category-page__filter-title"><?php esc_html_e( 'תת-קטגוריה', 'wawawewa' ); ?></div>
					<div class="category-page__filter-list">
						<?php foreach ( $context['subcats'] as $subcat ) : ?>
							<label class="category-page__filter-option">
								<input type="checkbox" name="subcat[]" value="<?php echo esc_attr( $subcat->slug ); ?>" class="category-page__filter-input" <?php checked( in_array( $subcat->slug, $selected_subcats, true ) ); ?>>
								<span class="category-page__filter-checkbox" aria-hidden="true"></span>
								<span class="category-page__filter-label"><?php echo esc_html( $subcat->name ); ?></span>
							</label>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( $has_active_filters ) : ?>
				<a class="category-page__clear" href="<?php echo esc_url( $base_link ); ?>"><?php esc_html_e( 'איפוס סינון', 'wawawewa' ); ?></a>
			<?php endif; ?>

		</form>

		<div class="category-page__main">

			<?php if ( have_posts() ) : ?>

				<div class="category-page__grid">
					<?php
					while ( have_posts() ) :
						the_post();

						global $product;

						if ( ! $product instanceof WC_Product ) {
							$product = wc_get_product( get_the_ID() );
						}

						if ( ! $product ) {
							continue;
						}

						$badge = wawawewa_get_product_grid_badge( $product );
						?>
						<div class="product-card" data-reveal data-tilt>
							<a class="product-card__image" href="<?php echo esc_url( get_permalink() ); ?>">
								<?php echo $product->get_image( 'woocommerce_thumbnail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<?php if ( $badge ) : ?>
									<span class="product-card__badge"><?php echo esc_html( $badge ); ?></span>
								<?php endif; ?>
							</a>
							<div class="product-card__body">
								<a class="product-card__name" href="<?php echo esc_url( get_permalink() ); ?>">
									<?php echo esc_html( $product->get_name() ); ?>
								</a>
								<div class="product-card__footer">
									<div class="product-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
									<?php woocommerce_template_loop_add_to_cart(); ?>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				</div>

				<?php
				$big = 999999999;

				$preserved_args = array();
				if ( 'menu_order' !== $current_orderby ) {
					$preserved_args['orderby'] = $current_orderby;
				}
				if ( '' !== $current_min_price ) {
					$preserved_args['min_price'] = $current_min_price;
				}
				if ( '' !== $current_max_price ) {
					$preserved_args['max_price'] = $current_max_price;
				}
				if ( $selected_subcats ) {
					$preserved_args['subcat'] = $selected_subcats;
				}

				$pagination_links = paginate_links(
					array(
						'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format'    => '?paged=%#%',
						'current'   => max( 1, get_query_var( 'paged' ) ),
						'total'     => $wp_query->max_num_pages,
						'type'      => 'array',
						'prev_next' => false,
						'add_args'  => $preserved_args,
					)
				);

				if ( $pagination_links ) :
					?>
					<nav class="category-page__pagination" aria-label="<?php esc_attr_e( 'עימוד', 'wawawewa' ); ?>">
						<?php
						foreach ( $pagination_links as $link ) {
							echo wp_kses_post( $link );
						}
						?>
					</nav>
				<?php endif; ?>

			<?php else : ?>

				<p class="category-page__empty"><?php esc_html_e( 'לא נמצאו מוצרים התואמים לסינון שנבחר.', 'wawawewa' ); ?></p>

			<?php endif; ?>

		</div>

	</div>

</div>

<?php
do_action( 'woocommerce_after_main_content' );

get_footer();
