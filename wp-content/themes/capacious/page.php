<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package capacious
 */
get_header(); 
$breadcrump_option=capacious_get_option( 'capacious_breadcrump_option');
?>
<div class="header-space"></div>
	<section id="inner-title" class="inner-title">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-6"><h1><?php the_title(); ?></h1></div>
				<div class="col-md-6 col-lg-6">
					<div class="breadcrumbs">
						 <?php 
				             if( 'disable' !=$breadcrump_option){
				                   capacious_breadcrumb_trail();
				              }
				           ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="primary" class="content-area section-padding page-section">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-8 col-md-9 item wow fadeInLeft">
					<main id="main" class="site-main item" role="main">
						<?php
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/content', 'page' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						endwhile; // End of the loop.
						?>
					</main><!-- #main -->
				</div>
				<?php get_sidebar(); ?>
			</div>
		</div>
	</section><!-- #primary -->
<?php get_footer();
