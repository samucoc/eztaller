<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
	$id = $atts['id'];
?>

<canvas class="charts" width="100%" height="<?php echo esc_attr( $atts['height'] ); ?>" id="shortcode-<?php echo esc_attr( $id ); ?>"></canvas>
