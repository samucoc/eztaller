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

/**
	* Display posts
**/
if( $posts->have_posts() ):
?>
<div id="shortcode-<?php echo esc_attr( $atts['id'] ); ?>" class="shortcode-blog-scroll-posts">
	<div class="inside" style="height: <?php echo absint( $atts['height'] ); ?>px">
		<?php while ( $posts->have_posts() ): $posts->the_post(); ?>
			<div class="item">

				<?php if( filter_var( $atts['display_title'], FILTER_VALIDATE_BOOLEAN ) ): ?>
					<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				<?php endif; ?>

				<?php if( filter_var( $atts['display_excerpt']['enabled'], FILTER_VALIDATE_BOOLEAN ) ): ?>
					<div class="post-excerpt">
						<?php

							if( get_post_format() == 'link' ) {
								$content = get_the_content();
								$link = parse_url( $content );
								if( isset( $link['host'] ) ) {
									echo '<a href="' . strip_tags( $content ) . '">' . $link['host'] . '</a>';
								} else {
									echo '<a href="' . strip_tags( $content ) . '">' . $content . '</a>';
								}
							} else {
								$excerpt_length = absint( $atts['display_excerpt']['yes']['excerpt_length'] );
								echo wp_trim_words( get_the_excerpt(), $excerpt_length );
							}

						?>
					</div>
				<?php endif; ?>

				<?php
					$display_date = filter_var( $atts['display_date'], FILTER_VALIDATE_BOOLEAN );
					$display_author = filter_var( $atts['display_author'], FILTER_VALIDATE_BOOLEAN );
					if( $display_date || $display_author ):
				?>
				<div class="post-data">

					<?php if( $display_author ): ?>
						<span class="author"><?php the_author_posts_link(); ?></span>
					<?php endif; ?>

					<?php if( $display_date ): ?>
						<span class="date"><?php the_time( get_option( 'date_format') ); ?></span>
					<?php endif; ?>

				</div>
				<?php endif; ?>

			</div>
		<?php endwhile; ?>
	</div>
</div>
<?php
wp_reset_postdata(); endif;
