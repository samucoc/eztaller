<?php
	/**
	 * Video post format template part
	 **/
?>

<?php
	global $wplab_albedo_core;
	get_template_part('template-parts/blog/single-boxed/post-thumb');
	get_template_part('template-parts/blog/single-boxed/post-data');
?>

<!--
	Post content
-->
<article class="content-text-wrapper">
	<?php
		if( wplab_albedo_utils::get_theme_mod(
			'blog_single_display_featured_image',
			$wplab_albedo_core->default_options['blog_single_display_featured_image']
		) ) {
			echo preg_replace('/\b(https?):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', get_the_content());
		} else {
			the_content();
		}
	?>
</article>
