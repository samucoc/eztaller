<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
if ( is_admin()){
	return;
}
$attributes = $classes = array();

$classes[] = 'overlay-color-' . esc_attr( $atts['overlay_color'] );

$id = esc_attr( $atts['id'] );
$attributes[] = 'id="shortcode-' . $id . '"';

if( filter_var( $atts['shadows'], FILTER_VALIDATE_BOOLEAN ) ) {
	$classes[] = 'with-shadows';
}

$attributes[] = 'data-row-height="' . esc_attr( $atts['row_height'] ) . '"';
$attributes[] = 'data-max-row-height="' . esc_attr( $atts['max_row_height'] ) . '"';
$attributes[] = 'data-margins="' . esc_attr( $atts['margins'] ) . '"';
$attributes[] = 'data-captions="' . esc_attr( $atts['display_caption'] ) . '"';
$attributes[] = 'data-randomize="' . esc_attr( $atts['randomize'] ) . '"';

if( count( $atts['images'] ) > 0 ):
?>

<div class="images-gallery justified-gallery <?php echo implode(' ', $classes ); ?>" <?php echo implode( ' ', $attributes ); ?>>

	<?php foreach( $atts['images'] as $item ): ?>
	<figure data-src="<?php echo esc_attr( $item['url'] ); ?>">
		<a href="<?php echo esc_attr( $item['url'] ); ?>">
			<img alt="<?php echo esc_attr( get_the_title( $item['attachment_id'] ) ); ?>" src="<?php echo esc_attr( $item['url'] ); ?>" />
		</a>
		<figcaption class="caption"><?php echo get_the_title( $item['attachment_id'] ); ?></figcaption>
	</figure>
	<?php endforeach; ?>

</div>

<?php endif;
