<?php
	/**
	 * Header menu template part
	**/
	global $wplab_albedo_core;

	$classes = array();

	// menu is not responsive by defaults
	$classes[] = 'header-menu-wrapper';
	$classes[] = 'responsive-mode-off';

	$slider_header_mode = false;

	// is slider header mode?
	if( wplab_albedo_utils::is_unyson() && is_page() && filter_var( fw_get_db_post_option( get_the_ID(), 'slider_header_mode' ), FILTER_VALIDATE_BOOLEAN ) ) {
		$classes[] = 'slider-header-mode';
		$slider_header_mode = true;
	}

	if( wplab_albedo_utils::get_theme_mod( 'header_layout', $wplab_albedo_core->default_options['header_layout'] ) == 'style_5' || wplab_albedo_utils::get_theme_mod( 'menu_container_bg_enabled', $wplab_albedo_core->default_options['menu_container_bg_enabled'] ) == 'no' ) {
		$classes[] = 'slider-header-mode';
		$slider_header_mode = true;
	}

	if( ! filter_var( wplab_albedo_utils::get_theme_mod( 'menu_scroll_container_bg_enabled', $wplab_albedo_core->default_options['menu_scroll_container_bg_enabled'] ), FILTER_VALIDATE_BOOLEAN ) ) {
		$classes[] = 'no-bg-slider-mode';
	}

	if( $slider_header_mode && wplab_albedo_utils::get_theme_mod( 'menu_container_display_shadow_transp_header', $wplab_albedo_core->default_options['menu_container_display_shadow_transp_header'] ) == 'no' ) {
		$classes[] = 'slider-header-mode-no-shadow';
	} elseif( $slider_header_mode && wplab_albedo_utils::get_theme_mod( 'menu_container_display_shadow_transp_header', $wplab_albedo_core->default_options['menu_container_display_shadow_transp_header'] ) == 'yes_onscroll' ) {
		$classes[] = 'slider-header-mode-shadow-onscroll';
	}

	if( filter_var( wplab_albedo_utils::get_theme_mod( 'menu_container_display_shadow', $wplab_albedo_core->default_options['menu_container_display_shadow'] ), FILTER_VALIDATE_BOOLEAN ) ) {
		$classes[] = 'header-shadow-enabled';
	} else {
		$classes[] = 'header-shadow-disabled';
	}

	// get menu layout
	$menu_style = wplab_albedo_utils::get_theme_mod(
		'menu_style/style',
		$wplab_albedo_core->default_options['menu_style']
	);

	// responsive breakpoint
	$responsive_at = wplab_albedo_utils::get_theme_mod(
		'menu_responsive_at',
		$wplab_albedo_core->default_options['menu_responsive_at']
	);

	// menu scrolling
	$scroll_menu = filter_var( wplab_albedo_utils::get_theme_mod(
		'menu_scrolling/enabled',
		$wplab_albedo_core->default_options['menu_scrolling']
	), FILTER_VALIDATE_BOOLEAN );

	if( is_single() ) {
		$dont_scroll_on_singles = filter_var( wplab_albedo_utils::get_theme_mod(
			'menu_scrolling/yes/do_not_scroll_on_singles',
			$wplab_albedo_core->default_options['do_not_scroll_on_singles']
		), FILTER_VALIDATE_BOOLEAN );

		$scroll_menu = $scroll_menu && $dont_scroll_on_singles === false;
	}

	$classes[] = $scroll_menu ? 'scroll-menu' : 'do-not-scroll-menu';

	// different scrolled height
	$menu_height = wplab_albedo_utils::get_theme_mod(
		'menu_container_height',
		$wplab_albedo_core->default_styles['menu_container_height']
	);

	$menu_scrolled_height = $menu_height;

	if( $scroll_menu ) {

		// scroll menu on mobiles?
		$classes[] = filter_var( wplab_albedo_utils::get_theme_mod(
			'menu_scrolling/yes/do_not_scroll_on_mobiles',
			$wplab_albedo_core->default_options['do_not_scroll_on_mobiles']
		), FILTER_VALIDATE_BOOLEAN ) ? 'mobile-scroll-off' : 'mobile-scroll-on';

		$menu_scrolled_height = wplab_albedo_utils::get_theme_mod(
			'menu_scrolling/yes/menu_container_height_scrolled',
			$wplab_albedo_core->default_styles['menu_container_height_scrolled']
		);

	}

?>
<header id="header-menu-wrapper" class="<?php echo implode( ' ', $classes ); ?>" data-responsive="<?php echo esc_attr( $responsive_at ); ?>" data-menu-height="<?php echo esc_attr( $menu_height ); ?>" data-menu-scrolled-height="<?php echo esc_attr( $menu_scrolled_height ); ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php get_template_part( 'template-parts/header/styles/header_' . $menu_style ); ?>
			</div>
		</div>
	</div>
</header>
