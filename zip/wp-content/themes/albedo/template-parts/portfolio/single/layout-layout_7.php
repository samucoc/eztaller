<?php
/**
 * Layout #7 for Portolio single post
 * a screenshot of it: /wp-content/themes/wplab-albedo/images/portfolio_single_layouts/layout_7.jpg
 **/
	the_post();
	$post_id = get_the_ID();

	/** content align **/
	$post_text_align = fw_get_db_post_option( $post_id, 'text_align' );

	/** display post title in content? **/
	$display_post_title = filter_var( fw_get_db_customizer_option( 'portfolio_single_display_post_title' ), FILTER_VALIDATE_BOOLEAN );

	/** display post excerpt in content? **/
	$display_post_excerpt = filter_var( fw_get_db_customizer_option( 'portfolio_single_display_post_excerpt' ), FILTER_VALIDATE_BOOLEAN );

	/** display post thumbnail in content? **/
	$display_post_thumb = filter_var( fw_get_db_customizer_option( 'portfolio_single_display_post_thumb' ), FILTER_VALIDATE_BOOLEAN );

	/** prev / next posts block **/
	$display_prev_next_posts = filter_var( fw_get_db_customizer_option( 'portfolio_single_display_prev_next_posts/enabled' ), FILTER_VALIDATE_BOOLEAN );
	$prev_next_posts_style = fw_get_db_customizer_option( 'portfolio_single_display_prev_next_posts/yes/portfolio_single_prev_next_posts_style' );

	/** display similar posts? **/
	$display_similar_posts = filter_var( fw_get_db_customizer_option( 'portfolio_single_display_similar_posts/enabled' ), FILTER_VALIDATE_BOOLEAN );
?>
<div style="background-image: url(<?php the_post_thumbnail_url(); ?>);" id="post-<?php the_ID(); ?>" <?php post_class( 'single-portfolio-post-container layout-style_7 content-align-' . $post_text_align ); ?>>

	<div class="container">
		<div class="row">
			<div class="col-md-6 col-media">

				<?php
					// Post thumbnail
					if( $display_post_thumb && has_post_thumbnail() ):
				?>
				<p class="post-thumbnail">
					<?php the_post_thumbnail(); ?>
				</p>
				<?php endif; ?>

			</div>
			<div class="col-md-6">

				<?php if( $display_post_title ): ?>
					<h1><?php the_title(); ?></h1>
				<?php endif; ?>

				<?php
					// Post excerpt
					$post_excerpt = get_the_excerpt();
					if( $post_excerpt <> '' && $display_post_excerpt ) {
						echo '<p class="excerpt"><strong>' . wp_kses_post( $post_excerpt ) . '</strong></p>';
					}
				?>

				<div class="mobile-thumb">
					<img src="<?php the_post_thumbnail_url(); ?>" alt="" />
				</div>

				<?php the_content(); ?>

				<?php get_template_part( 'template-parts/portfolio/single/parts/details' ); ?>

				<?php get_template_part( 'template-parts/portfolio/single/parts/button' ); ?>

			</div>
		</div>
	</div>
</div>

<div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<?php
					/**
					* Previous / next posts block
					**/
					if( $display_prev_next_posts && in_array( $prev_next_posts_style, array('titles', 'links_boxed') ) ):
						?>
						<div class="prev-next-posts-wrapper style-<?php echo esc_attr( $prev_next_posts_style ); ?>">
							<?php get_template_part( 'template-parts/posts/prev_next_' . $prev_next_posts_style ); ?>
						</div>
						<?php
					endif;
				?>

				<?php
					/**
					* Similar posts
					**/
					if( $display_similar_posts ):
						$similar_posts_style = fw_get_db_customizer_option( 'portfolio_single_display_similar_posts/yes/portfolio_single_similar_posts_style' );
						?>
						<div class="similar-posts-wrapper content-align-<?php echo esc_attr( $post_text_align ); ?> style-<?php echo esc_attr( $similar_posts_style ); ?>">
							<?php get_template_part( 'template-parts/portfolio/single/parts/similar_posts_' . $similar_posts_style ); ?>
						</div>
						<?php
					endif;
				?>

			</div>
		</div>
	</div>

</div>
<?php if( filter_var( $display_prev_next_posts, FILTER_VALIDATE_BOOLEAN ) && in_array( $prev_next_posts_style, array('thumb_title') ) ): ?>
<!--
 Prev / next posts thumbnails style
-->
<div class="prev-next-posts-wrapper style-<?php echo esc_attr( $prev_next_posts_style ); ?>">
	<?php get_template_part('template-parts/posts/prev_next_thumb_title'); ?>
</div>
<?php endif;
