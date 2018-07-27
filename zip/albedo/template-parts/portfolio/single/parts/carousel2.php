<?php

/**
* Portfolio simple post carousel part
**/

/** display post gallery in content? **/
$display_post_gallery = filter_var( fw_get_db_customizer_option( 'portfolio_single_display_post_gallery' ), FILTER_VALIDATE_BOOLEAN );

if( $display_post_gallery && function_exists( 'fw_ext_portfolio_get_gallery_images') ):
	$portfolio_images = fw_ext_portfolio_get_gallery_images();

	if( !empty( $portfolio_images ) ):

		$atttibutes = array();

		/** unique id **/
		$atttibutes[] = 'id="single-portfolio-carousel"';
		$atttibutes[] = 'data-pagination="yes"';
		$atttibutes[] = 'data-autoplay="5000"';
		$atttibutes[] = 'data-autoplay-stop-on-last="yes"';
		$atttibutes[] = 'data-autoplay-disable-on-interaction="yes"';
		$atttibutes[] = 'data-initial-slide="0"';
		$atttibutes[] = 'data-slides-num="1"';
		$atttibutes[] = 'data-slides-medium-num="1"';
		$atttibutes[] = 'data-slides-small-num="1"';
		?>
		<div class="shortcode-images-carousel" <?php echo implode( ' ', $atttibutes ); ?>>
			<!-- Slider main container -->
			<div class="swiper-container">

				<!-- Additional required wrapper -->
				<div class="swiper-wrapper">
				<?php foreach ( $portfolio_images as $thumbnail ): ?>

					<div class="swiper-slide">
						<div class="slide-content">

							<figure data-src="<?php echo esc_attr( $thumbnail['url'] ); ?>">
								<a href="<?php echo esc_attr( $thumbnail['url'] ); ?>">
									<img src="<?php echo esc_attr( $thumbnail['url'] ); ?>" alt="<?php echo esc_attr( get_the_title( $thumbnail['attachment_id'] ) ); ?>" />
								</a>
							</figure>

						</div>
					</div>

				<?php endforeach; ?>
				</div>

			</div>

			<!-- If we need pagination -->
			<div class="swiper-pagination"></div>

		</div>
		<?php

	endif;

endif;
