<?php
	/**
	 * Page template
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
<?php get_footer();
