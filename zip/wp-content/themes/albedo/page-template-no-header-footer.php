<?php
	/**
	 * Template name: No Header, No Footer
	 **/
?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php
	/**
	 * Display page preloader
	 * this function located at /wproto/helper/front.php
	 **/
	wplab_albedo_front::preloader();
?>

	<div id="wrap">
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
