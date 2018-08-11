<?php
/**
 * Sidebar template
 **/

// If Unyson Framework plugin is active
if( wplab_albedo_utils::is_unyson() && function_exists('fw_ext_sidebars_get_current_position') ) {

	// Get sidebar preset from Admin Settings
	$side_classes = array();
	$current_position = fw_ext_sidebars_get_current_position();
	$side_preset = fw_ext_sidebars_get_current_preset();

	$sidebar_size = fw_get_db_customizer_option( 'sidebar_size' );
	$sidebar_size = absint( $sidebar_size );

	$widgets_style = fw_get_db_customizer_option( 'widgets_style' );

	$side_gap = filter_var( fw_get_db_customizer_option( 'sidebar_gap' ), FILTER_VALIDATE_BOOLEAN );

	// Calculate sidebar size
	if( $sidebar_size <=0 || $sidebar_size > 5 ) {
		$sidebar_size = 3;
	}

	$side_classes[] = 'sidebar-pos-' . $current_position;
	$side_classes[] = 'col-md-' . $sidebar_size;
	$side_classes[] = 'widgets-style-' . $widgets_style;

	// If last widget should be scrolled using JavaScript
	if( filter_var( fw_get_db_customizer_option( 'scroll_last_widget/enabled' ), FILTER_VALIDATE_BOOLEAN ) ) {
		$side_classes[] = 'scroll-last-widget';
	}

	// If sidebar should be hidden for Mobiles
	if( filter_var( fw_get_db_customizer_option( 'hide_sidebar_on_mobiles' ), FILTER_VALIDATE_BOOLEAN ) ) {
		$side_classes[] = 'hide-on-phones';
	}

	/**
	 * Full means no sidebar, so if page has a sidebar ...
	 **/
	if ( $current_position !== 'full' ) {

		// If Sidebar Gap is present
		if( $side_gap && !in_array( $current_position, array( 'left_left', 'right_right', 'left_right')) ) {
			echo '<div id="sidebar-gap" class="col-md-1"></div>';
		}

		echo '<aside id="sidebar" class="aside ' . implode( ' ', $side_classes) . '">';

		// if we don't have any settings for this page, run defaults
		if( is_null( $side_preset ) || ! $side_preset ) {

			if( wplab_albedo_utils::is_woocommerce() && is_woocommerce() ) {
				dynamic_sidebar( 'sidebar-shop' );
			} elseif( is_single() && get_post_type( get_the_ID()) == 'docs' ) {
				get_template_part('/wedocs/docs-sidebar');
			} else {

				if( $current_position === 'left' ) {
					dynamic_sidebar( 'sidebar-left' );
				} else {
					dynamic_sidebar( 'sidebar-right' );
				}

			}

		} else {
			// run sidebar preset from options
			dynamic_sidebar( $side_preset['sidebars']['blue'] );
		}
		echo '</aside>';

		if( $current_position === 'left_left' || $current_position === 'right_right' || $current_position === 'left_right' ) {
			echo '<aside id="sidebar-second" class="aside ' . implode( ' ', $side_classes) . '">';
			dynamic_sidebar( $side_preset['sidebars']['yellow'] );
			echo '</aside>';
		}

	}

// If Unyson Framework is not active, just show a right sidebar
} else {

	?>
	<aside id="sidebar" class="col-md-3 widgets-style-boxed">
		<?php dynamic_sidebar( 'sidebar-right' ); ?>
	</aside>
	<?php

}
