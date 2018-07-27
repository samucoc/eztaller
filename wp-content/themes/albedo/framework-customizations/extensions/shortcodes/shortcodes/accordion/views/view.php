<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
if ( is_admin()){
	return;
}
?>
<div class="theme-accordion style-<?php echo esc_attr( $atts['style'] ); ?>">
	<?php $i=0; foreach ( $atts['items'] as $toggle ) : ?>
		<div class="item">
			<h4 class="toggle-header">
				<?php echo do_shortcode( $toggle['title'] ) ?>
			</h4>
			<div class="toggle-content">
				<?php echo do_shortcode( $toggle['content'] ) ?>
			</div>
		</div>
	<?php $i++; endforeach; ?>
</div>
