<?php

/**
 * Blog 2 cols list layout
 * Link post format template
**/

$tpl_settings = get_query_var('wplab_albedo_tpl_settings');
?>

<div class="post-excerpt">

	<?php if( filter_var( $tpl_settings['display_date'], FILTER_VALIDATE_BOOLEAN ) ): ?>
		<div class="post-date">
			<?php the_time( get_option('date_format') ); ?>
		</div>
	<?php endif; ?>

	<?php if( filter_var( $tpl_settings['display_title'], FILTER_VALIDATE_BOOLEAN ) ): ?>
	<h4 class="title"><a target="_blank" href="<?php echo strip_tags( get_the_content() ); ?>"><?php the_title(); ?></a></h4>
	<?php endif; ?>

	<?php
		$link = parse_url( get_the_content());
		if( isset( $link['host'] ) ):
	?>
	<div class="excerpt">
		<?php echo wp_kses_post( $link['host'] ); ?>
	</div>
	<?php endif; ?>

</div>
