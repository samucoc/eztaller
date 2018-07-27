<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
if ( is_admin()){
	return;
}
if ( empty( $atts['icon'] ) ) {
	return;
}

$css_classes = $icon_attributes = array();

$icon_id = 'shortcode-' . $atts['id'];

$css_classes[] = 'image-svg';

if( $atts['icon_align'] <> '' ) {
	$css_classes[] = $atts['icon_align'];
}

$skip_section = isset( $atts['skip_section'] ) && filter_var( $atts['skip_section'], FILTER_VALIDATE_BOOLEAN );

$width = is_numeric( $atts['width'] ) ? $atts['width'] : '';
$height = is_numeric( $atts['height'] ) ? $atts['height'] : '';

$animated = false;
/**
 * Animations
 **/
if( isset( $atts['animation']['enabled'] ) && filter_var( $atts['animation']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
	$animated = true;
}

?>

<?php if( $atts['icon_align'] == 'aligncenter' ): ?><div style="text-align: center;"><?php endif; ?>
<div <?php if( $animated ): ?>class="wow <?php echo esc_attr( $atts['animation']['yes']['effect'] ); ?>" data-wow-delay="<?php echo esc_attr( $atts['animation']['yes']['animation_delay'] ); ?>"<?php endif; ?> id="<?php echo esc_attr( $icon_id ); ?>">
	<?php if( $atts['link'] <> '' ): ?>
	<a href="<?php echo esc_attr( $atts['link'] ); ?>" <?php if( filter_var( $atts['is_lightbox'], FILTER_VALIDATE_BOOLEAN ) ): ?>class="media-svg-lightbox" data-src="<?php echo esc_attr( $atts['link'] ); ?>"<?php endif; ?>>
	<?php endif; ?>

	<?php if( $skip_section ): ?>
	<a href="javascript:;" class="skip-section-link">
	<?php endif; ?>

	<img src="<?php echo esc_attr( $atts['icon']['url'] ); ?>" <?php echo implode( ' ', $icon_attributes ); ?> class="<?php echo implode( ' ', $css_classes ); ?>" width="<?php echo esc_attr( $width ); ?>" height="<?php echo esc_attr( $height ); ?>" alt="" />
	<?php if( $atts['link'] <> '' || $skip_section ): ?>
	</a>
	<?php endif; ?>
</div>
<?php if( $atts['icon_align'] == 'aligncenter' ): ?></div><?php endif; ?>
