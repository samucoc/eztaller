<?php

/**
 * Blog list layout
 * Video post format template
**/

$tpl_settings = get_query_var('wplab_albedo_tpl_settings');
?>

<?php if( filter_var( $tpl_settings['display_media'], FILTER_VALIDATE_BOOLEAN ) ): ?>
	<div class="post-media">
		<?php
			$post_video = wplab_albedo_media::get_media( 'video' );
			echo trim( $post_video ) <> '' ? $post_video : apply_filters( 'the_content', get_the_content() );
		?>
	</div>
<?php endif; ?>

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
<?php endif;
