<?php
// Prevent direct access
if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
if ( is_admin()){
	return;
}

$css_classes = $attributes = array();

$css_classes[] = 'button';

if( isset( $atts['custom_classes'] ) && $atts['custom_classes'] <> '' ) {
	$css_classes[] = esc_attr( $atts['custom_classes'] );
}

/**
 * Custom ID
 **/
if( isset( $atts['button_id'] ) && $atts['button_id'] <> '' ) {
	$attributes[] = 'id="' . esc_attr( $atts['button_id'] ) . '"';
} else {
	$attributes[] = 'id="shortcode-' . esc_attr( $atts['id'] ) . '"';
}

/**
 * Link href
 **/
if( isset( $atts['link'] ) && $atts['link'] <> '' ) {
	$attributes[] = 'href="' . esc_attr( $atts['link'] ) . '"';
}

/**
 * Custom target
 **/
if( isset( $atts['target'] ) && $atts['target'] <> '' ) {
	$attributes[] = 'target="' . esc_attr( $atts['target'] ) . '"';
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
 * Button icon
 **/
$icon = '';
if( $atts['icon']['type'] == 'icon-font' && $atts['icon']['icon-class'] <> '' ) {
	$icon = '<i class="' . $atts['icon']['icon-class'] . '"></i>';
} elseif( $atts['icon']['type'] == 'custom-upload' ) {
	$icon = '<img src="' . $atts['icon']['url'] . '" alt="" />';
}

$icon_left = $icon_right = '';
if( isset( $atts['icon_position'] ) && $atts['icon_position'] == 'right' ) {
	$icon_right = $icon;
	$css_classes[] = 'icon-position-right';
} else {
	$icon_left = $icon;
	$css_classes[] = 'icon-position-left';
}

/**
 * Button style
 **/
if( isset( $atts['style'] ) && $atts['style'] <> '' ) {
	$css_classes[] = 'style-' . esc_attr( $atts['style'] );
}

/**
 * Button size
 **/
if( isset( $atts['size'] ) && $atts['size'] <> '' ) {
	$css_classes[] = 'size-' . esc_attr( $atts['size'] );
}

/**
 * Button label
 **/
$label = isset( $atts['label'] ) && $atts['label'] <> '' ? esc_attr( $atts['label'] ) : '';

if( $label <> '' ) {
	$css_classes = implode( ' ', $css_classes );
	$attributes = implode( ' ', $attributes );

	if( isset( $atts['align'] ) && $atts['align'] <> '' ) {
		echo '<div class="button-align-' . esc_attr( $atts['align'] ) . '">';
	}

	echo "<a {$attributes} class=\"{$css_classes}\">{$icon_left}{$label}{$icon_right}</a>";

	if( isset( $atts['align'] ) && $atts['align'] <> '' ) {
		echo '</div>';
	}

}
