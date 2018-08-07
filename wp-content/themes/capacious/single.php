<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
	<div id="main">
		<section id="single-section" class="single-section">
		  <div class="section-padding">
			<div class="container">
			  <div class="row">
				<div class="col-xs-12 col-sm-8 col-md-9 item wow fadeInLeft">
						<?php
						while ( have_posts() ) : the_post();

							  get_template_part( 'template-parts/content','single');
	                            
	                           the_post_navigation();
	                       
							// If comments are open or we have at least one comment, load up the comment template.
                        
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						endwhile; // End of the loop.
						?>
				</div>
				<?php get_sidebar(); ?>
			</div>
		</div>
		</div>
		</section>
	</div><!-- #primary -->

<?php
get_footer();
