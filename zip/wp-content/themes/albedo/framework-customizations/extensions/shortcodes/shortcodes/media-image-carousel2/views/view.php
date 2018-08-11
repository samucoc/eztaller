<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
	$attributes = $classes = $wrapper_classes = array();

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

	if( count( $atts['images'] ) > 0 ):

?>

<div class="shortcode-images-carousel2 <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>
	<!-- Slider main container -->
	<div class="swiper-container">

		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
		<?php foreach( $atts['images'] as $item ): ?>

			<div class="swiper-slide">
				<div class="slide-content">

					<figure class="img-shortcode-wrapper <?php echo implode(' ', $wrapper_classes ); ?>" data-src="<?php echo esc_attr( $item['url'] ); ?>">
						<a href="<?php echo esc_attr( $item['url'] ); ?>">
							<?php echo wplab_albedo_media::image( $item['url'], $img_width, $img_height, true, true, $item['url'], false, array(), array('alt="' . esc_attr( get_the_title( $item['attachment_id'] ) ) . '"') ); ?>
						</a>
						<?php if( filter_var( $atts['display_caption'], FILTER_VALIDATE_BOOLEAN ) ): ?>
						<figcaption class="caption"><?php echo get_the_title( $item['attachment_id'] ); ?></figcaption>
						<?php endif; ?>
					</figure>

				</div>
			</div>

		<?php endforeach; ?>
		</div>

	</div>

	<?php if( filter_var( $atts['pagination'], FILTER_VALIDATE_BOOLEAN ) ): ?>
	<!-- If we need pagination -->
	<div class="swiper-pagination"></div>
	<?php endif; ?>

</div>

<?php
	endif;
