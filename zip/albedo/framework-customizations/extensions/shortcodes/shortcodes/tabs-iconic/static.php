<?php if (!defined('FW')) die('Forbidden');

/**
 * Shortcode styles
 **/

$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

/** load static stylesheet **/
wp_enqueue_style( 'wplab-albedo-tabs-iconic', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/tabs_iconic.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
wp_enqueue_style( 'wplab-albedo-tabs-iconic-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/tabs_iconic_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

/**
 * Shortcode scripts
 **/
wp_enqueue_script( 'wplab-albedo-tabs-iconic', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/tabs-iconic/static/js/scripts' . $postfix . '.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );
