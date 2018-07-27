<?php if (!defined('FW')) die('Forbidden');
if ( is_admin()){
	return;
}
/**
 * @var $atts The shortcode attributes
 */

echo '<div class="wproto-mailchimp">';
echo do_shortcode( '[mc4wp_form id="' . $atts['form_id'] . '"]' );
echo '</div>';
