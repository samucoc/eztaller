<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
	$attributes = $classes = array();

	$id = esc_attr( $atts['id'] );
	$style = $atts['element_style']['style'];

	$attributes[] = 'id="shortcode-' . $id . '"';

	if( $style == 'carousel' ) {

		$attributes[] = 'data-effect="' . esc_attr( $atts['element_style']['carousel']['effect'] ) . '"';
		$attributes[] = 'data-pagination="' . esc_attr( $atts['element_style']['carousel']['pagination'] ) . '"';
		$attributes[] = 'data-loop="' . esc_attr( $atts['element_style']['carousel']['loop'] ) . '"';

		$attributes[] = 'data-slides-num="' . absint( $atts['element_style']['carousel']['items_big'] ) . '"';
		$attributes[] = 'data-slides-medium-num="' . absint( $atts['element_style']['carousel']['items_medium'] ) . '"';
		$attributes[] = 'data-slides-small-num="' . absint( $atts['element_style']['carousel']['items_small'] ) . '"';

		if( filter_var( $atts['element_style']['carousel']['autoplay']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
			$attributes[] = 'data-autoplay="' . esc_attr( $atts['element_style']['carousel']['autoplay']['yes']['autoplay_speed'] ) . '"';
			$attributes[] = 'data-autoplay-stop-on-last="' . esc_attr( $atts['element_style']['carousel']['autoplay']['yes']['autoplay_stop_on_last'] ) . '"';
			$attributes[] = 'data-autoplay-disable-on-interaction="' . esc_attr( $atts['element_style']['carousel']['autoplay']['yes']['autoplay_disable_on_interaction'] ) . '"';
		}

	} elseif( $style == 'grid' ) {
		$cols = absint( $atts['element_style']['grid']['cols'] );
		$column = 12/$cols;

		$animated = filter_var( $atts['element_style']['grid']['animate_on_display']['enabled'], FILTER_VALIDATE_BOOLEAN );
		$animation = !empty( $atts['element_style']['grid']['animate_on_display'] ) && isset( $atts['element_style']['grid']['animate_on_display']['yes']['animation_effect'] ) ? $atts['element_style']['grid']['animate_on_display']['yes']['animation_effect'] : '';
		$animation_step = !empty( $atts['element_style']['grid']['animate_on_display'] ) && isset( $atts['element_style']['grid']['animate_on_display']['yes']['animation_step'] ) ? $atts['element_style']['grid']['animate_on_display']['yes']['animation_step'] : '';

		$classes[] = 'cols-' . $cols;
	}

	$classes[] = 'style-' . esc_attr( $style );

	if( filter_var( $atts['hover_opacity_effect'], FILTER_VALIDATE_BOOLEAN ) ) {
		$classes[] = 'hover-effect';
	}

	if( count( $atts['items'] ) > 0 ):
?>
<div class="logos-carousel <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>
	<?php if( $style == 'grid' ): ?>

		<?php $counter = 0; foreach ( $atts['items'] as $key => $item ): ?>

			<?php if( $counter % $cols == 0 ): ?>
			<div class="row">
			<?php endif; $counter++; ?>

			<div class="item col-md-<?php echo $column; ?> <?php if( $animated ): ?>wow <?php echo esc_attr( $animation ); endif; ?>" <?php if( $animated ): ?>data-wow-delay="<?php echo esc_attr( $animation_step * $counter / 2 ); ?>s"<?php endif; ?>>

				<?php
					$logo = is_array( $item['image'] ) && !empty( $item['image'] ) ? $item['image']['url'] : '';
					$logo_2x = is_array( $item['image_2x'] ) && !empty( $item['image_2x'] ) ? $item['image_2x']['url'] : $logo;
					$width = $item['image_width'] <> '' ? absint( $item['image_width'] ) : null;
					$height = $item['image_height'] <> '' ? absint( $item['image_height'] ) : null;

					echo $item['url'] <> '' ? '<a href="' . esc_attr( $item['url'] ) . '" target="_blank">' : '';

					echo wplab_albedo_media::image( $logo, $width, $height, true, false, $logo_2x, false );

					echo $item['url'] <> '' ? '</a>' : '';
				?>

			</div>

		<?php if( $counter % $cols == 0 ): ?>
		</div>
		<?php endif; ?>

		<?php endforeach; ?>

		<?php if( $counter%$cols != 0 ): ?>
		</div>
		<?php endif; ?>

	<?php elseif( $style == 'carousel' ): ?>

		<!-- Slider main container -->
		<div class="swiper-container">

			<!-- Additional required wrapper -->
			<div class="swiper-wrapper">
				<?php foreach( $atts['items'] as $item ): ?>

					<?php
						$logo = is_array( $item['image'] ) && !empty( $item['image'] ) ? $item['image']['url'] : '';
						$logo_2x = is_array( $item['image_2x'] ) && !empty( $item['image_2x'] ) ? $item['image_2x']['url'] : $logo;
						$width = $item['image_width'] <> '' ? absint( $item['image_width'] ) : null;
						$height = $item['image_height'] <> '' ? absint( $item['image_height'] ) : null;
					?>

					<div class="item swiper-slide">
						<?php
							echo $item['url'] <> '' ? '<a href="' . esc_attr( $item['url'] ) . '" target="_blank">' : '';
							echo wplab_albedo_media::image( $logo, $width, $height, true, false, $logo_2x, false );
							echo $item['url'] <> '' ? '</a>' : '';
						?>
					</div>
				<?php endforeach; ?>
			</div>

		</div>

		<?php if( filter_var( $atts['element_style']['carousel']['pagination'], FILTER_VALIDATE_BOOLEAN ) ): ?>
		<!-- If we need pagination -->
		<div class="swiper-pagination"></div>
		<?php endif; ?>

	<?php endif; ?>
</div>
<?php endif;
