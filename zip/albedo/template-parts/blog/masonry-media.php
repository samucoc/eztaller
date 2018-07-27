<?php

/**
	* Blog posts / masonry media style
**/

$tpl_settings = get_query_var( 'wplab_albedo_tpl_settings');
$post_format = get_post_format();

$post_classes = array();
$post_classes[] = 'article grid-item';
$post_classes[] = 'post-format-' . esc_attr( $post_format );
$post_classes[] = 'overlay-' . esc_attr( $tpl_settings['overlay_color'] );

$thumb_id = get_post_thumbnail_id( get_the_ID());
$thumb_url = wp_get_attachment_url( $thumb_id );

if( has_post_thumbnail() ) {

	$post_classes[] = 'has-thumb';
	// custom thumb dimensions
	if( $tpl_settings['thumbs_dimensions']['type'] == 'crop' ) {

		$thumb_width = is_numeric( $tpl_settings['thumbs_dimensions']['crop']['thumb_width'] ) ? absint( $tpl_settings['thumbs_dimensions']['crop']['thumb_width'] ) : null;
		$thumb_height = is_numeric( $tpl_settings['thumbs_dimensions']['crop']['thumb_height'] ) ? absint( $tpl_settings['thumbs_dimensions']['crop']['thumb_height'] ) : null;

		$thumb_url = wplab_albedo_media::img_resize( $thumb_url, $thumb_width, $thumb_height );

	}

}

?>

<li class="<?php echo implode( ' ', $post_classes ); ?>">
	<div class="inside" style="<?php if( has_post_thumbnail() ): ?>background-image: url(<?php echo esc_attr( $thumb_url ); ?>);<?php endif; ?>">

		<div class="item">
			<div class="overlay"></div>
			<div class="post-icon"></div>
			<div class="item-content">
				<?php get_template_part( 'template-parts/blog/post-formats/masonry-media/post-format', $post_format ); ?>
			</div>
		</div>

	</div>
</li>
