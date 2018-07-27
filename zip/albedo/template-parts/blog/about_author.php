<?php
/**
 * About Author Template Part
 **/
global $wp_query;

$author_id = get_the_author_meta('ID');
if( $author_id == 0 ) {
	$current_author = $wp_query->get_queried_object();
	$author_metadata = get_metadata( 'user', $current_author->ID );
} else {
	$current_author = get_user_by( 'id', $author_id );
	$author_metadata = get_metadata( 'user', $current_author->ID );
}
?>

<div itemscope itemtype="http://schema.org/Person" class="about-author">

	<div class="author_image">
		<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-lazy-src="<?php echo esc_attr( wplab_albedo_front::get_avatar_url( get_avatar( $current_author->ID, 100 )) ); ?>" data-at2x="<?php echo esc_attr( wplab_albedo_front::get_avatar_url( get_avatar( $current_author->ID, 200 )) ); ?>" class="b-lazy" width="100" alt="" itemprop="image" />
	</div>

	<div class="author_text">
		<a itemprop="name" class="name" href="<?php echo get_author_posts_url( $author_id ); ?>"><?php echo esc_html( $current_author->display_name ); ?></a>

		<?php if( isset( $current_author->description ) && $current_author->description <> '' ): ?>
		<div itemprop="description"><?php echo nl2br( $current_author->description ); ?></div>
		<?php endif; ?>
	</div>

</div>
