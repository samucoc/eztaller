<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
if ( is_admin()){
	return;
}
if ( empty( $atts['image'] ) ) {
	return;
}

$img_classes = $wrapper_classes = $img_attributes = $wrapper_attributes = array();

/** image properties **/
$is_link = filter_var( $atts['add_link']['enabled'], FILTER_VALIDATE_BOOLEAN ) && $atts['add_link']['yes']['url'] <> '';
$is_lightbox = filter_var( $atts['add_link']['no']['lightbox'], FILTER_VALIDATE_BOOLEAN );

$is_lazy = filter_var( $atts['lazy_load'], FILTER_VALIDATE_BOOLEAN );
$is_hover_effect = filter_var( $atts['hover_effects']['enabled'], FILTER_VALIDATE_BOOLEAN );

$width = is_numeric( $atts['width'] ) ? $atts['width'] : null;
$height = is_numeric( $atts['height'] ) ? $atts['height'] : null;

/** additional CSS classes **/
$img_classes[] = 'img-shortcode';
$wrapper_attributes[] = 'id="shortcode-' . esc_attr( $atts['id'] ) . '"';
$img_attributes[] = 'alt="' . esc_attr( $atts['alt'] ) . '"';

$effect = 'disabled';

if( $is_hover_effect ) {
	$effect = esc_attr( $atts['hover_effects']['yes']['effect'] );
}

if( isset( $atts['image_style'] ) ) {
	$wrapper_classes[] = 'style-' . esc_attr( $atts['image_style'] );
	$wrapper_classes[] = $effect == 'disabled' ? 'effect-disabled' : 'hover-effect effect-' . esc_attr( $effect );

	if( $atts['image_style'] == 'boxed_rounded' ) {
		$img_classes[] = 'box-rounded';
		$wrapper_classes[] = 'box-element box-rounded';
	} elseif( $atts['image_style'] == 'boxed' || $atts['image_style'] == 'polaroid' ) {
		$wrapper_classes[] = 'box-element box-square';
	}

}

$image_align = $atts['image_align'];

if( $image_align <> '' ) {
	$wrapper_classes[] = $image_align;
}

/** animations **/
if( isset( $atts['animation']['enabled'] ) && filter_var( $atts['animation']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
	$wrapper_classes[] = 'wow';
	$wrapper_classes[] = $atts['animation']['yes']['effect'];
	$wrapper_attributes[] = 'data-wow-delay="' . esc_attr( $atts['animation']['yes']['animation_delay'] ) . '"';
}

/** href **/
$href_url = $atts['image']['url'];

if( $is_link || $is_lightbox ) {
	$href_url = $is_link && $atts['add_link']['yes']['url'] <> '' ? $atts['add_link']['yes']['url'] : $atts['image']['url'];
	$wrapper_attributes[] = 'data-src="' . esc_attr( $href_url ) . '"';
}

/** start shortcode output **/
echo $image_align == 'aligncenter' ? '<div class="aligncenter img-aligncenter-wrapper">' : '';
echo '<figure class="img-shortcode-wrapper ' . implode(' ', $wrapper_classes ) . '" ' . implode(' ', $wrapper_attributes ) . '>';
echo '<span class="img-wrapper">';

if( $is_link || $is_lightbox ) {

	$href_url = $is_link && $atts['add_link']['yes']['url'] <> '' ? $atts['add_link']['yes']['url'] : $atts['image']['url'];
	echo '<a target="' . esc_attr( $atts['add_link']['yes']['target'] ) . '" href="' . esc_attr( $href_url ) . '" class="image-href">';
}

echo wplab_albedo_media::image( $atts['image']['url'], $width, $height, true, true, $atts['image']['url'], $is_lazy, $img_classes, $img_attributes );

if( $is_link || $is_lightbox ) {
	echo '</a>';
}

echo '</span>';

if( $atts['alt'] <> '' ) {
	echo '<figcaption>' . wp_kses_post( $atts['alt'] ) . '</figcaption>';
}

echo '</figure>';
echo $image_align == 'aligncenter' ? '</div>' : '';
