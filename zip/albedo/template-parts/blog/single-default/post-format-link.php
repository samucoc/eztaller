<?php
	/**
	 * Link post format template part
	 **/
?>
<div id="wplab-albedo-single-post-link" class="link-box bg-color-grey">
	<a href="<?php the_content(); ?>" class="title" target="_blank"><?php the_title(); ?></a>
	<a href="<?php the_content(); ?>" class="link" target="_blank"><?php echo wplab_albedo_utils::get_domain_name( get_the_content() ); ?></a>
</div>
