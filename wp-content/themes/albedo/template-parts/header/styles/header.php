<?php

	/**
	 * Shared header content for similar header styles
	 **/
	global $wplab_albedo_core;

	// logo
	get_template_part( 'template-parts/header/logo' );
?>

<?php if( wplab_albedo_utils::is_unyson() ): ?>

<?php

	// side overlay menu icon / widget
	if( filter_var( wplab_albedo_utils::get_theme_mod(
		'menu_side_overlay',
		$wplab_albedo_core->default_options['menu_side_overlay']
	), FILTER_VALIDATE_BOOLEAN ) ):

		get_template_part('template-parts/header/overlay_menu');

	endif;

	// hamburger icon for responsive menus
?>

<div class="menu-layout-item item-responsive-menu-toggler">
	<a href="javascript:;" class="menu-toggler">
		<span></span>
		<span></span>
		<span></span>
		<span></span>
	</a>
</div>

<?php

	// display WooCommerce cart widget
	if( filter_var( wplab_albedo_utils::get_theme_mod(
		'menu_cart',
		$wplab_albedo_core->default_options['menu_cart']
	), FILTER_VALIDATE_BOOLEAN ) ):

		get_template_part('template-parts/header/cart');

	endif;

	// display search widget
	if( filter_var( wplab_albedo_utils::get_theme_mod(
		'menu_search',
		$wplab_albedo_core->default_options['menu_search']
	), FILTER_VALIDATE_BOOLEAN ) ):

		get_template_part('template-parts/header/search');

	endif;

	// display CTA button
	if( filter_var( wplab_albedo_utils::get_theme_mod(
		'menu_cta/enabled',
		$wplab_albedo_core->default_options['menu_cta']
	), FILTER_VALIDATE_BOOLEAN ) ):

		get_template_part('template-parts/header/cta');

	endif;

endif;
?>

<?php if( ! wplab_albedo_utils::is_unyson() ): ?>
	<div class="menu-layout-item item-responsive-menu-toggler">
		<a href="javascript:;" class="menu-toggler">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
		</a>
	</div>
<?php endif; ?>

<?php
	// menu
	$menu_style = wplab_albedo_utils::get_theme_mod(
		'menu_style/style',
		$wplab_albedo_core->default_options['menu_style']
	);

	$is_side_menu = false;

	if( $menu_style == 'minimal' ) {

		$submenu_minimal_style = wplab_albedo_utils::get_theme_mod(
			'menu_style/minimal/submenu_minimal_style',
			$wplab_albedo_core->default_options['submenu_minimal_style']
		);

		if( $submenu_minimal_style != 'style_1' ) {
			$is_side_menu = true;
		}

	}

	if( ! $is_side_menu ) {

		// if OnePage menu enabled
		$is_onepage = wplab_albedo_utils::is_unyson() && is_page() ? filter_var( fw_get_db_post_option( get_the_ID(), 'one_page_menu' ), FILTER_VALIDATE_BOOLEAN ) : false;

		wp_nav_menu( array(
			'theme_location' => $is_onepage ? 'header_onepage_menu' : 'header_menu',
			//'menu_id' => 'menu',
			'menu_class' => $is_onepage ? 'menu one-page-menu' : 'menu',
			'fallback_cb' => false,
			'container' => 'div',
			'container_class' => 'menu-layout-item item-menu'
		));

	}

?>

<div class="clearfix"></div>
