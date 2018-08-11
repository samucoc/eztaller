<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
	$attributes = $classes = $wrapper_classes = array();

	$id = esc_attr( $atts['id'] );

	$is_hover_effect = filter_var( $atts['hover_effects']['enabled'], FILTER_VALIDATE_BOOLEAN );

	$effect = 'disabled';

	if( $is_hover_effect ) {
		$effect = esc_attr( $atts['hover_effects']['yes']['effect'] );
	}

	$wrapper_classes[] = 'hover-effect effect-' . esc_attr( $effect );

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

	$classes[] = 'images-gallery';

	$img_width = is_numeric( $atts['image_width'] ) ? absint( $atts['image_width'] ) : null;
	$img_height = is_numeric( $atts['image_height'] ) ? absint( $atts['image_height'] ) : null;

	if( count( $atts['images'] ) > 0 ):

?>

<div class="shortcode-images-carousel <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>
	<!-- Slider main container -->
	<div class="swiper-container">

		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
		<?php foreach( $atts['images'] as $item ): ?>

			<div class="swiper-slide">
				<div class="slide-content">

					<figure class="img-shortcode-wrapper <?php echo implode(' ', $wrapper_classes ); ?>" data-src="<?php echo esc_attr( $item['url'] ); ?>">
						<span class="img-wrapper">
							<a class="image-href" href="<?php echo esc_attr( $item['url'] ); ?>">
								<?php
									echo wplab_albedo_media::img( array(
										'url' => $item['url'],
										'url_hd' => $item['url'],
										'width' => $img_width,
										'height' => $img_height,
										'lazy' => false,
										'atts' => array( 0 => 'alt="' . esc_attr( get_the_title( $item['attachment_id'] ) ) . '"')
									));
								?>
							</a>
						</span>
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
