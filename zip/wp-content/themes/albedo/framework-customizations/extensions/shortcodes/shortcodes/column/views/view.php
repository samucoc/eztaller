<?php
if ( is_admin()){
	return;
}
$css_classes = $attributes = array();

$col_style = '';

$css_classes[] = 'layout-col';

/**
 * Custom CSS Classes
 **/
if( isset( $atts['section_class'] ) && $atts['section_class'] <> '' ) {
	$css_classes[] = esc_attr( $atts['section_class'] );
}

$bg_layers = false;

if( isset( $atts['column_style'] ) && $atts['column_style'] <> '' ) {
	if( $atts['column_style'] == 'boxed_rounded' ) {
		$css_classes[] = 'box-element';
	} elseif( $atts['column_style'] == 'boxed' ) {
		$css_classes[] = 'box-element box-square';
	} else {
		$css_classes[] = $atts['column_style'];
		$css_classes[] = 'wow';
		$bg_layers = true;
	}
}

if( isset( $atts['hide_bg_large_screens'] ) && filter_var( $atts['hide_bg_large_screens'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'bgimage-hidden-lg';
}

if( isset( $atts['hide_bg_medium_screens'] ) && filter_var( $atts['hide_bg_medium_screens'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'bgimage-hidden-md';
}

if( isset( $atts['hide_bg_small_screens'] ) && filter_var( $atts['hide_bg_small_screens'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'bgimage-hidden-sm';
}

if( isset( $atts['hide_bg_estra_small_screens'] ) && filter_var( $atts['hide_bg_estra_small_screens'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'bgimage-hidden-xs';
}

if( isset( $atts['hide_lg'] ) && filter_var( $atts['hide_lg'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'hidden-lg';
}

if( isset( $atts['hide_md'] ) && filter_var( $atts['hide_md'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'hidden-md';
}

if( isset( $atts['hide_sm'] ) && filter_var( $atts['hide_sm'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'hidden-sm';
}

if( isset( $atts['hide_xs'] ) && filter_var( $atts['hide_xs'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'hidden-xs';
}

/**
 * Animations
 **/
if( isset( $atts['animation']['enabled'] ) && filter_var( $atts['animation']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'wow';
	$css_classes[] = $atts['animation']['yes']['effect'];
	$attributes[] = 'data-wow-delay="' . esc_attr( $atts['animation']['yes']['animation_delay'] ) . '"';
}

/**
 * Shortcode ID
 **/
$attributes[] = 'id="shortcode-' . $atts['id'] . '"';

$class = fw_ext_builder_get_item_width( 'page-builder', $atts['width'] . '/frontend_class' );
$class = str_replace('fw-', '', $class);
/**
 * Lazy load bg image
 **/
if( filter_var( $atts['background_lazy'], FILTER_VALIDATE_BOOLEAN ) && !empty( $atts['background_image']['data']['css'] ) ) {
	$class .= ' b-lazy';
	$attributes[] = 'data-lazy-src="' . esc_attr( $atts['background_image']['data']['icon'] ) . '"';
}

?>
<div class="<?php echo esc_attr( $class ); ?> <?php echo implode( ' ', $css_classes ); ?>" <?php echo implode( ' ', $attributes ); ?>>

	<?php if( $bg_layers ): ?>
	<div class="bg-layer-1"></div>
	<div class="bg-layer-2"></div>
	<?php endif; ?>

	<?php echo do_shortcode( $content ); ?>
</div>
