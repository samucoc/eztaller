<?php
	/**
	 * Template name: No Footer
	 **/
	get_header();
?>
	<div class="container">
		<div class="row">

			<div id="content" class="<?php echo wplab_albedo_front::get_content_classes(); ?>">

				<?php the_post(); the_content(); ?>

			</div>

			<?php get_sidebar(); ?>

		</div>
	</div>
</div>
<?php wplab_albedo_front::demo_panel(); wp_footer(); ?>
</body>
</html>
