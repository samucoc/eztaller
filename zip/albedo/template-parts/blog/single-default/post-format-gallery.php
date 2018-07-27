<?php
	/**
	 * Gallery post format template part
	 **/
 ?>
<header id="wplab-albedo-post-single-gallery" class="content-featured-image-wrapper shortcode-standard-gallery">
	<?php echo wplab_albedo_media::gallery_shortcode(); ?>
</header>
<?php
	get_template_part('template-parts/blog/single-default/post-data');
	echo strip_shortcodes( wpautop( get_the_content() ) );
