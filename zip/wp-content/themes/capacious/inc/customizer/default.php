<?php
/**
 * Capacious default theme options.
 *
 * @package Canyon Themes
 * @subpackage Capacious
 */

if ( !function_exists('capacious_get_default_theme_options' ) ) :

    /**
     * Get default theme options.
     *
     * @since 1.0.0
     *
     * @return array Default theme options.
     */
    function capacious_get_default_theme_options()
    {

        $default = array();
 
        // Top Header Section [Added]
        $default['capacious_top_header_section'] = 'show';
        $default['capacious_phone_number_icon'] ='fa-phone';
        $default['capacious_top_header_phone_no'] = '';
        $default['capacious_email_icon'] = 'fa-envelope-o';
        $default['capacious_top_header_email'] = '';
        $default['capacious_breadcrump_option'] = 'simple';
        $default['capacious_post_search_placeholder_option'] =esc_html__('Search', 'capacious');
        
        // footer copyright. [Added]
        $default['capacious_copyright_text_option'] = sprintf(esc_html__('&copy; All rights reserved. %s','capacious'), date('Y'));
      
        // Home Page Top header Info.[added]
        $default['capacious_homepage_hide_front_page_option'] = 'hide';
        $default['capacious_homepage_slider_option'] = 'show';
        $default['capacious_slider_section_id'] = esc_html__('home', 'capacious');
        $default['capacious_slider_cat_id'] = 0; 
        $default['capacious_homepage_quote_option'] = 'hide';
        $default['capacious_quote_section_title'] = esc_html__('Quote','capacious');
        $default['capacious_quote_get_a_quate_txt'] = esc_html__('Get a quote','capacious');
      
        $default['capacious_quote_get_a_quate_link'] = esc_html__('#', 'capacious');
        $default['capacious_homepage_about_option'] = "hide"; 
        $default['capacious_about_section_id'] = esc_html__('about-us','capacious');
        $default['capacious_about_section_title'] = esc_html__('About','capacious');
        $default['capacious_about_section_sub_title'] = esc_html__('Who We Are','capacious');
        $default['capacious_about_page_id'] = 0;

        $default['capacious_about_read_more_txt'] = esc_html__('Read More', 'capacious');
        $default['capacious_homepage_service_option'] = 'hide';
        $default['capacious_services_section_id'] = esc_html__( 'services', 'capacious' );
        $default['capacious_services_section_title'] = esc_html__('Our Services','capacious');
        $default['capacious_services_section_sub_title'] = esc_html__('Our Works','capacious');
       
      
        $default['capacious_homepage_satisfied_clients_option'] = 'hide';
        $default['capacious_satisfied_clients_section_title'] = esc_html__( 'Our Satisfied Clients', 'capacious' );
         $default['capacious_satisfied_clients_section_sub_title'] = esc_html__( 'ALL AROUND THE WORLD', 'capacious' );
        $default['capacious_satisfied_clients_section_description'] = esc_html__('Our description','capacious');
        $default['capacious_satisfied_clients_section_cat_id'] = 0;
             

        $default['capacious_homepage_our_team_option'] = 'hide';
        $default['capacious_our_team_section_id'] = esc_html__( 'team', 'capacious' );
        $default['capacious_our_team_section_title'] = esc_html__('Our Team','capacious');
        $default['capacious_our_team_section_sub_title'] = esc_html__( 'MEET OUR DEDICATED AWESOME TEAM', 'capacious' );

       
        $default['capacious_our_team_cat_id'] = 0;
        $default['capacious_homepage_testimonials_option'] = 'hide';
        $default['capacious_testimonial_section_id'] = esc_html__( 'testimonial', 'capacious' );
        $default['capacious_testimonials_cat_id'] = 0;
            
         // Font Awesome Icon list for service and offer page
       
        $default['capacious_service_icon_0'] = 'fa-desktop';
        $default['capacious_service_icon_1'] = 'fa-mobile';
        $default['capacious_service_icon_2'] = 'fa-print';
        $default['capacious_service_icon_3'] = 'fa-flash';
        $default['capacious_service_icon_4'] = 'fa-music';
        $default['capacious_service_icon_5'] = 'fa-support';
     

        // Blog.
        $default['capacious_homepage_blog_option'] = 'hide';
        $default['capacious_blog_section_id'] = esc_html__( 'blog', 'capacious' );
        $default['capacious_blog_section_title'] = esc_html__( 'Blog', 'capacious' );
        $default['capacious_blog_section_sub_title'] = esc_html__( 'Blog Short Description', 'capacious' );
         $default['capacious_blog_section_view_all_text'] = esc_html__( 'View All', 'capacious' );
        $default['capacious_blog_categories_id'] = 0;
        $default['capacious_sidebar_layout_option'] = 'right-sidebar'; 
        $default['capacious_blog_title_option'] = esc_html__('Latest Blog', 'capacious');
        $default['capacious_blog_excerpt_option'] = 'excerpt';
        $default['capacious_exclude_cat_blog_archive_option'] = ''; 
        $default['capacious_readmore_text_blog_archive_option'] = esc_html__('Read More', 'capacious'); 
        
       $default['capacious_columns_option'] = 'col-sm-12';
        
         // Single Post option
               
        //Author Info Options
        $default['capacious_show_author_info_option'] = 'hide'; 

        // Basic Color Option.
        $default['capacious_primary_color_option'] = '#00AEFF';
        
        $default['capacious_front_page_hide_option'] = 0;
        $default['capacious_hide_breadcrumb_front_page_option'] = 1;
        $default['capacious_breadcrumb_setting_option'] = 'simple';
        $default['capacious_post_search_placeholder_option'] = esc_html__('Search', 'capacious');
        $default['capacious_reset_value_option'] = 'do-not-reset';

        //Contact us Default Value[added]
          $default['capacious_homepage_contact_option'] = 'hide';
          $default['capacious_contact_section_id'] = esc_html__( 'contact-us', 'capacious' );
          $default['capacious_contact_section_title'] = esc_html__( 'NICE TO HEAR FROM YOU', 'capacious' );
          $default['capacious_contact_section_sub_title'] = esc_html__( 'SEND A MESSAGE USING THE FORM BELOW!', 'capacious' );
        // Pass through filter.
        $default = apply_filters( 'capacious_get_default_theme_options', $default );
        return $default;
    }
endif;
