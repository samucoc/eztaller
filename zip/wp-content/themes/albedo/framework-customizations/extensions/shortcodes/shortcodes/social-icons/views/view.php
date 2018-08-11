<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
if ( is_admin()){
	return;
}
?>
<p id="shortcode-<?php echo esc_attr( $atts['id'] ); ?>" class="shortcode-social-icons">
<?php

global $wplab_albedo_core;

foreach( $wplab_albedo_core->cfg['social_profiles'] as $k=>$v ):

	if( isset( $atts[ $k ] ) && $atts[ $k ] <> '' ) {
		echo '<a href="' . esc_attr( $atts[ $k ] ) . '" target="_blank"><i class="' . esc_attr( $wplab_albedo_core->cfg['social_icons'][ $k ] ) . '"></i></a>';
	}

endforeach;

?>
</p>
