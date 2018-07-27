<?php

/**
 * Masonry layout v2
 * Link post format template
**/

$tpl_settings = get_query_var('wplab_albedo_tpl_settings');
?>

<?php if( filter_var( $tpl_settings['display_date'], FILTER_VALIDATE_BOOLEAN ) ): ?>
	<div class="post-date">
		<?php the_time( get_option('date_format') ); ?>
	</div>
<?php endif; ?>

<h4 class="title"><a target="_blank" href="<?php echo strip_tags( get_the_content() ); ?>"><?php the_title(); ?></a></h4>

<i class="icon-link"></i>

<div class="post-excerpt">

	<?php
		$link = parse_url( get_the_content());
		if( isset( $link['host'] ) ):
			echo wp_kses_post( $link['host'] );
		endif;
	?>

</div>
