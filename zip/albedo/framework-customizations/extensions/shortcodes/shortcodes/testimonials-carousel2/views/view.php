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

	$attributes[] = 'data-slides-num="' . absint( $atts['items_big'] ) . '"';
	$attributes[] = 'data-slides-medium-num="' . absint( $atts['items_medium'] ) . '"';
	$attributes[] = 'data-slides-small-num="' . absint( $atts['items_small'] ) . '"';

	if( filter_var( $atts['autoplay']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
		$attributes[] = 'data-autoplay="' . esc_attr( $atts['autoplay']['yes']['autoplay_speed'] ) . '"';
		$attributes[] = 'data-autoplay-stop-on-last="' . esc_attr( $atts['autoplay']['yes']['autoplay_stop_on_last'] ) . '"';
		$attributes[] = 'data-autoplay-disable-on-interaction="' . esc_attr( $atts['autoplay']['yes']['autoplay_disable_on_interaction'] ) . '"';
	}

	$classes[] = 'style-' . esc_attr( $atts['element_style']['style'] );

	if( count( $atts['items'] ) > 0 ):

?>

<div class="shortcode-testimonials-carousel2 <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>
	<!-- Slider main container -->
	<div class="swiper-container">

		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
		<?php foreach( $atts['items'] as $item ): ?>

			<?php
				$text = $item['text'];
				$author = $item['author'];
				$position = $item['position'];
				$photo = isset( $item['photo']['url'] ) ? $item['photo']['url'] : '';
			?>
			<div class="swiper-slide" data-img-url="<?php echo esc_attr( $photo ); ?>">
				<div class="slide-content">

					<?php if( $photo <> '' ): ?>
					<div class="photo">
						<?php echo wplab_albedo_media::image( $photo, 100, 100, true, true, $photo ); ?>
					</div>
					<?php endif; ?>

					<?php if( $text <> '' ): ?>
					<div class="text">
						<?php echo wp_kses_post( $text ); ?>
					</div>
					<?php endif; ?>

					<div class="about-author">
						<?php if( $author <> '' ): ?>
						<div class="author">
							<?php echo wp_kses_post( $author ); ?>
						</div>
						<?php endif; ?>
						<?php if( $position <> '' ): ?>
						<div class="position">
							<?php echo wp_kses_post( $position ); ?>
						</div>
						<?php endif; ?>
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
