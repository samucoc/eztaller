<?php

$has_post_thumbnail = has_post_thumbnail();
$thumb_url = '';
$attachments = array();

if( $has_post_thumbnail ) {

	$thumb_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID()) );

	// custom thumb dimensions
	if( $atts['thumbs_dimensions']['type'] == 'crop' && $thumb_url <> '' ) {

		$thumb_width = is_numeric( $atts['thumbs_dimensions']['crop']['thumb_width'] ) ? absint( $atts['thumbs_dimensions']['crop']['thumb_width'] ) : null;
		$thumb_height = is_numeric( $atts['thumbs_dimensions']['crop']['thumb_height'] ) ? absint( $atts['thumbs_dimensions']['crop']['thumb_height'] ) : null;

		$thumb_url = wplab_albedo_media::img_resize( $thumb_url, $thumb_width, $thumb_height );

	}

} else {

	preg_match('/\[gallery.*ids=.(.*).\]/', get_post_field( 'post_content', get_the_ID() ), $ids );
	if( isset( $ids[1] ) && $ids[1] <> '' ) {

		$gallery_ids = explode( ',', $ids[1] );

		$args = array(
			'post_type' => 'attachment',
			'numberposts' => -1,
			'post_status' => null
		);

		if( is_array( $gallery_ids ) && count( $gallery_ids ) > 0 ) {
			$args['include'] = $gallery_ids;
		} else {
			$args['post_parent'] = get_the_ID();
		}

		$attachments = get_posts( $args );

		if( count( $attachments ) > 0 && is_array( $attachments ) ) {
			$has_post_thumbnail = true;
			$thumb_url = wp_get_attachment_url( $attachments[0]->ID );
		}

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

			<?php if( $has_post_thumbnail ): ?>
				<div class="gallery-pagination">
					<?php $i=0; foreach( $attachments as $item ): $i++; ?>

						<?php
							$gallery_img = wp_get_attachment_url( $item->ID );
							if( $atts['thumbs_dimensions']['type'] == 'crop' ) {
								$gallery_img_width = is_numeric( $atts['thumbs_dimensions']['crop']['thumb_width'] ) ? absint( $atts['thumbs_dimensions']['crop']['thumb_width'] ) : null;
								$gallery_img_height = is_numeric( $atts['thumbs_dimensions']['crop']['thumb_height'] ) ? absint( $atts['thumbs_dimensions']['crop']['thumb_height'] ) : null;

								$gallery_img = wplab_albedo_media::img_resize( wp_get_attachment_url( $item->ID ), $gallery_img_width, $gallery_img_height );
							}
						?>

						<a href="javascript:;" <?php if( $i==1 ): ?>class="current"<?php endif; ?> data-img="<?php echo esc_attr( $gallery_img ); ?>"></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>
