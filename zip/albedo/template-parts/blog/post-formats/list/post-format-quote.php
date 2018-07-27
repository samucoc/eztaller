<?php

/**
 * List layout
 * Quote post format template
**/

$tpl_settings = get_query_var('wplab_albedo_tpl_settings');
?>

<div class="post-excerpt">

	<?php if( filter_var( $tpl_settings['display_date'], FILTER_VALIDATE_BOOLEAN ) ): ?>
		<div class="post-date">
			<?php the_time( get_option('date_format') ); ?>
		</div>
	<?php endif; ?>

	<?php the_content(); ?>
</div>
