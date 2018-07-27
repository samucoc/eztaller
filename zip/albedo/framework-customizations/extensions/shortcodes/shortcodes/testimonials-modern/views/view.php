<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
	$attributes = $classes = array();
	$allowed_tags = wp_kses_allowed_html('post');

	/** unique id **/
	$attributes[] = 'id="shortcode-' . esc_attr( $atts['id'] ) . '"';
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
<div class="shortcode-testimonials style-modern style-modern-<?php echo esc_attr( $atts['element_style']['style'] ); ?> <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>
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
			<div class="swiper-slide">
				<div class="slide-content wow bg-layers bg-layers-pos-<?php echo esc_attr( $atts['bg_layers_position'] ); ?>" data-wow-delay="3000">
					<div class="bg-layer-1"></div>
					<div class="bg-layer-2"></div>
					<?php if( $photo <> '' ): ?>
					<div class="photo">
						<?php echo wplab_albedo_media::image( $photo, 120, 120, true, true, $photo ); ?>
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

	<?php if( filter_var( $atts['pagination_arrows']['enabled'], FILTER_VALIDATE_BOOLEAN ) ): ?>
	<!-- Prev / next buttons -->
	<div class="swiper-nav-btn swiper-button-prev">
		<?php if( filter_var( $atts['pagination_arrows']['yes']['display_prev_name'], FILTER_VALIDATE_BOOLEAN ) ): ?>
		<span class="name"></span>
		<?php endif; ?>
		<span class="title"><?php echo wp_kses_post( $atts['pagination_arrows']['yes']['prev_title'] ); ?></span>
	</div>
	<div class="swiper-nav-btn swiper-button-next">
		<?php if( filter_var( $atts['pagination_arrows']['yes']['display_next_name'], FILTER_VALIDATE_BOOLEAN ) ): ?>
		<span class="name"></span>
		<?php endif; ?>
		<span class="title"><?php echo wp_kses_post( $atts['pagination_arrows']['yes']['next_title'] ); ?></span>
	</div>
	<?php endif; ?>

</div>
<?php
	endif;
