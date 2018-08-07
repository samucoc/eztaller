<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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
                <div class="col-md-6 col-lg-6"><h1><?php echo esc_html__("Blog","capacious"); ?></h1></div>
                <div class="col-md-6 col-lg-6">
                    <div class="breadcrumbs">
                        <?php 
				            if( 'disable'!=$breadcrump_option){
				                   capacious_breadcrumb_trail();
				              }
				        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<div id="main">
        <section id="single-section" class="blog single-section">
            <div class="section-padding">
                <div class="container">
                    <div class="row">
                      <div class="col-md-9 col-xs-12 item wow fadeInLeft">
                        <div class="item">
									<?php
									if ( have_posts() ):
										if ( is_home() && ! is_front_page() ) : ?>
											<header>
												<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
											</header>

										<?php
										endif;
                                   
										/* Start the Loop */
										while ( have_posts() ) : the_post();

											/*
											 * Include the Post-Format-specific template for the content.
											 * If you want to override this in a child theme, then include a file
											 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
											 */
											get_template_part( 'template-parts/content', get_post_format() );

										endwhile;

										the_posts_navigation();

									else :

										get_template_part( 'template-parts/content', 'none' );

									endif; ?>
   
                      </div>
                    </div>
                    <?php get_sidebar(); ?>
                  </div>
                </div>
            </div>
        </section>
    </div><!-- #primary -->
<?php

get_footer();
