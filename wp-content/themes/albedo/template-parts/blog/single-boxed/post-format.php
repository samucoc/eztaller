<?php
	/**
	 * Default post format template part
	 **/
?>

<?php
	get_template_part('template-parts/blog/single-boxed/post-thumb');
	get_template_part('template-parts/blog/single-boxed/post-data');
?>

<!--
	Post content
-->
<article class="content-text-wrapper">
	<?php the_content(); ?>
</article>
