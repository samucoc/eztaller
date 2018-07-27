<?php

/**
	* Blog posts / masonry style
**/

$tpl_settings = get_query_var( 'wplab_albedo_tpl_settings');
?>

<li class="article grid-item">
	<div class="inside">

		<?php $post_format = get_post_format(); ?>
		<div class="item post-format-<?php echo esc_attr( $post_format ); ?>">
			<?php get_template_part( 'template-parts/blog/post-formats/masonry/post-format', $post_format ); ?>
		</div>

	</div>
</li>
