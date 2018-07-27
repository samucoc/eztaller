<?php

/**
 * Masonry Media layout
 * Default post format template
**/

$tpl_settings = get_query_var('wplab_albedo_tpl_settings');
?>

<header>
	<div class="header-table">
		<?php if( filter_var( $tpl_settings['display_author'], FILTER_VALIDATE_BOOLEAN ) ): ?>
			<div class="header-col post-author">
				<div class="image">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 100 ); ?>
				</div>
				<div class="text">
					<?php esc_html_e( 'Posted by', 'albedo'); ?>
					<span class="name">
						<?php the_author_link(); ?>
					</span>
				</div>
			</div>
		<?php endif; ?>
		<?php if( filter_var( $tpl_settings['display_likes'], FILTER_VALIDATE_BOOLEAN ) ): ?>
			<div class="header-col post-likes">
				<?php $voted = isset( $_COOKIE[ 'post_id_' . get_the_ID() . '_liked' ] ) ? filter_var( $_COOKIE[ 'post_id_' . get_the_ID() . '_liked' ], FILTER_VALIDATE_BOOLEAN ) : false; ?>
				<a href="javascript:;" class="<?php if( $voted ): ?>clicked<?php endif; ?> like-post" data-post-id="<?php the_ID(); ?>">
					<span><?php echo absint( get_post_meta( get_the_ID(), 'likes', true ) ); ?></span>
				</a>
			</div>
		<?php endif; ?>
		<?php if( filter_var( $tpl_settings['display_comments'], FILTER_VALIDATE_BOOLEAN ) ): ?>
			<div class="header-col post-comments">
				<a href="<?php comments_link(); ?>"><i class="icon-comments"></i> <?php comments_number( '0', '1', '%' ); ?></a>
			</div>
		<?php endif; ?>
	</div>
</header>

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

<?php if( filter_var( $tpl_settings['display_read_more']['enabled'], FILTER_VALIDATE_BOOLEAN ) ): ?>
	<div class="post-read-more">
		<a href="<?php the_permalink(); ?>" class="button size-small style-<?php echo esc_attr( $tpl_settings['display_read_more']['yes']['read_more_style'] ); ?>"><?php echo wp_kses_post( $tpl_settings['display_read_more']['yes']['read_more_title'] ); ?></a>
	</div>
<?php endif;
