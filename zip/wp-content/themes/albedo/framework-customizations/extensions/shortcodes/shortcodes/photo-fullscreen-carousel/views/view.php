<?php

if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

if ( is_admin()){
	return;
}

global $wplab_albedo_core;
$attributes = array();

$id = esc_attr( $atts['id'] );
$atts['tax_query_type'] = isset( $atts['taxonomy_query']['tax_query_type'] ) ? $atts['taxonomy_query']['tax_query_type'] : '';
$atts['tax_query_terms'] = '';

if( $atts['tax_query_type'] == 'only' ) {
	$cats_str = $atts['taxonomy_query']['only']['cats_include'];
	$atts['tax_query_terms'] = explode(',', $cats_str );
} elseif( $atts['tax_query_type'] == 'except' ) {
	$cats_str = $atts['taxonomy_query']['except']['cats_exclude'];
	$atts['tax_query_terms'] = explode(',', $cats_str );
}

$attributes[] = 'data-pagination="' . esc_attr( $atts['pagination'] ) . '"';
$attributes[] = 'data-loop="' . esc_attr( $atts['loop'] ) . '"';

$attributes[] = 'data-slides-num="2"';
$attributes[] = 'data-slides-medium-num="1"';
$attributes[] = 'data-slides-small-num="1"';

if( filter_var( $atts['autoplay']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
	$attributes[] = 'data-autoplay="' . esc_attr( $atts['autoplay']['yes']['autoplay_speed'] ) . '"';
	$attributes[] = 'data-autoplay-stop-on-last="' . esc_attr( $atts['autoplay']['yes']['autoplay_stop_on_last'] ) . '"';
	$attributes[] = 'data-autoplay-disable-on-interaction="' . esc_attr( $atts['autoplay']['yes']['autoplay_disable_on_interaction'] ) . '"';
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
	'paged' => 1,
	'order' => isset( $atts['order_by'] ) && $atts['order_by'] <> '' ? $atts['order_by'] : 'date',
	'sort' => isset( $atts['sort_by'] ) && $atts['sort_by'] <> '' ? $atts['sort_by'] : 'DESC',
);

$posts = $wplab_albedo_core->model('post')->get( $query_args );

$img_width = is_numeric( $atts['image_width'] ) ? absint( $atts['image_width'] ) : null;
$img_height = is_numeric( $atts['image_height'] ) ? absint( $atts['image_height'] ) : null;

if( $posts->have_posts() ):
?>

<div id="shortcode-<?php echo esc_attr( $id ); ?>" class="photo-fullscreen-carousel" <?php echo implode( ' ', $attributes ); ?>>
	<!-- Slider main container -->
	<div class="swiper-container">

		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">

		<?php while ( $posts->have_posts() ): $posts->the_post(); ?>

			<?php $photo_url = get_the_post_thumbnail_url();?>
			<div class="swiper-slide">
				<div class="slide-content">

					<figure data-src="<?php echo esc_attr( $photo_url ); ?>">

						<a class="image-href" href="<?php echo esc_attr( $photo_url ); ?>">
							<?php
								echo wplab_albedo_media::img( array(
									'url' => $photo_url,
									'width' => $img_width,
									'height' => $img_height,
									'crop' => true,
									'hd' => false,
									'lazy' => false
								));
							?>
						</a>

						<figcaption>

							<?php if( filter_var( $atts['display_caption'], FILTER_VALIDATE_BOOLEAN ) ): ?>
							<h2 class="h4"><?php echo get_the_title(); ?></h2>
							<?php endif; ?>

							<?php if( filter_var( $atts['display_author'], FILTER_VALIDATE_BOOLEAN ) ): ?>
							&copy; <?php esc_html_e( 'Photo by', 'albedo'); ?> <span><?php the_author(); ?></span>
							<?php endif; ?>

						</figcaption>

					</figure>

				</div>
			</div>

		<?php endwhile; wp_reset_postdata(); ?>

	</div>

</div>

<?php if( filter_var( $atts['pagination'], FILTER_VALIDATE_BOOLEAN ) ): ?>
<!-- If we need pagination -->
<div class="swiper-pagination"></div>
<?php endif; ?>

</div>
<?php endif;
