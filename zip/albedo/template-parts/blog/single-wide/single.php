<?php
/**
 * Single post template part
 **/
global $wplab_albedo_core;

/** get single post layout options from customizer **/
$single_post_style = wplab_albedo_utils::get_theme_mod(
	'blog_single_post_style',
	$wplab_albedo_core->default_options['blog_single_post_style']
);

$display_likes = wplab_albedo_utils::get_theme_mod(
	'blog_single_display_post_likes',
	$wplab_albedo_core->default_options['blog_single_display_post_likes']
);

$display_tags = wplab_albedo_utils::get_theme_mod(
	'blog_single_display_post_tags',
	$wplab_albedo_core->default_options['blog_single_display_post_tags']
);

$display_share_links = wplab_albedo_utils::get_theme_mod(
	'blog_single_display_share_links',
	$wplab_albedo_core->default_options['blog_single_display_share_links']
);

$display_about_author = wplab_albedo_utils::get_theme_mod(
	'blog_single_display_about_author',
	$wplab_albedo_core->default_options['blog_single_display_about_author']
);

$display_pre_next_posts = wplab_albedo_utils::get_theme_mod(
	'blog_single_display_prev_next_posts/enabled',
	$wplab_albedo_core->default_options['blog_single_display_prev_next_posts']
);

$display_pre_next_posts_style = wplab_albedo_utils::get_theme_mod(
	'blog_single_display_prev_next_posts/yes/blog_single_prev_next_posts_style',
	$wplab_albedo_core->default_options['blog_single_prev_next_posts_style']
);

$comments_open = comments_open() ? 'open' : 'closed';

?>
<div id="post-<?php the_ID(); ?>" <?php post_class( 'single-blog-post-container style-' .$single_post_style . ' comments-' . $comments_open ); ?>>
	<div class="container">

		<div class="row">

			<div id="content" class="<?php echo wplab_albedo_front::get_content_classes(); ?>">

				<div class="container-fluid">
					<div class="row">
						<div class="col-md-2"></div>
						<div class="col-md-8">

							<div class="content-wrapper">

								<?php the_post(); ?>

								<!--
									Post Content based on Post Format
								-->
								<?php get_template_part( 'template-parts/blog/single-wide/post-format', get_post_format() ); ?>

								<?php
									/**
									 * Post pagination
									 **/
									wp_link_pages( array(
										'before' => '<div class="pagination style-post">',
										'after' => '</div>',
										'next_or_number' => 'number'
									));
								?>

								<?php if( filter_var( $display_likes, FILTER_VALIDATE_BOOLEAN ) ): ?>
								<!--
									Post Likes
								-->
								<div id="post-likes">

									<?php $voted = isset( $_COOKIE[ 'post_id_' . get_the_ID() . '_liked' ] ) ? filter_var( $_COOKIE[ 'post_id_' . get_the_ID() . '_liked' ], FILTER_VALIDATE_BOOLEAN ) : false; ?>

									<a href="javascript:;" class="<?php if( $voted ): ?>clicked<?php endif; ?>" data-post-id="<?php the_ID(); ?>" id="like-post">
										<span>
										<?php
											$likes = absint( get_post_meta( get_the_ID(), 'likes', true ) );
											printf( _nx( '1 Like', '%1$s Likes', $likes, 'post likes', 'albedo' ), number_format_i18n( $likes ) );
										?>
										</span>
									</a>

								</div>

								<?php endif; ?>

								<hr />

								<footer>
									<?php if( filter_var( $display_tags, FILTER_VALIDATE_BOOLEAN ) ): ?>
									<!--
										Post Tags
									-->
									<div class="post-tags">
										<?php wplab_albedo_front::tags_links(); ?>
									</div>
									<?php endif; ?>

									<?php if( filter_var( $display_share_links, FILTER_VALIDATE_BOOLEAN ) ): ?>
									<!--
										Share links
									-->
									<div class="share-links">
										<?php wplab_albedo_front::share_links(); ?>
									</div>
									<?php endif; ?>

								</footer>

								<?php if( filter_var( $display_about_author, FILTER_VALIDATE_BOOLEAN ) ): ?>
								<!--
									About author
								-->
								<div class="about-author-wrapper">
									<?php get_template_part('template-parts/blog/about_author'); ?>
								</div>
								<?php endif; ?>

								<!--
									Comments block
								-->
								<div class="comments-wrapper">
									<?php if( !post_password_required() && comments_open() ): ?>
										<?php comments_template( '', true ); ?>
									<?php endif; ?>
								</div>

								<div class="clearfix"></div>
							</div>

						</div>
						<div class="col-md-2"></div>
					</div>
				</div>

				<?php if( filter_var( $display_pre_next_posts, FILTER_VALIDATE_BOOLEAN ) && in_array( $display_pre_next_posts_style, array('titles', 'links_boxed') ) ): ?>
				<!--
					Prev / next posts
				-->
				<div class="prev-next-posts-wrapper style-<?php echo esc_attr( $display_pre_next_posts_style ); ?>">
					<?php get_template_part('template-parts/posts/prev_next_' . $display_pre_next_posts_style ); ?>
				</div>
				<?php endif; ?>

			</div>

			<?php get_sidebar(); ?>

		</div>
	</div>
	<?php if( filter_var( $display_pre_next_posts, FILTER_VALIDATE_BOOLEAN ) && in_array( $display_pre_next_posts_style, array('thumb_title') ) ): ?>
	<!--
		Prev / next posts thumbnails style
	-->
	<div class="prev-next-posts-wrapper style-<?php echo esc_attr( $display_pre_next_posts_style ); ?>">
		<?php get_template_part('template-parts/posts/prev_next_thumb_title'); ?>
	</div>
	<?php endif; ?>
</div>
