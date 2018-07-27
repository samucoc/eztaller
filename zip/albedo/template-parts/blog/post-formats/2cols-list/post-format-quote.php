<?php

/**
 * Blog 2 cols list layout
 * Quote post format template
**/

$tpl_settings = get_query_var('wplab_albedo_tpl_settings');
?>

<div class="container-fluid">
	<div class="row">
		<div class="col col-md-12">

			<?php if( filter_var( $tpl_settings['display_date'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<div class="post-date">
					<?php the_time( get_option('date_format') ); ?>
				</div>
			<?php endif; ?>

			<?php if( filter_var( $tpl_settings['display_excerpt']['enabled'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<div class="post-excerpt">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>
