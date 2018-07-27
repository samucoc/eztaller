<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
	$attributes = $classes = array();

	/** unique id **/
	$attributes[] = 'id="shortcode-' . esc_attr( $atts['id'] ) . '"';
	$attributes[] = 'href="' . esc_attr( $atts['url'] ) . '"';
	$attributes[] = 'target="' . esc_attr( $atts['target'] ) . '"';
	$classes[] = 'color-' . esc_attr( $atts['style'] );
	$classes[] = 'shadow-' . esc_attr( $atts['shadow'] );
	$classes[] = 'text-align-' . esc_attr( $atts['text_align'] );

?>

<a <?php echo implode(' ', $attributes ); ?> class="shortcode-colorful-link <?php echo implode( ' ', $classes ); ?>">
	<div class="flexbox">
		<div class="flex-item">
			<?php echo wp_kses_post( $atts['text'] ); ?>
		</div>
	</div>
</a>
