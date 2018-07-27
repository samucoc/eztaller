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
	'featured_only' => filter_var( $atts['featured_only'], FILTER_VALIDATE_BOOLEAN )
);

$posts = $wplab_albedo_core->model('post')->get( $query_args );

/**
	* Display posts
**/
if( $posts->have_posts() ):
?>
<div id="shortcode-<?php echo esc_attr( $atts['id'] ); ?>" class="shortcode-blog-featured-post overlay-<?php echo esc_attr( $atts['overlay_color'] ); ?>">
	<div class="inside">
		<?php while ( $posts->have_posts() ): $posts->the_post(); ?>

			<?php if( has_post_thumbnail() && filter_var( $atts['display_title'], FILTER_VALIDATE_BOOLEAN ) ): ?>
			<div class="thumb">
				<a href="<?php the_permalink(); ?>">
				<?php
					$thumb_id = get_post_thumbnail_id( get_the_ID());
					$thumb_url = wp_get_attachment_url( $thumb_id );
					?>
					<a href="<?php the_permalink(); ?>">
					<?php
					// custom thumb dimensions
					if( isset( $atts['thumbs_dimensions']['type'] ) && $atts['thumbs_dimensions']['type'] == 'crop' ) {

						$thumb_width = is_numeric( $atts['thumbs_dimensions']['crop']['thumb_width'] ) ? absint( $atts['thumbs_dimensions']['crop']['thumb_width'] ) : null;
						$thumb_height = is_numeric( $atts['thumbs_dimensions']['crop']['thumb_height'] ) ? absint( $atts['thumbs_dimensions']['crop']['thumb_height'] ) : null;

						echo wplab_albedo_media::img( array(
							'url' => $thumb_url,
							'width' => $thumb_width,
							'height' => $thumb_height,
							'lazy' => false,
							'atts' => array( 0 => 'alt="' . esc_attr( get_the_title( $thumb_id ) ) . '"')
						));

					} else {
						echo '<img src="' . esc_attr( $thumb_url ) . '" alt="" />';
					}
				?>
				<div class="overlay"></div>
				</a>
			</div>
			<?php endif; ?>

			<?php if( filter_var( $atts['display_title'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
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

		<?php endwhile; ?>
	</div>
</div>
<?php
wp_reset_postdata(); endif;
