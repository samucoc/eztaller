<?php

if (!defined('FW')) die('Forbidden');

if ( is_admin()){
	return;
}

/**
 * @var $atts The shortcode attributes
 */
global $wplab_albedo_core;

$attributes = $classes = $wrapper_classes = array();
$atts['paged'] = 0;
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
	'post_type' => 'fw-portfolio',
	'tax_name' => 'fw-portfolio-category',
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

	$classes[] = 'shadow-' . $atts['display_shadow'];

	$attributes[] = 'data-initial-slide="' . absint( $atts['initial_slide'] ) . '"';

	?>

	<div class="shortcode-portfolio-featured-carousel <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>

	<?php if( filter_var( $atts['pagination'], FILTER_VALIDATE_BOOLEAN ) ): ?>
		<div class="swiper-pagination"></div>
	<?php endif; ?>

	<!-- Slider main container -->
	<div class="swiper-container">

		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
		<?php while ( $posts->have_posts() ): $posts->the_post(); ?>

			<?php
				$thumb_id = get_post_thumbnail_id( get_the_ID());
				$thumb_url = wp_get_attachment_url( $thumb_id );
				$column_ratio = explode( ' ', $atts['columns_ratio'] );
			?>

			<div class="swiper-slide">
				<div class="slide-content">

					<div class="container-fluid">
						<div class="row">
							<?php if( $thumb_url <> '' ): ?>
							<div class="<?php echo esc_attr( $column_ratio[0] ); ?> thumb">
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
								</a>
							</div>
							<?php endif; ?>
							<div class="<?php echo $thumb_url <> '' ? esc_attr( $column_ratio[1] ) : 'col-md-12' ; ?>">
								<div class="slide-text">
									<?php if( filter_var( $atts['display_cats'], FILTER_VALIDATE_BOOLEAN ) ): ?>
										<div class="post-categories">
											<?php echo wplab_albedo_front::get_categories(' '); ?>
										</div>
									<?php endif; ?>

									<?php if( filter_var( $atts['display_title'], FILTER_VALIDATE_BOOLEAN ) ): ?>
										<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
									<?php endif; ?>

									<?php if( filter_var( $atts['display_excerpt'], FILTER_VALIDATE_BOOLEAN ) ): ?>
										<?php
											$excerpt = get_the_excerpt();
											if( isset( $atts['excerpt_length'] ) && $atts['excerpt_length'] <> '' ) {
												$excerpt = wp_trim_words( $excerpt, absint( $atts['excerpt_length'] ) );
											}
										?>
										<div class="excerpt"><p><?php echo wp_kses_post( $excerpt ); ?></p></div>
									<?php endif; ?>

									<div class="likes-details">

										<?php if( filter_var( $atts['display_button']['enabled'], FILTER_VALIDATE_BOOLEAN ) ): ?>
											<div class="details-btn">
												<a href="<?php the_permalink(); ?>" class="button style-<?php echo esc_attr( $atts['display_button']['yes']['button_style'] ); ?>"><?php echo wp_kses_post( $atts['display_button']['yes']['button_text'] ); ?></a>
											</div>
										<?php endif; ?>

										<?php if( filter_var( $atts['display_likes'], FILTER_VALIDATE_BOOLEAN ) ): ?>
											<div class="post-likes">
												<?php $voted = isset( $_COOKIE[ 'post_id_' . get_the_ID() . '_liked' ] ) ? filter_var( $_COOKIE[ 'post_id_' . get_the_ID() . '_liked' ], FILTER_VALIDATE_BOOLEAN ) : false; ?>

												<a href="javascript:;" class="<?php if( $voted ): ?>clicked<?php endif; ?> like-post" data-post-id="<?php the_ID(); ?>">
													<span>
													<?php
														$likes = absint( get_post_meta( get_the_ID(), 'likes', true ) );
														printf( _nx( '1 Like', '%1$s Likes', $likes, 'post likes', 'albedo' ), number_format_i18n( $likes ) );
													?>
													</span>
												</a>
											</div>
										<?php endif; ?>
									</div>
								</div>

							</div>
						</div>
					</div>

				</div>
			</div>

		<?php endwhile; ?>
		</div>

	</div>

	</div>

	<?php
wp_reset_postdata(); endif;
