<!--
	POST GALLERY SHORTCODE VIEW
-->
<?php
	$atttibutes = array();
	$atttibutes[] = 'id="wplab-albedo-post-single-gallery"';
	$atttibutes[] = 'data-effect="fade"';
	$atttibutes[] = 'data-pagination="yes"';
	$atttibutes[] = 'data-loop="yes"';

	$slides_num = isset( $data['params']['slides_num'] ) ? $data['params']['slides_num'] : 1;
	$slides_medium_num = isset( $data['params']['slides_medium_num'] ) ? $data['params']['slides_medium_num'] : 1;
	$slides_small_num = isset( $data['params']['slides_small_num'] ) ? $data['params']['slides_small_num'] : 1;
	$initial_slide = isset( $data['params']['initial_slide'] ) ? $data['params']['initial_slide'] : 0;

	$atttibutes[] = 'data-slides-per-view="' . esc_attr( $slides_num ) . '"';
	$atttibutes[] = 'data-slides-per-view-medium="' . esc_attr( $slides_medium_num ) . '"';
	$atttibutes[] = 'data-slides-per-view-small="' . esc_attr( $slides_small_num ) . '"';
	$atttibutes[] = 'data-initial-slide="' . esc_attr( $initial_slide ) . '"';

?>
<div class="shortcode-standard-gallery post-gallery-carousel" <?php echo implode( ' ', $atttibutes ); ?>>
	<div class="swiper-container">
		<div class="swiper-wrapper">
			<?php foreach( $data['items'] as $item ): ?>
			<div class="swiper-slide">
				<div class="slide-content">
					<?php
						$image = wp_get_attachment_image_src( $item->ID, 'full' );
						echo wplab_albedo_media::image( $image[0], 1070, 600, true, true, $image[0], false );
					?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="swiper-pagination"></div>

</div>
