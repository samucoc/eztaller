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
<div class="custom-shortcode-wrapper">
<?php echo apply_filters( 'the_content', $atts['shortcode'] ); ?>
</div>
