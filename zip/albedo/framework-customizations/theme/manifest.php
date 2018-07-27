<?php

	if ( ! defined( 'FW' )) {
		exit;
	}

	$manifest = array();
	$manifest['id'] = 'wplab-albedo';

	$manifest['requirements'] = array(
		'wordpress' => array(

		),
		'framework' => array(

		),
		'extensions' => array(

		)
	);

	$manifest['supported_extensions'] = array(
		//'page-builder'	=> array(),
		//'wp-shortcodes' => array(),
		'backups' 			=> array(),
		'sidebars' 			=> array(),
		'portfolio' 		=> array(),
		'breadcrumbs' 	=> array(),
		//'seo' 					=> array(),
		//'analytics' 		=> array(),
		//'social' 				=> array(),
		'megamenu'			=> array(),
		//'events' 				=> array(),
	);
