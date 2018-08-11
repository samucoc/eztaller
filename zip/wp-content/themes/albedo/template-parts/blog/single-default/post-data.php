<?php
/**
 * Post data template part
 **/
global $wplab_albedo_core;

$display_post_date = wplab_albedo_utils::get_theme_mod(
	'blog_single_display_post_date',
	$wplab_albedo_core->default_options['blog_single_display_post_date']
);

$display_post_title = filter_var( wplab_albedo_utils::get_theme_mod(
	'blog_single_display_post_title',
	$wplab_albedo_core->default_options['blog_single_display_post_title']
), FILTER_VALIDATE_BOOLEAN );

$display_post_excerpt = filter_var( wplab_albedo_utils::get_theme_mod(
	'blog_single_display_post_excerpt',
	$wplab_albedo_core->default_options['blog_single_display_post_excerpt']
), FILTER_VALIDATE_BOOLEAN );

$display_post_author = filter_var( wplab_albedo_utils::get_theme_mod(
	'blog_single_display_post_author',
	$wplab_albedo_core->default_options['blog_single_display_post_author']
), FILTER_VALIDATE_BOOLEAN );

$display_post_categories = filter_var( wplab_albedo_utils::get_theme_mod(
	'blog_single_display_post_categories',
	$wplab_albedo_core->default_options['blog_single_display_post_categories']
), FILTER_VALIDATE_BOOLEAN );

$display_post_comments_num = filter_var( wplab_albedo_utils::get_theme_mod(
	'blog_single_display_post_comments_num',
	$wplab_albedo_core->default_options['blog_single_display_post_comments_num']
), FILTER_VALIDATE_BOOLEAN );
?>

<?php if( filter_var( $display_post_date, FILTER_VALIDATE_BOOLEAN ) ): ?>
<!--
	Post date
-->
<div class="post-date">
	<?php the_time( get_option('date_format') ); ?>
</div>
<?php endif; ?>

<?php if( $display_post_title ): ?>
<!--
	Post title
-->
<h1 class="post-title"><?php the_title(); ?></h1>
<?php endif; ?>

<?php if( $display_post_author || $display_post_categories || $display_post_comments_num ): ?>
<!--
	Post data
-->
<div class="post-data">

	<?php if( $display_post_author ): ?>
	<span class="item"><?php esc_html_e('Posted by', 'albedo'); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></span>
	<?php endif; ?>

	<?php if( $display_post_categories ): ?>
	<?php
		/**
		 * Get post categories
		 **/
		$cats_string = '';
		$post_categories = wplab_albedo_utils::get_categories();
		$cats_string = $post_categories <> '' ? esc_html__( 'In', 'albedo') . ': ' . $post_categories : '';
	?>
	<span class="item post-cats"><?php echo $cats_string; ?></span>
	<?php endif; ?>

	<?php if( $display_post_comments_num ): ?>
	<span class="item comments-num"><?php comments_number( esc_html__('No comments', 'albedo'), esc_html__('1 Comment', 'albedo'), esc_html__('% Comments', 'albedo') ); ?></span>
	<?php endif; ?>

</div>
<?php endif; ?>

<?php if( $display_post_excerpt && !in_array( get_post_format(), array('quote', 'video') ) ): ?>
<!--
	Post excerpt before content
-->
<div class="single-post-excerpt"><strong><?php the_excerpt(); ?></strong></div>
<?php endif;
