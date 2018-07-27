<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}

	$attributes = $classes = array();
	$allowed_tags = wp_kses_allowed_html('post');

	/** unique id **/
	$attributes[] = 'id="shortcode-' . esc_attr( $atts['id'] ) . '"';
	/**
	 * Lazy load bg image
	 **/
	if( filter_var( $atts['background_lazy'], FILTER_VALIDATE_BOOLEAN ) && !empty( $atts['photo']['url'] ) ) {
		$classes[] = 'b-lazy';
		$attributes[] = 'data-lazy-src="' . esc_attr( $atts['photo']['url'] ) . '"';
	}

?>

<blockquote class="shortcode-quote style-<?php echo esc_attr( $atts['style'] ); ?> <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>

	<?php if( $atts['text'] <> '' ): ?>
	<div class="text wow <?php echo esc_attr( $atts['text_animation_effect']); ?>" data-wow-delay="<?php echo esc_attr( $atts['text_animation_delay']); ?>">
		<?php echo wp_kses_post( $atts['text'] ); ?>
	</div>
	<?php endif; ?>

	<?php
		$signature = isset( $atts['signature']['url'] ) ? $atts['signature']['url'] : '';
		if( $signature <> '' ):
	?>
	<div class="signature wow <?php echo esc_attr( $atts['sign_animation_effect']); ?>" data-wow-delay="<?php echo esc_attr( $atts['sign_animation_delay']); ?>">
		<?php echo wplab_albedo_media::image( $signature, null, null, true, true, $signature ); ?>
	</div>
	<?php endif; ?>

	<?php if( $atts['author'] <> '' ): ?>
	<div class="author wow <?php echo esc_attr( $atts['author_animation_effect']); ?>" data-wow-delay="<?php echo esc_attr( $atts['author_animation_delay']); ?>">
		<?php echo wp_kses_post( $atts['author'] ); ?>
	</div>
	<?php endif; ?>

	<?php if( $atts['position'] <> '' ): ?>
	<div class="position wow <?php echo esc_attr( $atts['position_animation_effect']); ?>" data-wow-delay="<?php echo esc_attr( $atts['position_animation_delay']); ?>">
		<?php echo wp_kses_post( $atts['position'] ); ?>
	</div>
	<?php endif; ?>

</blockquote>
