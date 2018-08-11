<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
	$attributes = $classes = array();

	$id = esc_attr( $atts['id'] );
	$attributes[] = 'id="shortcode-' . $id . '"';
	$attributes[] = 'data-pagination="' . esc_attr( $atts['pagination'] ) . '"';

	if( filter_var( $atts['autoplay']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
		$attributes[] = 'data-autoplay="' . esc_attr( $atts['autoplay']['yes']['autoplay_speed'] ) . '"';
		$attributes[] = 'data-autoplay-stop-on-last="' . esc_attr( $atts['autoplay']['yes']['autoplay_stop_on_last'] ) . '"';
		$attributes[] = 'data-autoplay-disable-on-interaction="' . esc_attr( $atts['autoplay']['yes']['autoplay_disable_on_interaction'] ) . '"';
	}

	$attributes[] = 'data-init-slide="' . absint( $atts['init_slide'] ) . '"';

		if( count( $atts['items'] ) > 0 ):

?>

<div class="shortcode-videos-carousel <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>
	<!-- Slider main container -->
	<div class="swiper-container">

		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">

		<?php
			$img_width = is_numeric( $atts['image_width'] ) ? absint( $atts['image_width'] ) : null;
			$img_height = is_numeric( $atts['image_height'] ) ? absint( $atts['image_height'] ) : null;
		?>

		<?php foreach( $atts['items'] as $item ): if( isset( $item['cover']['data']['icon'] ) && $item['cover']['data']['icon'] <> '' ): ?>

			<div class="swiper-slide">
				<div class="slide-content">

					<figure class="img-shortcode-wrapper" data-src="<?php echo esc_attr( $item['url'] ); ?>">
						<a href="<?php echo esc_attr( $item['cover']['data']['icon'] ); ?>">
							<?php echo wplab_albedo_media::image( $item['cover']['data']['icon'], $img_width, $img_height, true, true, $item['cover']['data']['icon'], false, array(), array('alt="' . esc_attr( get_the_title( $item['cover']['custom'] ) ) . '"') ); ?>
						</a>
					</figure>

				</div>
			</div>

		<?php endif; endforeach; ?>
		</div>

	</div>

	<?php if( filter_var( $atts['pagination'], FILTER_VALIDATE_BOOLEAN ) ): ?>
	<div class="pagination-buttons">
		<a href="javascript:;" class="pagination-btn swiper-button-prev"></a>
		<a href="javascript:;" class="pagination-btn swiper-button-next"></a>
	</div>
	<?php endif; ?>

</div>

<?php
	endif;
