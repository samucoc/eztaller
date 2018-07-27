<?php

/**
 * Blog 2 cols list layout
 * Default post format template
**/

$tpl_settings = get_query_var('wplab_albedo_tpl_settings');
$display_media = filter_var( $tpl_settings['display_media'], FILTER_VALIDATE_BOOLEAN ) && has_post_thumbnail();

$media_col_size = 'col-md-4';
$content_col_size = 'col-md-8';
$post_format = get_post_format();

if( !$display_media ) {
	$content_col_size = 'col-md-12';
}

?>

<div class="container-fluid">
	<div class="row">
		<?php if( $display_media ): ?>
			<div class="col col-media <?php echo esc_attr( $media_col_size ); ?>">
				<div class="post-media">
					<a href="<?php the_permalink(); ?>">
					<?php
						$thumb_id = get_post_thumbnail_id( get_the_ID());
						$thumb_url = wp_get_attachment_url( $thumb_id );

						if( $thumb_url <> '' ):

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
					</a>

				</div>
			</div>
		<?php endif; endif; ?>
		<div class="col <?php echo esc_attr( $content_col_size ); ?>">

			<?php if( filter_var( $tpl_settings['display_date'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<div class="post-date">
					<?php the_time( get_option('date_format') ); ?>
				</div>
			<?php endif; ?>

			<?php if( filter_var( $tpl_settings['display_title'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<?php endif; ?>

			<?php if( filter_var( $tpl_settings['display_excerpt']['enabled'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<div class="post-excerpt">
					<?php
						$excerpt_length = absint( $tpl_settings['display_excerpt']['yes']['excerpt_length'] );
						echo wp_trim_words( get_the_excerpt(), $excerpt_length );
					?>
				</div>
			<?php endif; ?>

			<?php if( filter_var( $tpl_settings['display_cats'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<div class="post-categories">
					<?php esc_html_e('In', 'albedo'); ?> <?php echo wplab_albedo_front::get_categories(); ?>
				</div>
			<?php endif; ?>

			<?php if( filter_var( $tpl_settings['display_author'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<div class="post-author">
					<?php esc_html_e('Posted by', 'albedo'); ?> <?php the_author_posts_link(); ?>
				</div>
			<?php endif; ?>

			<?php
				if( filter_var( $tpl_settings['display_likes'], FILTER_VALIDATE_BOOLEAN ) ):
					?>
					<div class="post-likes">
						<?php $voted = isset( $_COOKIE[ 'post_id_' . get_the_ID() . '_liked' ] ) ? filter_var( $_COOKIE[ 'post_id_' . get_the_ID() . '_liked' ], FILTER_VALIDATE_BOOLEAN ) : false; ?>
						<a href="javascript:;" class="<?php if( $voted ): ?>clicked<?php endif; ?> like-post" data-post-id="<?php the_ID(); ?>">
							<span><?php
								$likes_count = absint( get_post_meta( get_the_ID(), 'likes', true ) );
								printf( _nx( '1 Like', '%1$s Likes', $likes_count, 'post likes', 'albedo' ), number_format_i18n( $likes_count ) );
							?></span>
						</a>
					</div>
					<?php
				endif;

				if( filter_var( $tpl_settings['display_comments'], FILTER_VALIDATE_BOOLEAN ) ):
					?>
					<div class="post-comments">
						<a href="<?php comments_link(); ?>"><i class="icon-comments"></i> <?php comments_number( esc_html__('0 comments', 'albedo'), esc_html__('1 Comment', 'albedo'), esc_html__('% Comments', 'albedo') ); ?></a>
					</div>
					<?php
				endif;
			?>

		</div>
	</div>
</div>
