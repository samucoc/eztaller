<?php if (!defined('FW')) die('Forbidden');

/**
 * Shortcode styles
 **/

wp_dequeue_style( 'fw-shortcode-table' );

/** load static stylesheet **/
wp_enqueue_style( 'wplab-albedo-tables', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/table.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
wp_enqueue_style( 'wplab-albedo-tables-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/table_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
