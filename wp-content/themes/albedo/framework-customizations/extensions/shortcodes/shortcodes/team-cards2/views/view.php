<?php
	if (!defined('FW')) die('Forbidden');
	if ( is_admin()){
		return;
	}
	$attributes = $classes = array();
	$id = esc_attr( $atts['id'] );

	$attributes[] = 'id="shortcode-' . $id . '"';

	$attributes[] = 'data-effect="' . esc_attr( $atts['effect'] ) . '"';
	$attributes[] = 'data-pagination="' . esc_attr( $atts['pagination'] ) . '"';
	$attributes[] = 'data-loop="' . esc_attr( $atts['loop'] ) . '"';

	$attributes[] = 'data-slides-num="' . absint( $atts['items_big'] ) . '"';
	$attributes[] = 'data-slides-medium-num="' . absint( $atts['items_medium'] ) . '"';
	$attributes[] = 'data-slides-small-num="' . absint( $atts['items_small'] ) . '"';

	$attributes[] = 'data-start-slide="' . absint( $atts['slide_start'] ) . '"';

	if( filter_var( $atts['autoplay']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
		$attributes[] = 'data-autoplay="' . esc_attr( $atts['autoplay']['yes']['autoplay_speed'] ) . '"';
		$attributes[] = 'data-autoplay-stop-on-last="' . esc_attr( $atts['autoplay']['yes']['autoplay_stop_on_last'] ) . '"';
		$attributes[] = 'data-autoplay-disable-on-interaction="' . esc_attr( $atts['autoplay']['yes']['autoplay_disable_on_interaction'] ) . '"';
	}

	if( count( $atts['items'] ) > 0 ):
?>
<div class="team-cards2 <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>

	<!-- Slider main container -->
	<div class="swiper-container">

		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
		<?php foreach( $atts['items'] as $item ): ?>
			<div class="swiper-slide">
				<div class="item-content">

					<?php
						$text = $item['free_text'];
						$name = $item['name'];
						$position = $item['position'];
						$photo = isset( $item['photo']['data']['icon'] ) ? $item['photo']['data']['icon'] : '';
					?>

					<div class="photo">
						<?php if( $photo <> '' ): ?>
							<?php
								$img_width = absint( $atts['img_width'] );
								$img_height = absint( $atts['img_height'] );
								echo wplab_albedo_media::image( $photo, $img_width, $img_height, true, true, $photo );
							?>
						<?php endif; ?>
					</div>

					<div class="text-content">

						<div class="text-inside">
							<?php if( $name <> '' ): ?>
							<div class="name">
								<?php echo wp_kses_post( $name ); ?>
							</div>
							<?php endif; ?>

							<?php if( $position <> '' ): ?>
							<div class="position">
								<?php echo wp_kses_post( $position ); ?>
							</div>
							<?php endif; ?>

							<div class="toggle-text">
								<?php if( $text <> '' ): ?>
								<div class="text">
									<?php echo wp_kses_post( $text ); ?>
								</div>
								<?php endif; ?>

								<div class="social">
								<?php wplab_albedo_front::print_fa_icons( $item ); ?>
								</div>
							</div>
						</div>

					</div>

				</div>
			</div>
		<?php endforeach; ?>
		</div>

		<?php if( filter_var( $atts['pagination'], FILTER_VALIDATE_BOOLEAN ) ): ?>
		<!-- If we need pagination -->
		<div class="swiper-pagination"></div>
		<?php endif; ?>

	</div>

</div>
<?php endif;
