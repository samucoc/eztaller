<?php

	/**
	 * Theme functions file
	 **/

	if ( ! isset( $content_width ) ) $content_width = 320;

	// Define necessary constants
	define( '_WPLAB_ALBEDO_CACHE_TIME_', '250620180509' );

	// Instantiate base controller that will autoload
	// all application classes.
	require_once get_template_directory() . '/core/controller/core-controller.php';

	// Start the core
	global $wplab_albedo_core;
	$wplab_albedo_core = wplab_albedo_core_controller::getInstance();
	$wplab_albedo_core->run();
