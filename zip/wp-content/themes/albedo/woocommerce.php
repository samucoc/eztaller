<?php get_header(); ?>

<div class="container">
	<div class="row">

		<div id="content" class="<?php echo wplab_albedo_front::get_content_classes(); ?>">

			<?php if( is_product_category() || is_product_tag() ): ?>
				<h2><?php single_term_title(); ?></h2>
			<?php endif; ?>

			<?php woocommerce_content(); ?>

		</div>

		<?php get_sidebar(); ?>

	</div>
</div>
<?php get_footer();
