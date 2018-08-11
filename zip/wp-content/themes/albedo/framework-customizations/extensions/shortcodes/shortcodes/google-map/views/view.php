<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
if ( is_admin()){
	return;
}
/**
 * @var $map_data_attr
 * @var $atts
 * @var $content
 * @var $tag
 */
?>
<div class="fw-map <?php if( filter_var( $atts['display_shadow'], FILTER_VALIDATE_BOOLEAN ) ): ?>shadow-color-grey<?php endif; ?>" <?php echo fw_attr_to_html($map_data_attr); ?>>
	<div class="fw-map-canvas"></div>
</div>
