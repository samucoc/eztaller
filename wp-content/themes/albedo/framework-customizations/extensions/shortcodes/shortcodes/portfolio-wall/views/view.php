<?php if (!defined('FW')) die('Forbidden');
if ( is_admin()){
	return;
}
/**
 * @var $atts The shortcode attributes
 */
global $wplab_albedo_core;
$classes = $attrubutes = array();
$atts['tax_query_terms'] = $atts['tax_query_type'] = '';
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
	'paged' => 1,
	'order' => isset( $atts['order_by'] ) && $atts['order_by'] <> '' ? $atts['order_by'] : 'date',
	'sort' => isset( $atts['sort_by'] ) && $atts['sort_by'] <> '' ? $atts['sort_by'] : 'DESC',
);

$posts = $wplab_albedo_core->model('post')->get( $query_args );

$classes[] = 'overlay-' . esc_attr( $atts['overlay_color'] );
$classes[] = 'lightbox-' . esc_attr( $atts['display_zoom_icon'] );

$style_wide = false;
if( $atts['columns'] == 'col-md-3' ) {
	$classes[] = 'wide-style';
	$style_wide = true;
}

/**
	* Display posts
**/
if( $posts->have_posts() ):
?>
<div id="shortcode-<?php echo esc_attr( $atts['id'] ); ?>" class="portfolio-wall-shortcode <?php echo implode(' ', $classes ); ?>">

	<div class="container-fluid">

		<?php $i_all = 0; $i=0; while ( $posts->have_posts() ): $posts->the_post(); ?>

			<?php
				$thumb_id = get_post_thumbnail_id( get_the_ID());
				$original_thumb_url = wp_get_attachment_url( $thumb_id );
				$thumb_url = $original_thumb_url;

				if( $atts['thumbs_dimensions']['type'] == 'crop' ) {

					$thumb_width = is_numeric( $atts['thumbs_dimensions']['crop']['thumb_width'] ) ? absint( $atts['thumbs_dimensions']['crop']['thumb_width'] ) : null;
					$thumb_height = is_numeric( $atts['thumbs_dimensions']['crop']['thumb_height'] ) ? absint( $atts['thumbs_dimensions']['crop']['thumb_height'] ) : null;

					$thumb_url = wplab_albedo_media::img_resize( $thumb_url, $thumb_width, $thumb_height );

				}
			?>

			<?php if( $i == 0 ): ?>
				<div class="row">
			<?php endif; ?>

				<div class="<?php echo esc_attr( $atts['columns'] ); ?> col <?php echo $i == 0 ? 'left-side' : 'right-side'; ?>" style="background-image: url( <?php echo esc_attr( $thumb_url ); ?>);">
					<div class="overlay"></div>
					<div class="inside">
						<?php if( filter_var( $atts['display_hover_cats'], FILTER_VALIDATE_BOOLEAN ) ): ?>
						<div class="text-item item-categories">
							<div class="text">
								<?php echo wplab_albedo_front::get_categories(' '); ?>
							</div>
						</div>
						<?php endif; ?>

						<?php if( filter_var( $atts['display_hover_title'], FILTER_VALIDATE_BOOLEAN ) ): ?>
						<div class="text-item item-title">
							<div class="text">
								<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							</div>
						</div>
						<?php endif; ?>

						<?php if( filter_var( $atts['display_zoom_icon'], FILTER_VALIDATE_BOOLEAN ) ): ?>
							<div class="text-item item-zoom">
								<div class="text">
									<div class="lightbox-link" data-src="<?php echo esc_attr( $original_thumb_url ); ?>">
										<a class="lightbox" href="<?php echo esc_attr( $original_thumb_url ); ?>"></a>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>

			<?php if( ($style_wide && $i == 3) || (!$style_wide && $i == 1) || ($i_all + 1 == $posts->post_count) ): ?>
			</div><!-- row close -->
			<?php endif; ?>

		<?php $i++; $i_all++; if( !$style_wide && $i == 2 ) { $i = 0; } elseif( $style_wide && $i == 4 ) { $i = 0; }  endwhile; ?>

	</div>

</div>
<?php
wp_reset_postdata(); endif;
