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
$atts['tax_query_terms'] = $atts['paged'] = '';
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
	'paged' => absint( $atts['paged'] ),
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

	$classes[] = 'overlay-' . $atts['overlay_color'];
	$classes[] = 'shadow-' . $atts['display_shadow'];

	if( filter_var( $atts['display_lightbox_icon'], FILTER_VALIDATE_BOOLEAN ) ) {
		$classes[] = 'with-lightbox';
	}

	$attributes[] = 'data-initial-slide="' . absint( $atts['initial_slide'] ) . '"';

	?>

	<div class="shortcode-portfolio-posts-carousel <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>
	<!-- Slider main container -->
	<div class="swiper-container">

		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
		<?php while ( $posts->have_posts() ): $posts->the_post(); ?>

			<div class="swiper-slide">
				<div class="slide-content">

					<?php
						$thumb_id = get_post_thumbnail_id( get_the_ID());
						$thumb_url = wp_get_attachment_url( $thumb_id );

						if( $thumb_url <> '' ):
							?>
							<div class="thumb">
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

								<div class="overlay-text">
									<?php if( filter_var( $atts['display_link_icon'], FILTER_VALIDATE_BOOLEAN ) ): ?>
										<div class="post-link">
											<a href="<?php the_permalink(); ?>"><span><?php esc_html_e('View details', 'albedo'); ?></span></a>
										</div>
									<?php endif; ?>
									<?php if( filter_var( $atts['display_lightbox_icon'], FILTER_VALIDATE_BOOLEAN ) && $thumb_url <> '' ): ?>
										<div class="lightbox-link" data-src="<?php echo esc_attr( $thumb_url ); ?>">
											<a class="lightbox" href="<?php echo esc_attr( $thumb_url ); ?>"><span><?php esc_html_e('View larger', 'albedo'); ?></span></a>
										</div>
									<?php endif; ?>
								</div>

							</div>
							<?php
						endif;

					?>

					<div class="post-text">
						<?php if( filter_var( $atts['display_title'], FILTER_VALIDATE_BOOLEAN ) ): ?>
							<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<?php endif; ?>
						<?php if( filter_var( $atts['display_excerpt'], FILTER_VALIDATE_BOOLEAN ) ): ?>
							<div class="excerpt"><?php the_excerpt(); ?></div>
						<?php endif; ?>
						<div class="likes-cats-table">
						<?php if( filter_var( $atts['display_cats'], FILTER_VALIDATE_BOOLEAN ) ): ?>
							<div class="post-categories">
								<?php echo wplab_albedo_front::get_categories(' '); ?>
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

		<?php endwhile; ?>
		</div>

	</div>

	<?php if( filter_var( $atts['pagination'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $atts['display_button']['enabled'], FILTER_VALIDATE_BOOLEAN ) ): ?>
		<div class="slider-bottom">
			<?php if( filter_var( $atts['pagination'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<?php if( is_rtl() ): ?>
					<div class="swiper-button-next"></div>
				<?php else: ?>
					<div class="swiper-button-prev"></div>
				<?php endif; ?>
			<?php endif; ?>

			<?php if( filter_var( $atts['display_button']['enabled'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<a href="<?php echo esc_attr( $atts['display_button']['yes']['button_link'] ); ?>" class="button style-<?php echo esc_attr( $atts['display_button']['yes']['button_style'] ); ?>"><?php echo esc_attr( $atts['display_button']['yes']['button_text'] ); ?></a>
			<?php endif; ?>

			<?php if( filter_var( $atts['pagination'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<?php if( is_rtl() ): ?>
					<div class="swiper-button-prev"></div>
				<?php else: ?>
					<div class="swiper-button-next"></div>
				<?php endif; ?>
			<?php endif; ?>
		</div>

	<?php endif; ?>

	</div>

	<?php
wp_reset_postdata(); endif;
