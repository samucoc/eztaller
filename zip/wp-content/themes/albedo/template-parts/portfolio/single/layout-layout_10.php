<?php
/**
 * Layout #10 for Portolio single post
 * a screenshot of it: /wp-content/themes/wplab-albedo/images/portfolio_single_layouts/layout_10.jpg
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

/** a client name **/
$client_name = fw_get_db_post_option( $post_id, 'client_name' );
/** display post categories ? **/
$display_post_categories = filter_var( fw_get_db_customizer_option( 'portfolio_single_display_post_cats' ), FILTER_VALIDATE_BOOLEAN );
/** display post likes ? **/
$display_post_likes = filter_var( fw_get_db_customizer_option( 'portfolio_single_display_post_likes' ), FILTER_VALIDATE_BOOLEAN );
/** display share links? **/
$display_share_links = filter_var( fw_get_db_customizer_option( 'portfolio_single_display_share_links' ), FILTER_VALIDATE_BOOLEAN );
?>

<div id="post-<?php the_ID(); ?>" <?php post_class( 'single-portfolio-post-container layout-style_10 content-align-' . $post_text_align ); ?>>

	<?php get_template_part( 'template-parts/portfolio/single/parts/carousel' ); ?>

	<div id="content" class="container">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">

				<?php
				 /**
				 * Dislay post categories
				 **/
				if( $display_post_categories ): ?>
				<div class="single-post-categories">
					<?php echo wplab_albedo_front::get_categories(); ?>
				</div>
				<?php endif; ?>

				<?php
				/**
				* Dislay post title
				**/
				if( $display_post_title ): ?>
					<h1><?php the_title(); ?></h1>
				<?php endif; ?>

				<?php
				/**
				* Dislay share links
				**/
				if( $display_share_links || $client_name <> '' ): ?>
					<div class="portfolio-details">

						<?php if( $client_name <> '' ): ?>
						<dl>
							<dt><?php esc_html_e('Client', 'albedo'); ?>:</dt>
							<dd><?php echo wp_kses_post( $client_name ); ?></dd>
						</dl>
						<?php endif; ?>

						<?php if( $display_share_links ): ?>
						<dl>
							<dt><?php esc_html_e('Share', 'albedo'); ?>:</dt>
							<dd><?php echo wplab_albedo_front::share_links( true ); ?></dd>
						</dl>
						<?php endif; ?>

					</div>
				<?php endif; ?>

				<?php
					// Post excerpt
					$post_excerpt = get_the_excerpt();
					if( $post_excerpt <> '' && $display_post_excerpt ) {
						echo '<p class="excerpt"><strong>' . wp_kses_post( $post_excerpt ) . '</strong></p>';
					}
				?>

				<?php
					// Post thumbnail
					if( $display_post_thumb && has_post_thumbnail() ):
				?>
				<p class="post-thumbnail">
					<?php the_post_thumbnail(); ?>
				</p>
				<?php endif; ?>

			<div class="clearfix"></div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">

			<?php the_content(); ?>

			<?php get_template_part( 'template-parts/portfolio/single/parts/button' ); ?>

			<?php
			/**
			* Dislay post likes
			**/
			if( $display_post_likes ): ?>
			<div id="post-likes">
				<?php $voted = isset( $_COOKIE[ 'post_id_' . get_the_ID() . '_liked' ] ) ? filter_var( $_COOKIE[ 'post_id_' . get_the_ID() . '_liked' ], FILTER_VALIDATE_BOOLEAN ) : false; ?>

				<a href="javascript:;" class="<?php if( $voted ): ?>clicked<?php endif; ?>" data-post-id="<?php the_ID(); ?>" id="like-post">
					<span>
					<?php
						$likes = absint( get_post_meta( $post_id, 'likes', true ) );
						printf( _nx( '1 Like', '%1$s Likes', $likes, 'post likes', 'albedo' ), number_format_i18n( $likes ) );
					?>
					</span>
				</a>
			</div>
			<?php endif; ?>

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
