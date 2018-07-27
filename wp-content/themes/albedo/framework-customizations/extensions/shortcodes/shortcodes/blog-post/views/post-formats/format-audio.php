<?php

	$has_post_thumbnail = has_post_thumbnail();
	$thumb_url = '';

	if( $has_post_thumbnail ) {

		$thumb_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID()) );

		// custom thumb dimensions
		if( $atts['thumbs_dimensions']['type'] == 'crop' && $thumb_url <> '' ) {

			$thumb_width = is_numeric( $atts['thumbs_dimensions']['crop']['thumb_width'] ) ? absint( $atts['thumbs_dimensions']['crop']['thumb_width'] ) : null;
			$thumb_height = is_numeric( $atts['thumbs_dimensions']['crop']['thumb_height'] ) ? absint( $atts['thumbs_dimensions']['crop']['thumb_height'] ) : null;

			$thumb_url = wplab_albedo_media::img_resize( $thumb_url, $thumb_width, $thumb_height );

		}

	}

?>
<div class="inside <?php echo $has_post_thumbnail ? 'with-thumb' : 'without-thumb'; ?>" style="<?php if( $has_post_thumbnail ): ?>background-image: url(<?php echo esc_attr( $thumb_url ); ?>);<?php endif; ?>">
	<div class="overlay"></div>
	<div class="flexbox">
		<div class="flex-item">

			<?php if( filter_var( $atts['display_date'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<div class="post-date"><?php the_time( get_option( 'date_format') ); ?></div>
			<?php endif; ?>

			<?php if( filter_var( $atts['display_title'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
			<?php endif; ?>

			<?php if( filter_var( $atts['display_excerpt']['enabled'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<div class="post-excerpt">
					<?php
						$excerpt_length = absint( $atts['display_excerpt']['yes']['excerpt_length'] );
						echo wp_trim_words( get_the_excerpt(), $excerpt_length );
					?>
				</div>
			<?php endif; ?>

			<a href="<?php the_permalink(); ?>"><i class="post-icon"></i></a>

		</div>
	</div>
</div>
