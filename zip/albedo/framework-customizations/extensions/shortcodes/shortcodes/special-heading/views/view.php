<?php

// Prevent direct access
if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
if ( is_admin()){
	return;
}

$uniqid = $atts['id'];
$allowed_tags = wp_kses_allowed_html( 'post' );

/**
 * @var $atts
 */

$css_classes = $attributes = array();

$title = $atts['title'];
$title = preg_replace("/\[(.+?)\](.+?)\[\/(.+?)\]/is", '<span class="$1">$2</span>', $title );
$title = str_replace("[br]", '<br/>', $title );
$title = nl2br( $title );

/**
 * Custom CSS Classes
 **/
if( isset( $atts['custom_classes'] ) && $atts['custom_classes'] <> '' ) {
	$css_classes[] = esc_attr( $atts['custom_classes'] );
}

/**
 * Animations
 **/
if( isset( $atts['animation']['enabled'] ) && filter_var( $atts['animation']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'wow';
	$css_classes[] = $atts['animation']['yes']['effect'];
	$attributes[] = 'data-wow-delay="' . esc_attr( $atts['animation']['yes']['animation_delay'] ) . '"';
}

if( filter_var( $atts['disable_br'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'disable-br';
}

if( isset( $atts['typed_animation']['enabled'] ) && filter_var( $atts['typed_animation']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'typed';
	$css_classes[] = 'wow';
	$attributes[] = 'data-typed-speed="' . esc_attr( $atts['typed_animation']['yes']['speed'] ) . '"';
	$attributes[] = 'data-typed-delay="' . esc_attr( $atts['typed_animation']['yes']['delay'] ) . '"';
}

/**
 * Build a header
 **/
$css_classes = implode( ' ', $css_classes );
$attributes = implode( ' ', $attributes );

echo "<{$atts['heading']} id=\"shortcode-{$uniqid}\" class=\"{$css_classes}\" {$attributes}>{$title}</{$atts['heading']}>";
