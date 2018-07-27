<?php if (!defined('FW')) die('Forbidden');

global $wplab_albedo_core;

/**
 * Shortcode styles
 **/

$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

wp_dequeue_style( 'fw-shortcode-accordion' );
wp_dequeue_script( 'fw-shortcode-accordion' );

/** load stylesheet **/
wp_enqueue_style( 'wplab-albedo-accordion', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/accordion.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
wp_enqueue_style( 'wplab-albedo-accordion-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/accordion_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

/**
 * Shortcode scripts
 **/
wp_enqueue_script( 'wplab-albedo-accordion', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/accordion/static/js/scripts' . $postfix . '.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );
