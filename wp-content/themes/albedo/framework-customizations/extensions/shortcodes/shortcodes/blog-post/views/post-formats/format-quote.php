<div class="inside without-thumb">
	<div class="overlay"></div>
	<div class="flexbox">
		<div class="flex-item">

			<?php if( filter_var( $atts['display_date'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<div class="post-date"><?php the_time( get_option( 'date_format') ); ?></div>
			<?php endif; ?>

			<div class="post-excerpt">
				<?php the_content(); ?>
			</div>

		</div>
	</div>
</div>
