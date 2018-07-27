<?php
	/**
	 * Audio post format template part
	 **/
?>

<?php
	get_template_part('template-parts/blog/single-wide/post-data');
?>

<!--
	Post content
-->
<article class="content-text-wrapper">
	<div class="row-single-post-audio">
		 <?php the_content(); ?>
	</div>
</article>
