<?php
	/**
	 * Template for Page 404
	 **/

	get_header();
	global $wplab_albedo_core;

	/** get page 404 layout style **/
	$page_404_style = wplab_albedo_utils::get_theme_mod(
		'page_404_style',
		$wplab_albedo_core->default_options['page_404_style']
	);

	$tpl = $page_404_style == 'simple' ? 'simple' : 'default';
	$is_parallax = wplab_albedo_utils::get_theme_mod(
		'page_404_bg_img_parallax',
		$wplab_albedo_core->default_options['page_404_bg_img_parallax']
	);
?>
<div class="wrapper404">
	<?php if( filter_var( $is_parallax, FILTER_VALIDATE_BOOLEAN ) ): ?>
	<ul class="parallax-scene"
			data-invert-x="true"
			data-invert-y="true"
			data-limit-x="0"
			data-limit-y="0"
			data-scalar-x="0"
			data-scalar-y="0"
			data-friction-x="0"
			data-friction-y="0"
			data-origin-x="0"
			data-origin-y="0">
		<li class="layer layer-bg" data-depth="0.4"><div></div></li>
	</ul>
	<?php endif; ?>
	<div class="container-fluid">
		<div class="row">

			<div id="content" class="<?php echo wplab_albedo_front::get_content_classes(); ?>">

				<?php
					/** get 404 layout based on customizer options **/
					get_template_part( 'template-parts/404/404-' . $tpl );
				?>

			</div>

			<?php get_sidebar(); ?>

		</div>
	</div>
</div>
<?php get_footer();
