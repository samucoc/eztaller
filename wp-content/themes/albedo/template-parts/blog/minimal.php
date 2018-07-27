<?php

/**
	* Blog posts / minimal style
**/

$tpl_settings = get_query_var( 'wplab_albedo_tpl_settings');
$post_format = get_post_format();

$dislay_date = filter_var( $tpl_settings['display_date'], FILTER_VALIDATE_BOOLEAN );
$display_post_data = filter_var( $tpl_settings['post_data']['enabled'], FILTER_VALIDATE_BOOLEAN );

$text_col_size = 'col-md-7';
if( !$dislay_date && $display_post_data ) {
	$text_col_size = 'col-md-9';
} elseif( $dislay_date && !$display_post_data ) {
	$text_col_size = 'col-md-10';
} elseif( !$dislay_date && !$display_post_data ) {
	$text_col_size = 'col-md-12';
}

$post_has_media = $video_parallax = false;
$post_classes = $post_attributes = array();
$post_style = '';
if( $tpl_settings['style'] == 'thumbs_bg' ) {

	if( $post_format == 'video' ) {

		$video_parallax = true;
		$post_classes[] = 'has-media';
		$post_classes[] = 'video-bg-section';
		$post_attributes[] = 'data-video-id="' . esc_attr( wplab_albedo_media::getYouTubeVideoId( get_the_content() ) ) . '"';
		$post_attributes[] = 'data-video-pause-scroll="yes"';
		$post_attributes[] = 'data-video-mute="yes"';

	} elseif( has_post_thumbnail() ) {

		$post_has_media = true;
		$post_classes[] = 'has-media';
		$thumb_id = get_post_thumbnail_id( get_the_ID());
		$thumb_url = wp_get_attachment_url( $thumb_id );
		$post_style = 'background-image: url(' . $thumb_url . ');';

	}

}

?>
<article id="post-<?php the_ID(); ?>" <?php echo implode( ' ', $post_attributes ); ?> class="format-<?php echo esc_attr( $post_format ); echo ' ' . implode(' ', $post_classes ); ?>" style="<?php echo esc_attr( $post_style ); ?>">

	<?php if( $video_parallax ): ?>
		<div data-stellar-ratio="0.1" class="video-bg"></div>
	<?php endif; ?>

	<?php if( $video_parallax || $post_has_media ): ?>
		<div class="overlay"></div>
	<?php endif; ?>

	<div class="container">
		<div class="row">

			<?php if( $dislay_date ): ?>
			<!-- post date column -->
			<div class="col col-md-2">
				<div class="post-date">
					<?php the_time( get_option('date_format') ); ?>
				</div>
			</div>
			<?php endif; ?>

			<!-- title and excerpt -->
			<div class="col <?php echo esc_attr( $text_col_size ); ?>">
				<?php if( filter_var( $tpl_settings['display_title'], FILTER_VALIDATE_BOOLEAN ) ): ?>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php endif; ?>
				<?php if( filter_var( $tpl_settings['display_excerpt']['enabled'], FILTER_VALIDATE_BOOLEAN ) ): ?>
					<div class="post-excerpt">
						<?php

							if( $post_format == 'quote' ) {
								the_content();
							} elseif( $post_format == 'link' ) {
								echo '<a href="' . strip_tags( get_the_content() ) . '">' . strip_tags( get_the_content() ) .'</a>';
							} else {
								$excerpt_length = absint( $tpl_settings['display_excerpt']['yes']['excerpt_length'] );
								echo wp_trim_words( get_the_excerpt(), $excerpt_length );
							}

						?>
					</div>
				<?php endif; ?>
			</div>

			<?php if( $display_post_data ): ?>
			<!-- post data -->
			<div class="col col-md-3">
				<dl class="post-data">
					<?php if( filter_var( $tpl_settings['post_data']['yes']['display_author'], FILTER_VALIDATE_BOOLEAN ) ): ?>
					<dt><?php esc_html_e( 'Author', 'albedo'); ?>:</dt>
					<dd class="author-link"><?php the_author_posts_link(); ?></dd>
					<?php endif; ?>

					<?php if( filter_var( $tpl_settings['post_data']['yes']['display_cats'], FILTER_VALIDATE_BOOLEAN ) ): ?>
					<dt><?php esc_html_e( 'In', 'albedo'); ?>:</dt>
					<dd><?php echo wplab_albedo_front::get_categories(); ?></dd>
					<?php endif; ?>

					<?php if( filter_var( $tpl_settings['post_data']['yes']['display_comments'], FILTER_VALIDATE_BOOLEAN ) ): ?>
					<dt><?php esc_html_e( 'Comments', 'albedo'); ?>:</dt>
					<dd><a href="<?php comments_link(); ?>"><?php comments_number( '0', '1', '%'); ?></a></dd>
					<?php endif; ?>
				</dl>
			</div>
			<?php endif; ?>

		</div>
	</div>
</article>
