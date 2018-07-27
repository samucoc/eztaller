<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
	$attributes = $classes = array();

	$id = esc_attr( $atts['id'] );

	/** unique id **/
	$attributes[] = 'id="shortcode-' . $id . '"';
	$attributes[] = 'data-effect="' . esc_attr( $atts['effect'] ) . '"';
	$attributes[] = 'data-pagination="' . esc_attr( $atts['pagination'] ) . '"';
	$attributes[] = 'data-loop="' . esc_attr( $atts['loop'] ) . '"';

	if( filter_var( $atts['autoplay']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
		$attributes[] = 'data-autoplay="' . esc_attr( $atts['autoplay']['yes']['autoplay_speed'] ) . '"';
		$attributes[] = 'data-autoplay-stop-on-last="' . esc_attr( $atts['autoplay']['yes']['autoplay_stop_on_last'] ) . '"';
		$attributes[] = 'data-autoplay-disable-on-interaction="' . esc_attr( $atts['autoplay']['yes']['autoplay_disable_on_interaction'] ) . '"';
	}

	if( count( $atts['items'] ) > 0 ):

?>

<div class="shortcode-testimonials-carousel3 <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>
	<!-- Slider main container -->
	<div class="swiper-container">

		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
		<?php foreach( $atts['items'] as $item ): ?>

			<?php
				$text = $item['text'];
				$photo = isset( $item['photo']['url'] ) ? $item['photo']['url'] : '';
			?>
			<div class="swiper-slide" data-img-url="<?php echo esc_attr( $photo ); ?>">
				<div class="slide-content">

					<div class="row">
						<?php if( $photo <> '' ): ?>
						<div class="col-md-6">
							<div class="photo">
								<?php echo wplab_albedo_media::image( $photo, false, false, true, true, $photo ); ?>
							</div>
						</div>
						<?php endif; ?>
						<div class="col-md-<?php echo $photo <> '' ? '6' : '12'; ?>">

							<?php if( $text <> '' ): ?>
							<div class="text">
								<?php echo wp_kses_post( $text ); ?>
							</div>
							<?php endif; ?>

							<?php
								$sign = isset( $item['signature']['url'] ) ? $item['signature']['url'] : '';
								if( $sign <> '' ):
									echo '<div class="sign">' . wplab_albedo_media::image( $sign, false, false, true, true, $sign ) . '</div>';
								endif;
							?>

						</div>
					</div>

				</div>
			</div>

		<?php endforeach; ?>
		</div>

	</div>

	<?php if( filter_var( $atts['pagination'], FILTER_VALIDATE_BOOLEAN ) ): ?>
	<!-- If we need pagination -->
	<div class="swiper-pagination"></div>
	<?php endif; ?>

	<?php if( filter_var( $atts['pagination_arrows'], FILTER_VALIDATE_BOOLEAN ) ): ?>
	<!-- Prev / next buttons -->
	<div class="swiper-nav-btn swiper-button-prev"></div>
	<div class="swiper-nav-btn swiper-button-next"></div>
	<?php endif; ?>

</div>

<?php
	endif;
