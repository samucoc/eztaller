<?php

/**
  * Blog posts / media grid style
**/

$tpl_settings = get_query_var( 'wplab_albedo_tpl_settings');

$post_format = get_post_format();
get_template_part( 'template-parts/blog/post-formats/media-grid/post-format', $post_format ); 
