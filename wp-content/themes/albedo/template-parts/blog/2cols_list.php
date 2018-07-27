<?php
/**
	* Blog posts / default 2 columns list style
**/

$tpl_settings = get_query_var( 'wplab_albedo_tpl_settings');
$post_format = get_post_format();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post'); ?>>
	<?php get_template_part( 'template-parts/blog/post-formats/2cols-list/post-format', $post_format ); ?>
</article>
