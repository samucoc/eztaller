<?php
/**
 * Single post template
 **/
get_header();
global $wplab_albedo_core;

/** get post layout options from customizer **/
$single_post_style = wplab_albedo_utils::get_theme_mod(
	'blog_single_post_style',
	$wplab_albedo_core->default_options['blog_single_post_style']
);

/** get layout based on customizer options **/
get_template_part( 'template-parts/blog/single-' . $single_post_style . '/single');

get_footer(); 