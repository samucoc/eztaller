<?php
/**
 * Single portfolio post template
 **/
get_header();
global $wplab_albedo_core;

/** get post layout options from post settings **/
$post_id = get_the_ID();
$post_layout = fw_get_db_post_option( $post_id, 'single_post_layout/type' );
$single_post_style = $post_layout == 'custom' ? 'default' : fw_get_db_post_option( $post_id, 'single_post_layout/predefined/layout' );

/** load layout based on settings **/
get_template_part( 'template-parts/portfolio/single/layout-' . $single_post_style );

get_footer();
