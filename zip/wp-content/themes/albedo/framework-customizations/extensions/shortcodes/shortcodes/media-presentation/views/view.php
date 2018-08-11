<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
	$attributes = $classes = array();

	$id = esc_attr( $atts['id'] );

	/** unique id **/
	$attributes[] = 'id="shortcode-' . $id . '"';
	$attributes[] = 'data-pagination="' . esc_attr( $atts['pagination'] ) . '"';
	$attributes[] = 'data-loop="' . esc_attr( $atts['loop'] ) . '"';
	$attributes[] = 'data-mousewheel="' . esc_attr( $atts['mousewheel'] ) . '"';

	if( filter_var( $atts['autoplay']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
		$attributes[] = 'data-autoplay="' . esc_attr( $atts['autoplay']['yes']['autoplay_speed'] ) . '"';
		$attributes[] = 'data-autoplay-stop-on-last="' . esc_attr( $atts['autoplay']['yes']['autoplay_stop_on_last'] ) . '"';
		$attributes[] = 'data-autoplay-disable-on-interaction="' . esc_attr( $atts['autoplay']['yes']['autoplay_disable_on_interaction'] ) . '"';
	}

	if( count( $atts['items'] ) > 0 ):

?>

<div class="shortcode-presentation <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>
	<!-- Slider main container -->
	<div class="swiper-container">

		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
		<?php foreach( $atts['items'] as $item ): ?>

			<div class="swiper-slide">

				<div class="container_fluid">
					<div class="row">
						<?php
							$content_type = $item['content_type']['media_type'];
							$cover_img = isset( $item['img_src']['url'] ) ? $item['img_src']['url'] : '';
							$href_url = $content_type == 'image' ? $cover_img : $item['content_type']['video']['video_url'];
						?>

						<div class="col-md-6 col content-type-<?php echo esc_attr( $content_type ); ?> col-thumb" style="background-image: url( <?php echo esc_attr( $cover_img ); ?> )">

							<div class="overlay bg-color-<?php echo esc_attr( $atts['accent_color'] ); ?>"></div>

							<?php if( $href_url <> '' ): ?>
							<a href="<?php echo esc_attr( $href_url ); ?>" class="media-svg-lightbox" data-src="<?php echo esc_attr( $href_url ); ?>"></a>
							<?php endif; ?>

						</div>
						<div class="col-md-6 col col-text">

							<?php if( $item['title'] <> '' ): ?>
							<h2><?php echo wp_kses_post( $item['title'] ); ?></h2>
							<?php endif; ?>

							<?php if( $item['text'] <> '' ): ?>
							<div class="text"><?php echo wp_kses_post( $item['text'] ); ?></div>
							<?php endif; ?>

							<?php if( filter_var( $item['display_button']['enabled'], FILTER_VALIDATE_BOOLEAN ) && $item['display_button']['yes']['link'] <> '' ): ?>
							<a target="_blank" href="<?php echo esc_attr( $item['display_button']['yes']['link'] ); ?>" class="button style-<?php echo esc_attr( $item['display_button']['yes']['button_style'] ); ?> size-medium"><?php echo wp_kses_post( $item['display_button']['yes']['button_text'] ); ?></a>
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

</div>

<?php
	endif;
