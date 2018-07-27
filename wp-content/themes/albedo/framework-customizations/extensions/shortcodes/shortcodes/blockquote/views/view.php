<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
	$attributes = $classes = array();
	$allowed_tags = wp_kses_allowed_html('post');

	/** unique id **/
	$attributes[] = 'id="shortcode-' . esc_attr( $atts['id'] ) . '"';
?>
<blockquote class="shortcode-blockquote style-<?php echo esc_attr( $atts['style'] ); ?> <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>

	<?php if( $atts['text'] <> '' ): ?>
	<div class="text">
		<?php echo wp_kses_post( $atts['text'] ); ?>
	</div>
	<?php endif; ?>

	<?php if( $atts['author'] <> '' ): ?>
	<div class="author">
		<?php echo wp_kses_post( $atts['author'] ); ?>
	</div>
	<?php endif; ?>

	<?php if( $atts['position'] <> '' ): ?>
	<div class="position">
		<?php echo wp_kses_post( $atts['position'] ); ?>
	</div>
	<?php endif; ?>

</blockquote>
