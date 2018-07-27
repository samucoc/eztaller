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

	$dropcap = filter_var( $atts['dropcap']['enabled'], FILTER_VALIDATE_BOOLEAN );

	if( $dropcap ) {
		echo '<div class="dropcap style-' . esc_attr( $atts['dropcap']['yes']['style'] ) . '">';
	}

	echo do_shortcode( $atts['text'] );

	if( $dropcap ) {
		echo '</div>';
	}
