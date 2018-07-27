<?php
	/**
	 * Sub-header template part
	 * appears after menu
	 **/
	global $wplab_albedo_core;

	// do not display subheader for Slider Header Mode
	if( wplab_albedo_utils::is_unyson() && ( (is_page() && filter_var( fw_get_db_post_option( get_the_ID(), 'slider_header_mode' ), FILTER_VALIDATE_BOOLEAN )) || ( is_404() && filter_var( fw_get_db_customizer_option( 'page_404_slider_header_mode' ), FILTER_VALIDATE_BOOLEAN ) ) ) ) {
		return;
	}

	$header_layout = wplab_albedo_utils::get_theme_mod(
		'header_layout',
		$wplab_albedo_core->default_options['header_layout']
	);
?>
<div id="sub-header" class="layout-<?php echo esc_attr( $header_layout ); ?>">

	<?php

		// load header layout based on theme options

		if( in_array( $header_layout, array( 'style_1', 'style_2') ) ):

			// Layout 1 and 2 are similar by markup, just different CSS styles
			get_template_part('template-parts/header/subheader_styles/style_1_2');

		elseif( in_array( $header_layout, array( 'style_3', 'style_4') ) ):

			// Layout 2 and 3 are similar by markup, just different CSS styles
			get_template_part('template-parts/header/subheader_styles/style_3_4');

		elseif( in_array( $header_layout, array( 'style_6', 'style_7') ) ):

			// Layout 6 and 7 are similar by markup, just different CSS styles
			get_template_part('template-parts/header/subheader_styles/style_6_7');

		else:

			// different markup for all another layouts
			get_template_part('template-parts/header/subheader_styles/' . $header_layout );

		endif;
	?>

</div>
