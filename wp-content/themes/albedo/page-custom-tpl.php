<?php
	/**
	 * Custom template for archives / taxonomies
	 **/

	get_header();
?>

<div class="container">
	<div class="row">

		<div id="content" class="<?php echo wplab_albedo_front::get_content_classes(); ?>">

			<?php

				$page_id = get_query_var('wplab_albedo_custom_tpl_id');

				if( function_exists( 'fw_ext_page_builder_is_builder_post') && fw_ext_page_builder_is_builder_post( $page_id ) ) {
					echo apply_filters( 'the_content', fw_ext_page_builder_get_post_content( $page_id ) );
				} else {
					echo get_the_content( $page_id );
				}

			?>

		</div>

		<?php get_sidebar(); ?>

	</div>
</div>
<?php get_footer();
