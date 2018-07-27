<?php if (!defined('FW')) die('Forbidden');

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

	$attributes[] = 'data-initial-slide="' . absint( $atts['initial_slide'] ) . '"';

	$img_width = is_numeric( $atts['image_width'] ) ? absint( $atts['image_width'] ) : null;
	$img_height = is_numeric( $atts['image_height'] ) ? absint( $atts['image_height'] ) : null;

	?>

	<div class="shortcode-portfolio-carousel <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>
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
					?>
					<figure class="img-shortcode-wrapper <?php echo implode(' ', $wrapper_classes ); ?>" data-src="<?php echo esc_attr( $thumb_url ); ?>">
						<a href="<?php echo esc_attr( $thumb_url ); ?>">
							<?php echo wplab_albedo_media::image( $thumb_url, $img_width, $img_height, true, true, '', false, array(), array('alt="' . esc_attr( get_the_title() ) . '"') ); ?>
						</a>
						<?php if( filter_var( $atts['display_caption'], FILTER_VALIDATE_BOOLEAN ) ): ?>
						<figcaption class="caption"><?php the_title(); ?></figcaption>
						<?php endif; ?>
					</figure>

				</div>
			</div>

		<?php endwhile; ?>
		</div>

	</div>

	<?php if( filter_var( $atts['pagination'], FILTER_VALIDATE_BOOLEAN ) ): ?>
	<!-- If we need pagination -->
	<div class="swiper-pagination"></div>
	<?php endif; ?>

	</div>

	<?php
wp_reset_postdata(); endif;
