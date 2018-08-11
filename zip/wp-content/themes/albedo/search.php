<?php
	/**
	 * Page for posts default template
	 **/
	// get page header
	get_header();

	// shortcode template settings
	$tpl_settings = array(
		'pagination' => array(
			'enabled' => 'yes',
			'yes' => array(
				'pagination_style' => 'number'
			)
		),
		'display_media' => 'yes',
		'display_likes' => 'no',
		'display_comments' => 'no',
		'display_date' => 'yes',
		'display_title' => 'yes',
		'display_excerpt' => array(
			'enabled' => 'yes',
			'yes' => array(
				'excerpt_length' => 13
			)
		),
		'display_cats' => 'no',
		'display_author' => 'yes',
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

			<div id="shortcode-blog-primary" class="shortcode-blog-2cols">

				<div id="posts-container-id-primary" class="posts-container">

					<?php if( have_posts() ): while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'template-parts/blog/2cols_list' ); ?>

					<?php endwhile; endif; ?>
				</div>

				<?php get_template_part( 'template-parts/pagination/style_number' ); ?>

			</div>

		</div>

		<?php get_sidebar(); ?>

	</div>
</div>
<?php get_footer();
