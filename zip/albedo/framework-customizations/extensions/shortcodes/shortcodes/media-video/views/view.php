<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
if ( is_admin()){
	return;
}
/**
 * @var array $atts
 */
global $wp_embed;
$iframe = $wp_embed->run_shortcode( '[embed]' . esc_attr( trim( $atts['url'] ) ) . '[/embed]' );

?>
<div class="responsive-video-wrapper">
	<?php echo do_shortcode( $iframe ); ?>
</div>
