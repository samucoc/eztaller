<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
if ( is_admin()){
	return;
}

global $wplab_albedo_core;

$attributes = $classes = array();

$id = esc_attr( $atts['id'] );

$attributes[] = 'data-row-height="' . esc_attr( $atts['row_height'] ) . '"';
$attributes[] = 'data-max-row-height="' . esc_attr( $atts['max_row_height'] ) . '"';
$attributes[] = 'data-margins="' . esc_attr( $atts['margins'] ) . '"';
$attributes[] = 'data-randomize="' . esc_attr( $atts['randomize'] ) . '"';

// get a current page from query
$paged = get_query_var( 'paged' );

// extend $atts variable
$atts['paged'] = $paged == 0 ? 1 : $paged;

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

$atts['query_data'] = $query_args;
$atts['max_num_pages'] = $posts->max_num_pages;
$atts['tpl'] = 'template-parts/portfolio/photo_grid';
set_query_var( 'wplab_albedo_tpl_settings', $atts );

if( $posts->have_posts() ):
?>

<div id="shortcode-<?php echo esc_attr( $id ); ?>" class="photo-grid-gallery">
	<div id="posts-container-id-<?php echo esc_attr( $atts['id'] ); ?>" class="justified-gallery <?php echo implode(' ', $classes ); ?>" <?php echo implode( ' ', $attributes ); ?>>

		<?php while ( $posts->have_posts() ): $posts->the_post(); ?>

			<?php get_template_part( $atts['tpl'] ); ?>

		<?php endwhile; wp_reset_postdata(); ?>

	</div>

	<?php get_template_part( 'template-parts/pagination/style_ajax_infinite' ); ?>

</div>
<?php endif;
