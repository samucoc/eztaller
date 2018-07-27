<?php
	/**
	 * Portfolio archive template
	**/
	// get page header
	get_header();

	// shortcode template settings
	$tpl_settings = array(
		'filters' => array(
			'enabled' => 'no'
		),
		'pagination' => array(
			'enabled' => 'yes',
			'yes' => array(
				'pagination_style' => 'number'
			)
		),
		'display_hover_title' => 'yes',
		'display_hover_cats' => 'no',
		'display_link_icon' => 'yes',
		'display_hover_likes' => 'no',
		'desc_position' => 'center',
		'overlay_color' => 'blue',
		'display_shadow' => 'yes',
		'display_layers' => 'no',
		'thumbs_dimensions' => array(
			'type' => ''
		)
	);

	// set template settings, they will be used in shortcode tpls
	set_query_var( 'wplab_albedo_tpl_settings', $tpl_settings );

?>

<div class="container">
	<div class="row">

		<div id="content" class="<?php echo wplab_albedo_front::get_content_classes(); ?>">

			<div id="shortcode-portfolio-primary" class="portfolio-masonry-shortcode">

				<div id="posts-container-id-primary" class="portfolio-masonry-posts masonry-grid text-pos-center layers-hidden overlay-blue cols-2 medium-cols-2 small-cols-1 effect-1">

					<ul data-grid-margins="40" id="grid-id-primary" class="grid">

						<?php if( have_posts() ): while ( have_posts() ) : the_post(); ?>

							<?php get_template_part( 'template-parts/portfolio/masonry' ); ?>

						<?php endwhile; endif; ?>
					</ul>

				</div>

				<?php get_template_part( 'template-parts/pagination/style_number' ); ?>

			</div>

		</div>

		<?php get_sidebar(); ?>

	</div>
</div>
<?php get_footer();
