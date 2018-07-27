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

	if( $atts['element_style']['style'] == 'parallax' ) {
		$attributes[] = 'data-parallax="true"';
		$classes[] = 'overlay-color-' . $atts['element_style']['parallax']['overlay_color'];
	}

	if( count( $atts['items'] ) > 0 ):
?>

<div class="shortcode-testimonials style-<?php echo esc_attr( $atts['element_style']['style'] ); ?> <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>
	<!-- Slider main container -->
	<div class="swiper-container">

		<?php if( $atts['element_style']['style'] == 'parallax' ): ?>
		<?php $parallax_bg = isset( $atts['element_style']['parallax']['parallax_bg']['url'] ) ? $atts['element_style']['parallax']['parallax_bg']['url'] : ''; ?>
		<!-- parallax bg -->
		<div class="parallax-bg" style="background-image:url(<?php echo esc_attr( $parallax_bg ); ?>);" data-swiper-parallax="-23%"></div>
		<div class="parallax-overlay"></div>
		<?php endif; ?>

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
					<div class="slide-content">
						<?php
							/**
							 * Default style markup
							 **/
						?>
						<?php if( $atts['element_style']['style'] == 'default' ): ?>
						<?php
							$photo_width = absint( $atts['element_style']['default']['photo_width'] );
							$photo_height = absint( $atts['element_style']['default']['photo_height'] );
						?>
						<header>
							<?php if( $photo <> '' ): ?>
							<div class="photo">
								<?php echo wplab_albedo_media::image( $photo, $photo_width, $photo_height, true, true, $photo ); ?>
							</div>
							<?php endif; ?>
							<div class="header-text">
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

						</header>

						<?php if( $text <> '' ): ?>
						<div class="text">
							<?php echo wp_kses_post( $text ); ?>
						</div>
						<?php endif; ?>

						<?php
							/**
							 * Gradient style / header markup
							 **/
						?>
						<?php elseif( $atts['element_style']['style'] == 'gradient' ): ?>
						<?php
							$header_bg_image = isset( $item['photo_bg']['url'] ) ? $item['photo_bg']['url'] : '';
						?>
						<header style="<?php if( $header_bg_image <> ''): ?>background-image: url(<?php echo $header_bg_image; ?>);<?php endif; ?>">
							<div class="gradient-overlay gradient-<?php echo esc_attr( $atts['element_style']['gradient']['gradient_color'] ); ?>"></div>
							<?php if( $text <> '' ): ?>
							<div class="text">
								<?php echo wp_kses_post( $text ); ?>
							</div>
							<?php endif; ?>
							<?php if( $photo <> '' ): ?>
							<div class="photo">
								<?php echo wplab_albedo_media::image( $photo, 80, 80, true, true, $photo ); ?>
							</div>
							<?php endif; ?>
						</header>
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

						<?php
							/**
							 * All another styles markup
							 **/
						?>
						<?php else: ?>
							<?php if( $photo <> '' ): ?>
							<div class="content-photo photo">
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

						<?php endif; ?>

					</div>
				</div>

			<?php endforeach; ?>

		</div>
	</div>

	<?php if( $atts['pagination'] == 'yes' ): ?>
		<!-- If we need pagination -->
		<div class="swiper-pagination"></div>
	<?php endif; ?>

</div>
<?php endif;
