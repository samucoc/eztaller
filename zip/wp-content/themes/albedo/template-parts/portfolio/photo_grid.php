<?php $url = get_the_post_thumbnail_url(); ?>
<figure data-src="<?php echo esc_attr( $url ); ?>">
	<a href="<?php echo esc_attr( $url ); ?>">
		<img alt="<?php echo esc_attr( get_the_title( get_the_id() ) ); ?>" src="<?php echo esc_attr( $url ); ?>" />
	</a>
</figure>
