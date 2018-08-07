<?php
/**
 * The template for displaying all pages.
 *
 * 
 * @package capacious
 */

get_header(); 
  
   $section_option = capacious_get_option( 'capacious_homepage_hide_front_page_option');
  
     if(!is_home() ){
               do_action( 'home_page_section' ); 
        }
          
        if ( 'posts' == get_option( 'show_on_front' ) ) {
            include( get_home_template() );
        }
        else {
              if( 'hide'!= $section_option ){
                include( get_page_template());
              }  
            }

get_footer();
