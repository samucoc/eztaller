<?php
/**
	* Portfolio / simple grid style
**/

$tpl_settings = get_query_var('wplab_albedo_tpl_settings');
?>

<li class="grid-item">
	<div class="item">
		<?php
			$thumb_id = get_post_thumbnail_id( get_the_ID());
			$thumb_url = wp_get_attachment_url( $thumb_id );

			if( $thumb_url <> '' ):
				?>
				<div class="thumb">
				<?php
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
				?>
					<div class="overlay"></div>

					<div class="overlay-text">
						<?php if( filter_var( $tpl_settings['display_link_icon'], FILTER_VALIDATE_BOOLEAN ) ): ?>
							<div class="post-link">
								<a href="<?php the_permalink(); ?>"><span><?php esc_html_e('View details', 'albedo'); ?></span></a>
							</div>
						<?php endif; ?>
						<?php if( filter_var( $tpl_settings['display_lightbox_icon'], FILTER_VALIDATE_BOOLEAN ) && $thumb_url <> '' ): ?>
							<div class="lightbox-link" data-src="<?php echo esc_attr( $thumb_url ); ?>">
								<a class="lightbox" href="<?php echo esc_attr( $thumb_url ); ?>"><span><?php esc_html_e('View larger', 'albedo'); ?></span></a>
							</div>
						<?php endif; ?>
					</div>

				</div>
				<?php
			endif;

		?>

		<div class="post-text">
			<?php if( filter_var( $tpl_settings['display_title'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
			<?php endif; ?>
			<?php if( filter_var( $tpl_settings['display_excerpt'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<?php
					$excerpt = get_the_excerpt();
					if( isset( $tpl_settings['excerpt_length'] ) && $tpl_settings['excerpt_length'] <> '' ) {
						$excerpt = wp_trim_words( $excerpt, absint( $tpl_settings['excerpt_length'] ) );
					}
				?>
				<div class="excerpt"><p><?php echo wp_kses_post( $excerpt ); ?></p></div>
			<?php endif; ?>
			<div class="likes-cats-table">
			<?php if( filter_var( $tpl_settings['display_cats'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<div class="post-categories">
					<?php echo wplab_albedo_front::get_categories(); ?>
				</div>
			<?php endif; ?>
			<?php if( filter_var( $tpl_settings['display_likes'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<div class="post-likes">
					<?php $voted = isset( $_COOKIE[ 'post_id_' . get_the_ID() . '_liked' ] ) ? filter_var( $_COOKIE[ 'post_id_' . get_the_ID() . '_liked' ], FILTER_VALIDATE_BOOLEAN ) : false; ?>

					<a href="javascript:;" class="<?php if( $voted ): ?>clicked<?php endif; ?> like-post" data-post-id="<?php the_ID(); ?>">
						<span>
						<?php
							$likes = absint( get_post_meta( get_the_ID(), 'likes', true ) );
							printf( _nx( '1 Like', '%1$s Likes', $likes, 'post likes', 'albedo' ), number_format_i18n( $likes ) );
						?>
						</span>
					</a>

				</div>
			<?php endif; ?>
			</div>
		</div>

	</div>
</li>
