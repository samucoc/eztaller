<?php
	/**
	 * Previous / Next Post links Template Part: Thumbnails + Title style
	 **/
	$prev_post = get_previous_post();
	$next_post = get_next_post();
	if ( !empty( $prev_post)):
?>
<a href="<?php echo get_permalink( $prev_post->ID ); ?>" class="prev-post">

	<?php if( has_post_thumbnail( $prev_post->ID ) ): ?>
	<ul class="parallax-scene"
		data-invert-x="true"
		data-invert-y="true"
		data-limit-x="0"
		data-limit-y="0"
		data-scalar-x="0"
		data-scalar-y="0"
		data-friction-x="0"
		data-friction-y="0"
		data-origin-x="0"
		data-origin-y="0">
		<li class="layer layer-bg" style="background-image: url( <?php echo get_the_post_thumbnail_url( $prev_post->ID, 'full'); ?> );" data-depth="0.2"><div></div></li>
	</ul>
	<?php endif; ?>

	<span class="desc"><?php esc_html_e( 'Prev post', 'albedo'); ?></span>
	<span class="title"><?php echo $prev_post->post_title; ?></span>

</a>
<?php
	endif;
	if ( !empty( $next_post)):
?>
<a href="<?php echo get_permalink( $next_post->ID ); ?>" class="next-post">

	<?php if( has_post_thumbnail( $next_post->ID ) ): ?>
	<ul class="parallax-scene"
		data-invert-x="false"
		data-invert-y="false"
		data-limit-x="0"
		data-limit-y="0"
		data-scalar-x="0"
		data-scalar-y="0"
		data-friction-x="0"
		data-friction-y="0"
		data-origin-x="0"
		data-origin-y="0">
		<li class="layer layer-bg" style="background-image: url( <?php echo get_the_post_thumbnail_url( $next_post->ID, 'full'); ?> );" data-depth="0.2"><div></div></li>
	</ul>
	<?php endif; ?>

	<span class="desc"><?php esc_html_e( 'Next post', 'albedo'); ?></span>
	<span class="title"><?php echo $next_post->post_title; ?></span>

</a>
<?php endif;
