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

	$display_thumbs = filter_var( $atts['display_thumbnails'], FILTER_VALIDATE_BOOLEAN );
	$thumbs_pagination = filter_var( $atts['display_thumbnails_pagination']['enabled'], FILTER_VALIDATE_BOOLEAN );

	$classes[] = 'style-' . esc_attr( $atts['element_style']['style'] );

?>

<?php if( $thumbs_pagination ): $classes[] = 'thumbs-pagination'; $attributes[] = 'data-thumbs-id="testimonials-carousel-pagination-' . $id . '"'; ?>

<div id="testimonials-carousel-pagination-<?php echo $id; ?>" data-effect="<?php echo esc_attr( $atts['display_thumbnails_pagination']['yes']['thumb_effect'] ); ?>" class="shortcode-testimonials-carousel-thumbs-pagination">
	<a class="thumb prev-slide-thumb" href="javascript:;"></a>
	<a class="thumb current-slide-thumb" href="javascript:;"></a>
	<a class="thumb next-slide-thumb" href="javascript:;"></a>
</div>

<?php endif; ?>

<div class="shortcode-testimonials-carousel <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>
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

					<?php if( $text <> '' ): ?>
					<div class="text">
						<?php echo wp_kses_post( $text ); ?>
					</div>
					<?php endif; ?>

					<div class="about-author <?php if( $display_thumbs ): ?>with-thumb<?php endif; ?>">

						<?php if( $display_thumbs && $photo <> '' ): ?>
						<div class="photo">
							<?php echo wplab_albedo_media::image( $photo, 60, 60, true, true, $photo ); ?>
						</div>
						<?php endif; ?>

						<div class="about-author-text">
							<?php if( $author <> '' ): ?>
							<div class="author color-<?php echo esc_attr( $atts['accent_color'] ); ?>">
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
