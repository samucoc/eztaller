<?php
/**
 * Minimal menu style template
 * (logo, menu icon)
 **/

global $wplab_albedo_core;

$overlay_menu_class = '';

$submenu_minimal_style = wplab_albedo_utils::get_theme_mod(
	'menu_style/minimal/submenu_minimal_style',
	$wplab_albedo_core->default_options['submenu_minimal_style']
);

if( $submenu_minimal_style != 'style_1' ) {
	$overlay_menu_class = 'minimal-overlay-menu';
}

?>
<div class="header-menu minimal <?php echo esc_attr( $overlay_menu_class ); ?>">
	<?php get_template_part( 'template-parts/header/styles/header'); ?>
</div>
