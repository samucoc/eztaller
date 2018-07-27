<?php
	get_header();
	$print_class = isset( $print_class ) ? $print_class : '';
?>

<div class="container">
	<div class="row">

		<div id="content" class="<?php echo wplab_albedo_front::get_content_classes(); ?>">

			<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'wedocs-single-article'); ?> itemscope itemtype="http://schema.org/Article">

				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title ' . $print_class . '" itemprop="headline">', '</h1>' ); ?>
					<?php if ( filter_var( wedocs_get_option( 'print', 'wedocs_settings', 'on' ), FILTER_VALIDATE_BOOLEAN ) ): ?>
						<a href="javascript:;" class="wedocs-print-article wedocs-hide-print wedocs-hide-mobile" title="<?php echo esc_attr( esc_html__( 'Print this article', 'albedo' ) ); ?>">Print</a>
					<?php endif; ?>
					<span class="wedocs-article-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
						<meta itemprop="name" content="<?php echo get_the_author(); ?>" />
						<meta itemprop="url" content="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" />
					</span>

					<meta itemprop="datePublished" content="<?php echo get_the_time( 'c' ); ?>"/>
					<time itemprop="dateModified" datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"><?php printf( wp_kses_post( __( 'Updated on <span>%s</span>', 'albedo' ) ), get_the_modified_date() ); ?></time>
					<div class="clearfix"></div>
				</header>

				<div class="entry-content" itemprop="articleBody">
					<?php
						the_content( sprintf(
							wp_kses( esc_html__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'albedo' ), array( 'span' => array( 'class' => array() ) ) ),
							the_title( '<span class="screen-reader-text">"', '"</span>', false )
						) );

						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Docs:', 'albedo' ),
							'after'  => '</div>',
						) );

						$tags_list = wedocs_get_the_doc_tags( $post->ID, '', ', ' );

						if ( $tags_list ) {
							printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
								_x( 'Tags', 'Used before tag names.', 'albedo' ),
								$tags_list
							);
						}
					?>
				</div>

				<hr />

				<?php if ( wedocs_get_option( 'helpful', 'wedocs_settings', 'on' ) == 'on' ): ?>
					<?php wedocs_get_template_part( 'content', 'feedback' ); ?>
				<?php endif; ?>

				<footer class="entry-footer wedocs-entry-footer">
					<?php if ( wedocs_get_option( 'email', 'wedocs_settings', 'on' ) == 'on' ): ?>
						<span class="wedocs-help-link wedocs-hide-print wedocs-hide-mobile">
							<i class="wedocs-icon wedocs-icon-envelope"></i>
							<?php printf( '%s <a id="wedocs-stuck-modal" href="%s">%s</a>', esc_html__( 'Still stuck?', 'albedo' ), '#', esc_html__( 'How can we help?', 'albedo' ) ); ?>
						</span>
					<?php endif; ?>
				</footer>

				<?php if ( wedocs_get_option( 'email', 'wedocs_settings', 'on' ) == 'on' ): ?>
					<?php wedocs_get_template_part( 'content', 'modal' ); ?>
				<?php endif; ?>

			</article>
			<?php endwhile; ?>

		</div>

		<?php get_sidebar(); ?>

	</div>
</div>
<?php get_footer();
