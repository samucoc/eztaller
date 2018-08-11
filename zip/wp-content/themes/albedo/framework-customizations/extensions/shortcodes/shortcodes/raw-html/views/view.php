<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
if ( is_admin()){
	return;
}
/**
 * @var array $atts
 */
?>
<?php

	echo trim( do_shortcode( $atts['html'] ) );
