<?php if (!defined('FW')) die('Forbidden');
if ( is_admin()){
	return;
}
/**
 * @var $atts The shortcode attributes
 */
global $wplab_albedo_core;

$atts['tax_query_type'] = isset( $atts['taxonomy_query']['tax_query_type'] ) ? $atts['taxonomy_query']['tax_query_type'] : '';
$atts['tax_query_terms'] = $atts['paged'] = '';

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
	'posts_per_page' => 1,
	'terms' => $atts['tax_query_terms'],
	'term_field' => 'slug',
	'post_type' => 'post',
	'tax_name' => 'category',
	'paged' => $atts['paged'],
	'order' => isset( $atts['order_by'] ) && $atts['order_by'] <> '' ? $atts['order_by'] : 'date',
	'sort' => isset( $atts['sort_by'] ) && $atts['sort_by'] <> '' ? $atts['sort_by'] : 'DESC',
	'featured_only' => filter_var( $atts['featured_only'], FILTER_VALIDATE_BOOLEAN ),
	'post_format' => $atts['post_format'] == '' ? 'standard' : $atts['post_format']
);

$posts = $wplab_albedo_core->model('post')->get( $query_args );

/**
	* Display posts
**/
if( $posts->have_posts() ):
?>
<div id="shortcode-<?php echo esc_attr( $atts['id'] ); ?>" class="shortcode-blog-post overlay-<?php echo esc_attr( $atts['overlay_color'] ); ?> post-format-<?php echo esc_attr( $atts['post_format'] ); ?> shadow-<?php echo esc_attr( $atts['display_shadow'] ); ?> text-align-<?php echo esc_attr( $atts['text_align'] ); ?>" <?php if( $atts['height'] <> ''): ?>style="height: <?php echo absint( $atts['height'] ); ?>px"<?php endif; ?>>
	<?php while ( $posts->have_posts() ): $posts->the_post(); ?>

		<?php include 'post-formats/format-' . $atts['post_format'] . '.php'; ?>

	<?php endwhile; ?>
</div>
<?php
wp_reset_postdata(); endif;
