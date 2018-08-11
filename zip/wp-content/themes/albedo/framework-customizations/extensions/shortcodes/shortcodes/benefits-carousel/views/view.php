<?php
	if (!defined('FW')) die( 'Forbidden' );
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

	$attributes[] = 'data-initial-slide="' . absint( $atts['initial_slide'] ) . '"';

	if( filter_var( $atts['autoplay']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
		$attributes[] = 'data-autoplay="' . esc_attr( $atts['autoplay']['yes']['autoplay_speed'] ) . '"';
		$attributes[] = 'data-autoplay-stop-on-last="' . esc_attr( $atts['autoplay']['yes']['autoplay_stop_on_last'] ) . '"';
		$attributes[] = 'data-autoplay-disable-on-interaction="' . esc_attr( $atts['autoplay']['yes']['autoplay_disable_on_interaction'] ) . '"';
	}

	if( count( $atts['items'] ) > 0 ):
?>
<div class="shortcode-benefits-carousel <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>
	<!-- Slider main container -->
	<div class="swiper-container">

		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
		<?php foreach( $atts['items'] as $item ): ?>
			<div class="swiper-slide <?php echo $item['icon_type']['benefit_icon'] == '' ? 'no-icon' : ''; ?>">
				<div class="slide-inside">
					<div class="icon-box">
						<?php if( $item['icon_type']['benefit_icon'] == 'fontawesome' ): ?>

						<div class="icon">
							<i class="<?php echo esc_attr( $item['icon_type']['fontawesome']['icon'] ); ?>"></i>
						</div>

						<?php elseif( $item['icon_type']['benefit_icon'] == 'custom' ): ?>

						<div class="icon">
							<?php wplab_albedo_media::image_src( $item['icon_type']['custom']['icon'] ); ?>
						</div>

						<?php endif; ?>
					</div>

					<div class="benefit-text">
						<?php if( $item['link'] <> '' ): ?>
						<a target="<?php echo esc_attr( $atts['link_target'] ); ?>" href="<?php echo esc_attr( $item['link'] ); ?>">
						<?php endif; ?>

						<?php if( $item['title'] <> '' ): ?>
						<h4><?php echo wp_kses_post( $item['title'] ); ?></h4>
						<?php endif; ?>

						<?php if( $item['link'] <> '' ): ?>
						</a>
						<?php endif; ?>

						<?php if( $item['text'] <> '' ): ?>
						<div class="desc"><?php echo wp_kses_post( $item['text'] ); ?></div>
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

</div>
<?php endif;
