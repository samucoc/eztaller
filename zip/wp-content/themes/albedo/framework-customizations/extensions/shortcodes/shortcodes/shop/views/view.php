<?php if (!defined('FW')) die('Forbidden');
if ( is_admin()){
	return;
}
/**
 * @var $atts The shortcode attributes
 */
global $wplab_albedo_core;
$classes = array();
$atts['tpl'] = 'template-parts/shop/default';

$orderby_array = array(
	'menu_order' => esc_html__( 'Default sorting', 'albedo'),
	'popularity' => esc_html__( 'Sort by popularity', 'albedo'),
	'rating' => esc_html__( 'Sort by average rating', 'albedo'),
	'date' => esc_html__( 'Sort by newness', 'albedo'),
	'price' => esc_html__( 'Sort by price: low to high', 'albedo'),
	'price-desc' => esc_html__( 'Sort by price: high to low', 'albedo'),
);

$product_cat = isset( $_GET['product_cat'] ) && $_GET['product_cat'] <> '' ? esc_sql( $_GET['product_cat'] ) : '';

$min_price = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '';
$max_price = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : '';

// get a current page from query
$paged = get_query_var( 'paged' );

// extend $atts variable
$atts['paged'] = $paged == 0 ? 1 : $paged;

$atts['tax_query_terms'] = '';
$atts['tax_query_type'] = isset( $atts['taxonomy_query']['tax_query_type'] ) ? $atts['taxonomy_query']['tax_query_type'] : '';

if( $atts['tax_query_type'] == 'only' ) {
	$cats_str = $atts['taxonomy_query']['only']['cats_include'];
	$atts['tax_query_terms'] = explode(',', $cats_str );
} elseif( $atts['tax_query_type'] == 'except' ) {
	$cats_str = $atts['taxonomy_query']['except']['cats_exclude'];
	$atts['tax_query_terms'] = explode(',', $cats_str );
}

/**
 * Get posts
 **/
$query_args = array(
	'type' => $atts['tax_query_type'] <> '' ? $atts['tax_query_type'] : 'all',
	'posts_per_page' => isset( $atts['posts_per_page'] ) && $atts['posts_per_page'] <> '' ? absint( $atts['posts_per_page'] ) : 9,
	'term_field' => 'slug',
	'post_type' => 'product',
	'tax_name' => 'product_cat',
	'paged' => $atts['paged'],
	'order' => $atts['order_by'],
	'sort' => isset( $atts['sort_by'] ) && $atts['sort_by'] <> '' ? $atts['sort_by'] : 'DESC',
);

if( $product_cat <> '' ) {
	$query_args['terms'] = $product_cat;
	$query_args['type'] = 'include';
}

if( $min_price <> '' || $max_price <> '' ) {
	$query_args['meta_query'][] = array(
		'key' => '_price',
		'value' => array( absint( $min_price ), absint( $max_price )),
		'compare' => 'BETWEEN',
		'type' => 'NUMERIC'
	);
}

$custom_orderby = isset( $_GET['orderby'] ) && $_GET['orderby'] <> '' ? $_GET['orderby'] : '';
if( $custom_orderby <> '' ) {
	switch ( $custom_orderby ) {
		case 'date':

			$query_args['order'] = 'date';
			$query_args['sort'] = 'DESC';

		break;
		case 'price':

			$query_args['order'] = 'meta_value_num';
			$query_args['sort'] = 'ASC';
			$query_args['orderby_meta_key'] = '_price';

		break;
		case 'price-desc':

			$query_args['order'] = 'meta_value_num';
			$query_args['sort'] = 'DESC';
			$query_args['orderby_meta_key'] = '_price';

		break;
		case 'popularity':

			$query_args['order'] = 'meta_value_num';
			$query_args['sort'] = 'DESC';
			$query_args['orderby_meta_key'] = 'total_sales';

		break;
		case 'rating':

			$query_args['order'] = 'meta_value_num';
			$query_args['sort'] = 'DESC';
			$query_args['orderby_meta_key'] = '_wc_average_rating';

		break;
	}
}

$posts = $wplab_albedo_core->model('post')->get( $query_args );

$atts['query_data'] = $query_args;
$atts['max_num_pages'] = $posts->max_num_pages;
set_query_var( 'wplab_albedo_tpl_settings', $atts );

$classes[] = 'woo-products-' . $atts['style'];

