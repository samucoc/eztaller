<?php if (!defined('FW')) die('Forbidden');
if ( is_admin()){
	return;
}
/**
 * @var $atts The shortcode attributes
 */


echo do_shortcode( '[layerslider id="' . $atts['slider_id'] . '"]' );
