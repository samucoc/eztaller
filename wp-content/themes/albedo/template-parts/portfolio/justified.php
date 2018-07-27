<?php

/**
	* Justified grid / article part
**/

$tpl_settings = get_query_var( 'wplab_albedo_tpl_settings');
?>
<article class="item">
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
	<div class="caption">
		<div class="caption-table">
			<div class="caption-cell">

				<?php if( filter_var( $tpl_settings['display_link_icon'], FILTER_VALIDATE_BOOLEAN ) ): ?>
					<div class="post-link">
						<a href="<?php the_permalink(); ?>"></a>
					</div>
				<?php endif; ?>

				<?php if( filter_var( $tpl_settings['display_hover_title'], FILTER_VALIDATE_BOOLEAN ) ): ?>
					<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				<?php endif; ?>

				<?php if( filter_var( $tpl_settings['display_hover_cats'], FILTER_VALIDATE_BOOLEAN ) ): ?>
					<div class="post-categories">
						<?php echo wplab_albedo_front::get_categories(); ?>
					</div>
				<?php endif; ?>

				<?php if( filter_var( $tpl_settings['display_hover_likes'], FILTER_VALIDATE_BOOLEAN ) ): ?>
					<div class="post-likes">
						<?php $voted = isset( $_COOKIE[ 'post_id_' . get_the_ID() . '_liked' ] ) ? filter_var( $_COOKIE[ 'post_id_' . get_the_ID() . '_liked' ], FILTER_VALIDATE_BOOLEAN ) : false; ?>
						<a href="javascript:;" class="<?php if( $voted ): ?>clicked<?php endif; ?> like-post" data-post-id="<?php the_ID(); ?>"></a>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
</article>