/**
	* Display posts
**/
if( $posts->have_posts() ):
?>
<div id="shortcode-<?php echo esc_attr( $atts['id'] ); ?>" class="shop-shortcode <?php echo implode(' ', $classes ); ?>">
	<?php
		// Display post filfers?
		if( filter_var( $atts['filters']['enabled'], FILTER_VALIDATE_BOOLEAN ) ):
			global $wp;
			if ( '' === get_option( 'permalink_structure' ) ) {
				$form_action = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
			} else {
				$form_action = preg_replace( '%\/page/[0-9]+%', '', home_url( trailingslashit( $wp->request ) ) );
			}
	?>
	<div data-atts="<?php echo htmlspecialchars( json_encode( $atts ), ENT_QUOTES, 'UTF-8' ); ?>" class="shop-filters shop-filters-style-<?php echo esc_attr( $atts['filters']['yes']['filters_style'] ); ?>" data-target-id="posts-container-id-<?php echo esc_attr( $atts['id'] ); ?>">
		<form method="GET" action="<?php echo esc_attr( $form_action ); ?>">
			<div class="filter-section">
				<label><?php esc_html_e( 'Sort By', 'albedo'); ?>:</label>
				<select name="orderby">
					<?php foreach( $orderby_array as $k=>$v ): ?>
						<option <?php selected( $custom_orderby, $k); ?> value="<?php echo esc_attr( $k ); ?>"><?php echo wp_kses_post( $v ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="filter-section">
				<label><?php esc_html_e( 'Category', 'albedo'); ?>:</label>
				<select name="product_cat">
					<?php
						$terms = get_terms( 'product_cat', array(
							'hide_empty' => true
						));
						if( count( $terms ) > 0 ):
							echo '<option value="">' . esc_html__('All categories', 'albedo') . '</option>';
							foreach( $terms as $term ):
								echo '<option ' . selected( $product_cat, $term->slug, false ) . ' value="' . $term->slug . '">' . $term->name . '</option>';
							endforeach;
						endif;
					?>
				</select>
			</div>

			<?php
				$prices = $wplab_albedo_core->model('post')->woo_get_min_max_prices();
				$min    = floor( $prices->min_price );
				$max    = ceil( $prices->max_price );
				if( $min != $max ):
			?>
			<div class="filter-section section-price">
				<label><?php esc_html_e( 'Price', 'albedo'); ?>:</label>
				<?php
					echo '
					<div class="price_slider_wrapper">
						<div class="price_slider" style="display:none;"></div>
						<div class="price_slider_amount">
							<input type="text" id="min_price" name="min_price" value="' . esc_attr( $min_price ) . '" data-min="' . esc_attr( apply_filters( 'woocommerce_price_filter_widget_min_amount', $min ) ) . '" placeholder="' . esc_attr__( 'Min price', 'albedo' ) . '" />
							<input type="text" id="max_price" name="max_price" value="' . esc_attr( $max_price ) . '" data-max="' . esc_attr( apply_filters( 'woocommerce_price_filter_widget_max_amount', $max ) ) . '" placeholder="' . esc_attr__( 'Max price', 'albedo' ) . '" />
							<div class="price_label" style="display:none;">
								<span class="from"></span> &mdash; <span class="to"></span>
							</div>
							<div class="clear"></div>
						</div>
					</div>
					';
				?>
			</div>
			<?php endif; ?>

			<div class="filter-section section-submit">
				<label>&nbsp;</label>
				<input type="submit" class="button style-blue" value="<?php esc_html_e( 'Filter', 'albedo'); ?>" />
			</div>

		</form>
	</div>
	<?php endif; ?>

	<ul id="posts-container-id-<?php echo esc_attr( $atts['id'] ); ?>" class="products">
		<?php while ( $posts->have_posts() ): $posts->the_post(); ?>

			<?php
				/**
				 * woocommerce_shop_loop hook.
				 *
				 * @hooked WC_Structured_Data::generate_product_data() - 10
				 */
				do_action( 'woocommerce_shop_loop' );
			?>

			<?php wc_get_template_part( 'content', 'product' ); ?>

		<?php endwhile; ?>
	</ul>

	<?php
		// Display posts pagination?
		if( filter_var( $atts['pagination']['enabled'], FILTER_VALIDATE_BOOLEAN ) ):
	?>

		<?php get_template_part( 'template-parts/pagination/style_' . $atts['pagination']['yes']['pagination_style']['style'] ); ?>

	<?php endif; ?>
</div>
<?php
wp_reset_postdata(); endif;
