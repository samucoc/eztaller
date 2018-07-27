<?php if (!defined('FW')) die('Forbidden');
if ( is_admin()){
	return;
}
/**
 * @var $atts The shortcode attributes
 */

$id = $atts['docs_id'];
$more_title = $atts['read_more_title'];

echo '<div class="wproto-wedocs">';
echo do_shortcode( '[wedocs cols="1" include="' . $id . '"]' );
echo '</div>';
