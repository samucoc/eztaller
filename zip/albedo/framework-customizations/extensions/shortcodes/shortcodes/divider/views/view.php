<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$class = $style = '';

if( 'line' === $atts['style']['ruler_type'] ) {

	if( isset( $atts['style']['line']['line_color'] ) && $atts['style']['line']['line_color'] <> '' ) {
		$class = 'bg-color-' . $atts['style']['line']['line_color'];
	}

	if( isset( $atts['style']['line']['custom_color'] ) && $atts['style']['line']['custom_color'] <> '' ) {
		$style .= 'background-color: ' . $atts['style']['line']['custom_color'] . ';';
	}

	if( isset( $atts['style']['line']['corners_radius'] ) && $atts['style']['line']['corners_radius'] <> '' ) {
		$style .= ' border-radius: ' . $atts['style']['line']['corners_radius'] . 'px;';
	}

	if( isset( $atts['style']['line']['max_width'] ) && $atts['style']['line']['max_width'] <> '' ) {
		$style .= ' max-width: ' . $atts['style']['line']['max_width'] . ';';
	}

	if( isset( $atts['style']['line']['margins'] ) && $atts['style']['line']['margins'] <> '' ) {
		$style .= ' margin-top: ' . $atts['style']['line']['margins'] . ';';
		$style .= ' margin-bottom: ' . $atts['style']['line']['margins'] . ';';
	}

}

if ( 'line' === $atts['style']['ruler_type'] ): ?>
	<div class="fw-divider-line"><hr class="<?php echo esc_attr( $class ); ?>" style="<?php echo esc_attr( $style ); ?>" /></div>
<?php endif; ?>

<?php if ( 'space' === $atts['style']['ruler_type'] ): ?>
	<div class="fw-divider-space" style="padding-top: <?php echo (int) $atts['style']['space']['height']; ?>px;"></div>
<?php endif; ?>
