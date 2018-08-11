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

$classes[] = esc_attr( $atts['effect'] );

$cols = absint( $atts['cols'] );
$classes[] = 'cols-' . $cols;
$attributes[] = 'data-margins="' . absint( $atts['margins'] ) . '"';
$attributes[] = 'data-captions="' . esc_attr( $atts['display_caption'] ) . '"';

if( count( $atts['images'] ) > 0 ):
?>

<div class="images-masonry-gallery images-gallery masonry-grid <?php echo implode(' ', $classes ); ?>" <?php echo implode( ' ', $attributes ); ?>>

	<ul id="grid-id-<?php echo $id; ?>" class="grid">
		<?php foreach( $atts['images'] as $item ): ?>
		<li class="grid-item">
			<figure data-src="<?php echo esc_attr( $item['url'] ); ?>">
				<a href="<?php echo esc_attr( $item['url'] ); ?>">
					<img alt="<?php echo esc_attr( get_the_title( $item['attachment_id'] ) ); ?>" src="<?php echo esc_attr( $item['url'] ); ?>" />
				</a>
				<figcaption class="caption"><?php echo get_the_title( $item['attachment_id'] ); ?></figcaption>
			</figure>
		</li>
		<?php endforeach; ?>
	</ul>
</div>

<?php endif;
