<?php if (!defined('FW')) die('Forbidden');
if ( is_admin()){
	return;
}
/**
 * @var $atts The shortcode attributes
 */
global $wplab_albedo_core;
$classes = array();
$atts['tpl'] = 'template-parts/blog/list';

// get a current page from query
$paged = get_query_var( 'paged' );

// extend $atts variable
$atts['paged'] = $paged == 0 ? 1 : $paged;
$atts['tax_query_type'] = $atts['tax_query_terms'] = '';

if( is_post_type_archive( 'post' ) || is_tag() || is_category() || is_home() ) {

	global $wp_query;
	$posts = $wp_query;

	$query_args = array(
		'type' => 'all',
		'posts_per_page' => get_option( 'posts_per_page' ),
		'category' => '',
		'term_field' => 'slug',
		'post_type' => 'post',
		'tax_name' => 'category',
		'paged' => $atts['paged'],
		'order' => 'date',
		'sort' => 'DESC',
	);

} else {

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
		'terms' => $atts['tax_query_terms'],
		'term_field' => 'slug',
		'post_type' => 'post',
		'tax_name' => 'category',
		'paged' => $atts['paged'],
		'order' => isset( $atts['order_by'] ) && $atts['order_by'] <> '' ? $atts['order_by'] : 'date',
		'sort' => isset( $atts['sort_by'] ) && $atts['sort_by'] <> '' ? $atts['sort_by'] : 'DESC',
		'featured_only' => filter_var( $atts['featured_only'], FILTER_VALIDATE_BOOLEAN )
	);

	$posts = $wplab_albedo_core->model('post')->get( $query_args );

}

$atts['query_data'] = $query_args;
$atts['max_num_pages'] = $posts->max_num_pages;
set_query_var( 'wplab_albedo_tpl_settings', $atts );

$classes[] = 'style-' . $atts['style'];

/**
	* Display posts
**/
if( $posts->have_posts() ):
?>
<div id="shortcode-<?php echo esc_attr( $atts['id'] ); ?>" class="shortcode-blog <?php echo implode( ' ', $classes ); ?>">

	<div id="posts-container-id-<?php echo esc_attr( $atts['id'] ); ?>" class="posts-container">

		<?php while ( $posts->have_posts() ): $posts->the_post(); ?>
			<?php get_template_part( $atts['tpl'] ); ?>
		<?php endwhile; ?>

	</div>

	<?php
		// Display posts pagination?
		if( filter_var( $atts['pagination']['enabled'], FILTER_VALIDATE_BOOLEAN ) ):
			get_template_part( 'template-parts/pagination/style_' . $atts['pagination']['yes']['pagination_style']['style'] );
		endif;
	?>
</div>
<?php
wp_reset_postdata(); endif;
