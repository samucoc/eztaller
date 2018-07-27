<?php
/**
* Portfolio similar posts / carousel style template part
**/

global $wplab_albedo_core;
$similar_posts_title = fw_get_db_customizer_option( 'portfolio_single_display_similar_posts/yes/portfolio_single_similar_posts_title' );
$similar_posts_desc = fw_get_db_customizer_option( 'portfolio_single_display_similar_posts/yes/portfolio_single_similar_posts_desc' );
$similar_posts = $wplab_albedo_core->model('post')->get_related_posts( get_the_ID(), 9, 'fw-portfolio-category', true );

if( $similar_posts != false && $similar_posts->have_posts() ):

	$atttibutes = array();

	/** unique id **/
	$atttibutes[] = 'id="portfolio-similar-posts"';
	$atttibutes[] = 'data-pagination="yes"';
	$atttibutes[] = 'data-loop="no"';
	$atttibutes[] = 'data-effect="no-effect"';
	$atttibutes[] = 'data-slides-num="3"';
	$atttibutes[] = 'data-slides-medium-num="2"';
	$atttibutes[] = 'data-slides-small-num="1"';

?>

<h2><?php echo wp_kses_post( $similar_posts_title ); ?></h2>

<div class="desc">
	<?php echo apply_filters( 'the_content', $similar_posts_desc ); ?>
</div>

<div class="shortcode-images-carousel images-gallery" <?php echo implode( ' ', $atttibutes ); ?>>
	<!-- Slider main container -->
	<div class="swiper-container">

		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
		<?php while ( $similar_posts->have_posts() ): $similar_posts->the_post(); ?>

			<div class="swiper-slide">
				<div class="slide-content item">

					<figure>
						<a href="<?php the_permalink(); ?>">
							<?php
								echo wplab_albedo_media::img( array(
									'width' => 370,
									'height' => 270,
									'url' => wp_get_attachment_url( get_post_thumbnail_id( get_the_ID()) ),
									'lazy' => true
								));
							?>
							<figcaption class="caption"><?php the_title(); ?></figcaption>
						</a>
					</figure>

				</div>
			</div>

		<?php endwhile; wp_reset_postdata(); ?>
		</div>

	</div>

	<div class="swiper-pagination"></div>

</div>

<?php endif;
