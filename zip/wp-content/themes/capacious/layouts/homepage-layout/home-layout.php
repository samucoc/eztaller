<?php

if( ! function_exists( 'home_page_section_hook' ) ):
    function home_page_section_hook() { ?>

        	<!-- banner section Start Here -->
         <?php get_template_part( 'section-parts/section', 'slider'); ?>
          <!-- banner section End Here -->
          <!-- process section Start Here -->
          <?php get_template_part( 'section-parts/section', 'quote'); ?>
          <!-- process section End Here -->

          <!-- Main Section Start Here -->
          <div id="main">
            <!-- About Us Section Start Here-->
            <?php get_template_part( 'section-parts/section', 'about'); ?>
            <!-- About Us Section End Here-->

           <!-- Services Section Start Here-->
              <?php get_template_part( 'section-parts/section', 'services' ); ?>
            <!--Services Section end Here-->

            <!-- Satisfied Clients Section Start Here-->
             <?php get_template_part( 'section-parts/section', 'clients'); ?>
            <!-- Satisfied Client Section End Here-->

            
            <!-- Team Section Start Here-->
              <?php get_template_part( 'section-parts/section', 'team'); ?>
            <!-- Team Section End Here-->

            <!-- Testimonial Section -->
            <?php get_template_part( 'section-parts/section', 'testimonials'); ?>
            <!-- Testimonial Section End -->
            <!-- Blog Section -->
             <?php get_template_part( 'section-parts/section', 'blog'); ?>
           <!-- Blog Section End --> 
            <!-- Contact Section Start Here -->
             <?php get_template_part( 'section-parts/section', 'contact'); ?>
            <!-- Contact Section end Here -->

            
          </div>
       

          
     <?php
       
     }
   endif;
    add_action( 'home_page_section', 'home_page_section_hook', 10 );
?>