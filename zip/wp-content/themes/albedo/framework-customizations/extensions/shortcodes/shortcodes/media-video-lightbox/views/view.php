<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
if ( is_admin()){
	return;
}
if ( $atts['video'] == '' ) {
	return;
}

$img_classes = $wrapper_classes = $img_attributes = $wrapper_attributes = array();

$is_lazy = filter_var( $atts['lazy_load'], FILTER_VALIDATE_BOOLEAN );
$is_hover_effect = filter_var( $atts['hover_effects']['enabled'], FILTER_VALIDATE_BOOLEAN );

$width = is_numeric( $atts['width'] ) ? $atts['width'] : null;
$height = is_numeric( $atts['height'] ) ? $atts['height'] : null;

/** additional CSS classes **/
$img_classes[] = 'video-shortcode';
$wrapper_attributes[] = 'id="shortcode-' . esc_attr( $atts['id'] ) . '"';
$img_attributes[] = 'alt="' . esc_attr( $atts['alt'] ) . '"';

$effect = 'disabled';

if( $is_hover_effect ) {
	$effect = esc_attr( $atts['hover_effects']['yes']['effect'] );
}

if( isset( $atts['video_style'] ) ) {
	$wrapper_classes[] = 'style-' . esc_attr( $atts['video_style'] );
	$wrapper_classes[] = 'hover-effect effect-' . esc_attr( $effect );

	if( $atts['video_style'] == 'boxed_rounded' ) {
		$img_classes[] = 'box-rounded';
		$wrapper_classes[] = 'box-element box-rounded';
	} elseif( $atts['video_style'] == 'boxed' || $atts['video_style'] == 'polaroid' ) {
		$wrapper_classes[] = 'box-element box-square';
	}

}

$video_align = $atts['video_align'];

if( $video_align <> '' ) {
	$wrapper_classes[] = $video_align;
}

/** animations **/
if( isset( $atts['animation']['enabled'] ) && filter_var( $atts['animation']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
	$wrapper_classes[] = 'wow';
	$wrapper_classes[] = $atts['animation']['yes']['effect'];
	$wrapper_attributes[] = 'data-wow-delay="' . esc_attr( $atts['animation']['yes']['animation_delay'] ) . '"';
}

/** start shortcode output **/
echo $video_align == 'aligncenter' ? '<div class="aligncenter">' : '';
$wrapper_attributes[] = 'data-src="' . esc_attr( $atts['video'] ) . '"';

echo '<figure class="video-shortcode-wrapper ' . implode(' ', $wrapper_classes ) . '" ' . implode(' ', $wrapper_attributes ) . '>';

echo '<span class="img-wrapper">';

echo '<a href="' . esc_attr( $atts['video'] ) . '">';

if( !empty( $atts['image'] ) ) {
	echo wplab_albedo_media::image( $atts['image']['url'], $width, $height, true, true, $atts['image']['url'], $is_lazy, $img_classes, $img_attributes );
}

echo '</a>';

echo '</span>';

if( $atts['alt'] <> '' ) {
	echo '<figcaption>' . wp_kses_post( $atts['alt'] ) . '</figcaption>';
}

echo '</figure>';
echo $video_align == 'aligncenter' ? '</div>' : '';
