<?php
/**
 * Single post template
 **/
get_header();

?>
<div id="post-<?php the_ID(); ?>" <?php post_class( 'single-blog-post-container' ); ?>>
	<div class="container">

		<div class="row">

			<div id="content" class="<?php echo wplab_albedo_front::get_content_classes(); ?>">

				<article class="content-wrapper single-benefit">

					<?php the_post(); the_content(); ?>

					<?php endwhile; endif; ?>

				</article>

			</div>

			<?php get_sidebar(); ?>

		</div>

	</div>
</div>
<?php

get_footer();
