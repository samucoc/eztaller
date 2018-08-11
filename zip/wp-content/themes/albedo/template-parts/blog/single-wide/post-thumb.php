<?php
/**
 * Post thumbnail template part
 **/
global $wplab_albedo_core;
$display_featured_image = wplab_albedo_utils::get_theme_mod(
	'blog_single_display_featured_image',
	$wplab_albedo_core->default_options['blog_single_display_featured_image']
);
?>
<?php if( filter_var( $display_featured_image, FILTER_VALIDATE_BOOLEAN ) ): ?>

	<!--
		Single featured image
	-->
	<?php
		$display_gallery = false;
		if( wplab_albedo_utils::is_unyson() ) {
			$display_gallery = filter_var( fw_get_db_post_option( get_the_ID(), 'display_gallery_instead_thumb/enabled' ), FILTER_VALIDATE_BOOLEAN );
			$gallery_images = fw_get_db_post_option( get_the_ID(), 'display_gallery_instead_thumb/yes/gallery_images' );
			$gallery_image_ids = array();
			if( !empty( $gallery_images ) ) {
				foreach( $gallery_images as $img ) {
					$gallery_image_ids[] = $img['attachment_id'];
				}
			}
		}

		if( $display_gallery && !empty( $gallery_image_ids ) ):

			echo do_shortcode( '[gallery ids="' . implode( ',', $gallery_image_ids ) . '"]' );
	?>

	<?php elseif( has_post_thumbnail() ): ?>
	<header class="content-featured-image-wrapper">
		<div class="overlay"></div>
		<?php
			echo wplab_albedo_media::img( array(
				'id' => get_post_thumbnail_id( get_the_ID() ),
				'url' => wp_get_attachment_url( get_post_thumbnail_id( get_the_ID()) ),
				'lazy' => true
			));
		?>
		<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id( get_the_ID()) ); ?>" class="zoom lightbox"></a>
	</header>
	<?php endif; ?>
<?php endif;
