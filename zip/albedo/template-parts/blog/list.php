<?php

	/**
		* Blog posts / default list style
	**/

	$tpl_settings = get_query_var( 'wplab_albedo_tpl_settings');
	$post_format = get_post_format();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post'); ?>>
	<?php get_template_part( 'template-parts/blog/post-formats/list/post-format', $post_format ); ?>
</article>
