<?php

/**
 * Masonry layout v2
 * Default post format template
**/

$tpl_settings = get_query_var('wplab_albedo_tpl_settings');
?>

<?php if( filter_var( $tpl_settings['display_media'], FILTER_VALIDATE_BOOLEAN ) ): ?>
	<div class="post-media">
		<a href="<?php the_permalink(); ?>">
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
		<div class="overlay"></div>
		</a>
	</div>
<?php endif; ?>

<?php if( filter_var( $tpl_settings['display_date'], FILTER_VALIDATE_BOOLEAN ) ): ?>
	<div class="post-date">
		<?php the_time( get_option('date_format') ); ?>
	</div>
<?php endif; ?>

<?php if( filter_var( $tpl_settings['display_title'], FILTER_VALIDATE_BOOLEAN ) ): ?>
	<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
<?php endif; ?>

<?php if( filter_var( $tpl_settings['display_excerpt']['enabled'], FILTER_VALIDATE_BOOLEAN ) ): ?>
	<div class="post-excerpt">
		<?php
			$excerpt_length = absint( $tpl_settings['display_excerpt']['yes']['excerpt_length'] );
			echo wp_trim_words( get_the_excerpt(), $excerpt_length );
		?>
	</div>
<?php endif; ?>

<?php
	$display_cats = filter_var( $tpl_settings['display_cats'], FILTER_VALIDATE_BOOLEAN );
	$display_author = filter_var( $tpl_settings['display_author'], FILTER_VALIDATE_BOOLEAN );
?>

<?php if( $display_cats || $display_author ): ?>
	<div class="post-data">
		<?php esc_html_e( 'Posted', 'albedo'); ?> <?php if( $display_cats ): esc_html_e( 'in', 'albedo'); echo ' ' . wplab_albedo_front::get_categories(); endif; ?>
		<?php if( $display_cats ): esc_html_e( 'by', 'albedo'); ?>
			<?php the_author_posts_link(); ?>
		<?php endif; ?>
	</div>
<?php endif; ?>

<?php if( filter_var( $tpl_settings['display_read_more']['enabled'], FILTER_VALIDATE_BOOLEAN ) ): ?>
	<div class="post-read-more">
		<a href="<?php the_permalink(); ?>" class="button size-small style-<?php echo esc_attr( $tpl_settings['display_read_more']['yes']['read_more_style'] ); ?>"><?php echo wp_kses_post( $tpl_settings['display_read_more']['yes']['read_more_title'] ); ?></a>
	</div>
<?php endif;
