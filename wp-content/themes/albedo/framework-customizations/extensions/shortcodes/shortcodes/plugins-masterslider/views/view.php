<?php if (!defined('FW')) die('Forbidden');
if ( is_admin()){
	return;
}
/**
 * @var $atts The shortcode attributes
 */

$alias = $atts['slider_alias'];

echo '<div class="wproto-slider-container">';
echo do_shortcode( '[masterslider alias="' . $alias . '"]' );
echo '</div>';
