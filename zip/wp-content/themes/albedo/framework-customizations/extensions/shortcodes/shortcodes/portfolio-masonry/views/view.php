<?php if (!defined('FW')) die('Forbidden');
if ( is_admin()){
	return;
}
/**
 * @var $atts The shortcode attributes
 */
global $wplab_albedo_core;
$classes = $attrubutes = array();
$atts['tpl'] = 'template-parts/portfolio/masonry';

// get a current page from query
$paged = get_query_var( 'paged' );

// extend $atts variable
$atts['paged'] = $paged == 0 ? 1 : $paged;

if( is_post_type_archive( 'fw-portfolio' ) || is_tax( 'fw-category' ) ) {

	global $wp_query;
	$posts = $wp_query;

	$atts['tax_query_type'] = $atts['tax_query_terms'] = '';

	$query_args = array(
		'type' => 'all',
		'posts_per_page' => get_option( 'posts_per_page' ),
		'category' => '',
		'term_field' => 'slug',
		'post_type' => 'fw-portfolio',
		'tax_name' => 'fw-portfolio-category',
		'paged' => $atts['paged'],
		'order' => 'date',
		'sort' => 'DESC',
	);

} else {

	$atts['tax_query_type'] = isset( $atts['taxonomy_query']['tax_query_type'] ) ? $atts['taxonomy_query']['tax_query_type'] : '';
	$atts['tax_query_terms'] = '';

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
		'terms' => $atts['tax_query_terms'],
		'term_field' => 'slug',
		'post_type' => 'fw-portfolio',
		'tax_name' => 'fw-portfolio-category',
		'paged' => $atts['paged'],
		'order' => isset( $atts['order_by'] ) && $atts['order_by'] <> '' ? $atts['order_by'] : 'date',
		'sort' => isset( $atts['sort_by'] ) && $atts['sort_by'] <> '' ? $atts['sort_by'] : 'DESC',
	);

	$posts = $wplab_albedo_core->model('post')->get( $query_args );

}

$atts['query_data'] = $query_args;
$atts['max_num_pages'] = $posts->max_num_pages;
set_query_var( 'wplab_albedo_tpl_settings', $atts );

/**
	* Portfolio grid classes
**/

if( ! filter_var( $atts['display_shadow'], FILTER_VALIDATE_BOOLEAN ) ) {
	$classes[] = 'shadows-hidden';
}

if( ! filter_var( $atts['display_layers'], FILTER_VALIDATE_BOOLEAN ) ) {
	$classes[] = 'layers-hidden';
}

$classes[] = 'text-pos-' . esc_attr( $atts['desc_position'] );
$classes[] = 'overlay-' . esc_attr( $atts['overlay_color'] );
$classes[] = 'cols-' . absint( $atts['large_screen_cols'] );
$classes[] = 'medium-cols-' . absint( $atts['medium_screen_cols'] );
$classes[] = 'small-cols-' . absint( $atts['small_screen_cols'] );
$classes[] = esc_attr( $atts['effect'] );

/**
	* Portfolio grid attributes
**/

$grid_margins = is_numeric( $atts['grid_margins'] ) ? absint( $atts['grid_margins'] ) : 30;
$attrubutes[] = 'data-grid-margins="' . $grid_margins . '"';


/**
	* Display posts
**/
if( $posts->have_posts() ):
?>
<div id="shortcode-<?php echo esc_attr( $atts['id'] ); ?>" class="portfolio-masonry-shortcode">
	<?php
		// Display post filfers?
		if( filter_var( $atts['filters']['enabled'], FILTER_VALIDATE_BOOLEAN ) ):
	?>
	<div data-atts="<?php echo htmlspecialchars( json_encode( $atts ), ENT_QUOTES, 'UTF-8' ); ?>" class="posts-filters filters-style-<?php echo esc_attr( $atts['filters']['yes']['filters_style'] ); ?> filters-align-<?php echo esc_attr( $atts['filters']['yes']['filters_align'] ); ?>" data-target-id="posts-container-id-<?php echo esc_attr( $atts['id'] ); ?>">
		<span class="icon"></span>
		<?php
			$terms = get_terms( 'fw-portfolio-category', array(
				'hide_empty' => true
			));
			if( count( $terms ) > 0 ) {
					echo '<a href="javascript:;" class="current" data-term="">' . esc_html__('All', 'albedo') . '</a><span class="separator">/</span>';
				foreach( $terms as $term ) {
					echo '<a href="javascript:;" data-term="' . $term->slug . '">' . $term->name . '</a><span class="separator">/</span>';
				}
			}
		?>
	</div>
	<?php endif; ?>

	<div id="posts-container-id-<?php echo esc_attr( $atts['id'] ); ?>" class="portfolio-masonry-posts masonry-grid <?php echo implode(' ', $classes ); ?>">
		<ul <?php echo implode( ' ', $attrubutes ); ?> id="grid-id-<?php echo $atts['id']; ?>" class="grid">
		<?php while ( $posts->have_posts() ): $posts->the_post(); ?>

			<?php get_template_part( $atts['tpl'] ); ?>

		<?php endwhile; ?>
		</ul>
	</div>

	<?php
		// Display posts pagination?
		if( filter_var( $atts['pagination']['enabled'], FILTER_VALIDATE_BOOLEAN ) ):
	?>

		<?php get_template_part( 'template-parts/pagination/style_' . $atts['pagination']['yes']['pagination_style']['style'] ); ?>

	<?php endif; ?>
</div>
<?php
wp_reset_postdata(); endif;
