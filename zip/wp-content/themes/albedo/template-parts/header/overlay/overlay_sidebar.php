<?php
/**
 * Side overlay menu sidebar area
 **/
global $wplab_albedo_core;

if( ! wplab_albedo_utils::is_unyson() ) {
	return false;
}

if( filter_var( wplab_albedo_utils::get_theme_mod(
	'menu_side_overlay',
	$wplab_albedo_core->default_options['menu_side_overlay']
), FILTER_VALIDATE_BOOLEAN ) ):
?>

<div id="side-overlay-menu">
	<div class="overlay"></div>
	<a href="javascript:;" class="overlay-close"></a>
	<div class="widget-holder">
		<?php dynamic_sidebar( 'sidebar-menu' ); ?>
	</div>
</div>

<?php
endif;
