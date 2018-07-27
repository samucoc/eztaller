<?php

if (!defined('FW')) die('Forbidden');

if ( is_admin()){
	return;
}

/**
 * @var $atts The shortcode attributes
 */
global $wplab_albedo_core;

$attributes = $classes = $wrapper_classes = $atts['tax_query_terms'] = array();
$atts['paged'] = 1;

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

if( $posts->have_posts() ):

	$id = esc_attr( $atts['id'] );

	/** unique id **/
	$attributes[] = 'id="shortcode-' . $id . '"';
	$attributes[] = 'data-pagination="' . esc_attr( $atts['pagination'] ) . '"';

	if( filter_var( $atts['autoplay']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
		$attributes[] = 'data-autoplay="' . esc_attr( $atts['autoplay']['yes']['autoplay_speed'] ) . '"';
		$attributes[] = 'data-autoplay-stop-on-last="' . esc_attr( $atts['autoplay']['yes']['autoplay_stop_on_last'] ) . '"';
		$attributes[] = 'data-autoplay-disable-on-interaction="' . esc_attr( $atts['autoplay']['yes']['autoplay_disable_on_interaction'] ) . '"';
	}

	$attributes[] = 'data-slides="' . absint( $atts['slides_num'] ) . '"';
	$attributes[] = 'data-slides-small="' . absint( $atts['slides_num_small'] ) . '"';

	$classes[] = 'overlay-' . esc_attr( $atts['overlay_color'] );

	$attributes[] = 'data-initial-slide="' . absint( $atts['initial_slide'] ) . '"';

	?>

	<div class="shortcode-blog-carousel2 <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>
		<!-- Slider main container -->
		<div class="swiper-container">

			<!-- Additional required wrapper -->
			<div class="swiper-wrapper">
			<?php while ( $posts->have_posts() ): $posts->the_post(); ?>

				<?php
					$has_post_thumb = has_post_thumbnail();
					$col_class = $has_post_thumb ? 'col-md-6' : 'col-md-12';
				?>

				<div class="swiper-slide">
					<div class="slide-content <?php echo $has_post_thumb ? 'with-thumb' : 'without-thumb'; ?>">

						<div class="container-fluid">
							<div class="row">
								<?php if( filter_var( $atts['display_thumb'], FILTER_VALIDATE_BOOLEAN ) && $has_post_thumb ): ?>
								<div class="col-thumb col-md-6">

									<?php
										$thumb_id = get_post_thumbnail_id( get_the_ID());
										$thumb_url = wp_get_attachment_url( $thumb_id );
									?>
									<div class="thumb">
										<a href="<?php the_permalink(); ?>">
										<?php
										// custom thumb dimensions
										if( $atts['thumbs_dimensions']['type'] == 'crop' ) {

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

								</div>
								<?php endif; ?>
								<div class="<?php echo esc_attr( $col_class ); ?>">

									<div class="post-text">

										<?php if( filter_var( $atts['display_date'], FILTER_VALIDATE_BOOLEAN ) ): ?>
											<div class="post-date">
												<?php the_time( get_option('date_format') ); ?>
											</div>
										<?php endif; ?>

										<?php if( filter_var( $atts['display_title'], FILTER_VALIDATE_BOOLEAN ) ): ?>
											<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
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

										<?php if( filter_var( $atts['display_author'], FILTER_VALIDATE_BOOLEAN ) ): ?>
											<div class="post-author">
												<?php esc_html_e( 'Posted by', 'albedo'); ?> <?php the_author_posts_link(); ?>
											</div>
										<?php endif; ?>

									</div>

								</div>
							</div>
						</div>

					</div>
				</div>

			<?php endwhile; ?>
			</div>
			<?php if( filter_var( $atts['pagination'], FILTER_VALIDATE_BOOLEAN ) ): ?>
			<div class="slider-pagination pagination-pos-<?php echo esc_attr( $atts['pagination_position'] ); ?>">
				<a href="javascript:;" class="pagination-btn swiper-button-prev"></a>
				<a href="javascript:;" class="pagination-btn swiper-button-next"></a>
			</div>
			<?php endif; ?>
		</div>

	</div>

	<?php
wp_reset_postdata(); endif;
