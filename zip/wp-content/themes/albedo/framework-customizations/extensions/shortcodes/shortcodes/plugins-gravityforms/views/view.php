<?php if (!defined('FW')) die('Forbidden');
if ( is_admin()){
	return;
}
/**
 * @var $atts The shortcode attributes
 */


echo do_shortcode( '[gravityform id="' . $atts['form_id'] . '" title="' . $atts['display_title'] . '" description="' . $atts['display_desc'] . '" ajax="' . $atts['ajax'] . '"]' );
