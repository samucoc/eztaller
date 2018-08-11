<?php

/**
 * Masonry layout
 * Link post format template
**/

$tpl_settings = get_query_var('wplab_albedo_tpl_settings');
?>

<?php if( filter_var( $tpl_settings['display_media'], FILTER_VALIDATE_BOOLEAN ) ): ?>
	<div class="post-media">
		<?php
			$thumb_id = get_post_thumbnail_id( get_the_ID());
			$thumb_url = wp_get_attachment_url( $thumb_id );

			if( $thumb_url <> '' ) {

				// custom thumb dimensions
				if( $tpl_settings['thumbs_dimensions']['type'] == 'crop' ) {

					$thumb_width = is_numeric( $tpl_settings['thumbs_dimensions']['crop']['thumb_width'] ) ? absint( $tpl_settings['thumbs_dimensions']['crop']['thumb_width'] ) : null;
					$thumb_height = is_numeric( $tpl_settings['thumbs_dimensions']['crop']['thumb_height'] ) ? absint( $tpl_settings['thumbs_dimensions']['crop']['thumb_height'] ) : null;

					echo wplab_albedo_media::img( array(
						'url' => $thumb_url,
						'width' => $thumb_width,
						'height' => $thumb_height,
						'lazy' => false,
						'atts' => array( 0 => 'alt="' . esc_attr( get_the_title( $thumb_id ) ) . '"')
					));

				} else {
					echo '<img src="' . esc_attr( $thumb_url ) . '" alt="" />';
				}

			}

		?>
	</div>
<?php endif; ?>

<?php if( filter_var( $tpl_settings['display_date'], FILTER_VALIDATE_BOOLEAN ) ): ?>
	<div class="post-date">
		<?php the_time( get_option('date_format') ); ?>
	</div>
<?php endif; ?>

<?php if( filter_var( $tpl_settings['display_title'], FILTER_VALIDATE_BOOLEAN ) ): ?>
	<h4 class="title"><a target="_blank" href="<?php echo strip_tags( get_the_content() ); ?>"><?php the_title(); ?></a></h4>
<?php endif; ?>

<div class="cats-link-table">
	<?php if( filter_var( $tpl_settings['display_cats'], FILTER_VALIDATE_BOOLEAN ) ): ?>
		<div class="post-categories">
			<?php echo wplab_albedo_front::get_categories(); ?>
		</div>
	<?php endif; ?>

	<?php if( filter_var( $tpl_settings['display_link'], FILTER_VALIDATE_BOOLEAN ) ): ?>
		<div class="post-link">
			<a href="<?php the_permalink(); ?>"></a>
		</div>
	<?php endif; ?>
</div>
