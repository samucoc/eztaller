<?php
	/**
	 * Quote Post Format template part
	 **/
?>

<?php
	get_template_part('template-parts/blog/single-default/post-thumb');
	get_template_part('template-parts/blog/single-default/post-data');
?>

<!--
	Post content
-->
<article class="content-text-wrapper">
	<div class="single-blockquote-wrapper">
		<?php the_content(); ?>
	</div>
</article>
