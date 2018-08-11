<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
if ( is_admin()){
	return;
}
/**
 * @var array $atts
 */
?>
<span class="custom-icon">
	<?php if( $atts['icon']['type'] == 'icon-font' ): ?>

	<i class="<?php echo esc_attr( $atts['icon']['icon-class'] ); ?>"></i>

	<?php elseif( $atts['icon']['type'] == 'custom-upload' ): ?>

	<img src="<?php echo esc_attr( $atts['icon']['url'] ); ?>" class="image-svg" alt="" />

	<?php endif; ?>
</span>
