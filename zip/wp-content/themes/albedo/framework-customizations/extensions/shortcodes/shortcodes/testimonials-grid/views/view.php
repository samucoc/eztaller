<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
	$attributes = $classes = array();

	$id = esc_attr( $atts['id'] );

	/** unique id **/
	$attributes[] = 'id="shortcode-' . $id . '"';

	$classes[] = esc_attr( $atts['effect'] );
	$classes[] = 'cols-' . absint( $atts['cols'] );

	$animated_on_hover = filter_var( $atts['animate_on_hover']['enabled'], FILTER_VALIDATE_BOOLEAN );
	$hover_animation = !empty( $atts['animate_on_hover'] ) && isset( $atts['animate_on_hover']['yes']['animation_effect'] ) ? $atts['animate_on_hover']['yes']['animation_effect'] : '';

	if( count( $atts['items'] ) > 0 ):

?>

<div class="shortcode-testimonials-grid <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>

	<ul id="testimonials-grid-<?php echo $id; ?>" class="grid">
		<?php foreach( $atts['items'] as $item ): ?>

			<?php
				$text = $item['text'];
				$author = $item['author'];
				$position = $item['position'];
				$photo = isset( $item['photo']['url'] ) ? $item['photo']['url'] : '';
			?>
			<li>
				<div class="item-content">

					<?php if( $photo <> '' ): ?>
					<div class="photo<?php if( $animated_on_hover ): ?> animate-on-hover<?php endif; ?>" data-hover-animation="<?php echo esc_attr($hover_animation); ?>">
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

				</div>
			</li>

		<?php endforeach; ?>
	</ul>

</div>

<?php
	endif;
