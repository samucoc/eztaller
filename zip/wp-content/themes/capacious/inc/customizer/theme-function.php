<?php 

/**
 * enqueue Admins style for admin dashboard.
 */

if (!function_exists('capacious_admin_css_enqueue')) :
    function capacious_admin_css_enqueue($hook)
    {
        if ('post.php' != $hook)
        {
            return;
        }
        wp_enqueue_style('capacious-admin', get_template_directory_uri() . '/assets/css/admin.css', array(), '1.0.0');
    }
    add_action('admin_enqueue_scripts', 'capacious_admin_css_enqueue');
endif;

/**
 * enqueue Admins style for admin dashboard.
 */

if (!function_exists('capacious_admin_css_enqueue_new_post')) :
    function capacious_admin_css_enqueue_new_post($hook)
    {
        if ('post-new.php' != $hook)
        {
            return;
        }
        wp_enqueue_style('capacious-admin', get_template_directory_uri() . '/assets/css/admin.css', array(), '1.0.0');
    }
    add_action('admin_enqueue_scripts', 'capacious_admin_css_enqueue_new_post');
endif;

/**
 * Sidebar layout options
 *
 * @since capacious 1.0.0
 *
 * @param null
 * @return array $capacious_sidebar_layout
 *
 */
if ( !function_exists('capacious_sidebar_layout') ) :
    function capacious_sidebar_layout() {
        $capacious_sidebar_layout =  array(
            'right-sidebar' => esc_html__( 'Right Sidebar', 'capacious'),
            'left-sidebar'  => esc_html__( 'Left Sidebar' , 'capacious'),
            'no-sidebar'    => esc_html__( 'No Sidebar'   , 'capacious')
        );
        return apply_filters( 'capacious_sidebar_layout', $capacious_sidebar_layout );
    }
endif;


/**
 * Show/Hide Show Author Info
 *
 * @since capacious 1.0.0
 *
 * @param null
 * @return array $capacious_show_author_info_option
 *
 */
if ( !function_exists('capacious_show_author_info_option') ) :
    function capacious_show_author_info_option() {
        $capacious_show_author_info_option =  array(
                                        'show'  => esc_html__( 'Show', 'capacious' ),
                                         'hide'  => esc_html__( 'Hide', 'capacious' )
                                      );
        return apply_filters( 'capacious_show_author_info_option', $capacious_show_author_info_option );
    }
endif;


/**
 * Top Header Info Option
 *
 * @since capacious 1.0.0
 *
 * @param null
 * @return array $capacious_top_header_section
 *
 */
if ( !function_exists('capacious_top_header_section') ) :
    function capacious_top_header_section() {
        $capacious_top_header_section =  array(
                                         'show'     => esc_html__( 'Show', 'capacious' ),
                                         'hide'  => esc_html__( 'Hide', 'capacious' )
                                      );
        return apply_filters( 'capacious_top_header_section', $capacious_top_header_section );
    }
endif;


/**
 * Breadcrumb Options
 *
 * @since capacious 1.0.0
 *
 * @param null
 * @return array $capacious_breadcrump_option
 *
 */
if ( !function_exists('capacious_breadcrump_option') ) :
    function capacious_breadcrump_option() {
        $capacious_breadcrump_option =  array(
                                            'simple'  => esc_html__( 'Theme Default', 'capacious' ),
                                            'disable'   => esc_html__( 'Disable', 'capacious' )
                                      );
        return apply_filters( 'capacious_breadcrump_option', $capacious_breadcrump_option );
    }
endif;


/**
 * Hide Front Page Content
 *
 * @since capacious 1.0.0
 *
 * @param null
 * @return array $capacious_homepage_hide_front_page_option
 *
 */
if ( !function_exists('capacious_homepage_hide_front_page_option') ) :
    function capacious_homepage_hide_front_page_option() {
        $capacious_homepage_hide_front_page_option =  array(
                                             'show'     => esc_html__( 'Show', 'capacious' ),
                                            'hide'  => esc_html__( 'Hide', 'capacious' )
                                              );
        return apply_filters( 'capacious_homepage_hide_front_page_option', $capacious_homepage_hide_front_page_option );
    }
endif;



/**
 * Slider Option
 *
 * @since capacious 1.0.0
 *
 * @param null
 * @return array $capacious_homepage_slider_option
 *
 */
if ( !function_exists('capacious_homepage_slider_option') ) :
    function capacious_homepage_slider_option() {
        $capacious_homepage_slider_option =  array(
                                             'show'  => esc_html__( 'Show', 'capacious' ),
                                             'hide'  => esc_html__( 'Hide', 'capacious' )
                                              );
        return apply_filters( 'capacious_homepage_slider_option', $capacious_homepage_slider_option );
    }
endif;


/**
 * Show/hide option for Homepage Quote Section
 *
 * @since capacious 1.0.0
 *
 * @param null
 * @return array $capacious_homepage_quote_option
 *
 */
if ( !function_exists('capacious_homepage_quote_option') ) :
    function capacious_homepage_quote_option() {
        $capacious_homepage_quote_option =  array(
                                             'show'  => esc_html__( 'Show', 'capacious' ),
                                             'hide'  => esc_html__( 'Hide', 'capacious' )
                                              );
        return apply_filters( 'capacious_homepage_quote_option', $capacious_homepage_quote_option );
    }
endif;


/**
 * About Section Option
 *
 * @since capacious 1.0.0
 *
 * @param null
 * @return array $capacious_homepage_about_option
 *
 */
if ( !function_exists('capacious_homepage_about_option') ) :
    function capacious_homepage_about_option() {
        $capacious_homepage_about_option =  array(
                                             'show'  => esc_html__( 'Show', 'capacious' ),
                                             'hide'  => esc_html__( 'Hide', 'capacious' )
                                              );
        return apply_filters( 'capacious_homepage_about_option', $capacious_homepage_about_option );
    }
endif;


/**
 * Services Section Option
 *
 * @since capacious 1.0.0
 *
 * @param null
 * @return array $capacious_homepage_service_option
 *
 */
if ( !function_exists('capacious_homepage_service_option') ) :
    function capacious_homepage_service_option() {
        $capacious_homepage_service_option =  array(
                                             'show'  => esc_html__( 'Show', 'capacious' ),
                                             'hide'  => esc_html__( 'Hide', 'capacious' )
                                              );
        return apply_filters( 'capacious_homepage_service_option', $capacious_homepage_service_option );
    }
endif;


/**
 * Satisfied Clients Section Option
 *
 * @since capacious 1.0.0
 *
 * @param null
 * @return array $capacious_homepage_satisfied_clients_option
 *
 */
if ( !function_exists('capacious_homepage_satisfied_clients_option') ) :
    function capacious_homepage_satisfied_clients_option() {
        $capacious_homepage_satisfied_clients_option =  array(
                                             'show'  => esc_html__( 'Show', 'capacious' ),
                                             'hide'  => esc_html__( 'Hide', 'capacious' )
                                              );
        return apply_filters( 'capacious_homepage_satisfied_clients_option', $capacious_homepage_satisfied_clients_option );
    }
endif;



/**
 * Meet Our Team Section Option
 * @since capacious 1.0.0
 *
 * @param null
 * @return array $capacious_homepage_our_team_option
 *
 */
if ( !function_exists('capacious_homepage_our_team_option') ) :
    function capacious_homepage_our_team_option() {
        $capacious_homepage_our_team_option =  array(
                                             'show'  => esc_html__( 'Show', 'capacious' ),
                                             'hide'  => esc_html__( 'Hide', 'capacious' )
                                              );
        return apply_filters( 'capacious_homepage_our_team_option', $capacious_homepage_our_team_option);
    }
endif;


/**
 * Testimonials Section Option
 * @since capacious 1.0.0
 *
 * @param null
 * @return array $capacious_homepage_testimonials_option
 *
 */
if ( !function_exists('capacious_homepage_testimonials_option') ) :
    function capacious_homepage_testimonials_option() {
        $capacious_homepage_testimonials_option =  array(
                                             'show'  => esc_html__( 'Show', 'capacious' ),
                                             'hide'  => esc_html__( 'Hide', 'capacious' )
                                              );
        return apply_filters( 'capacious_homepage_testimonials_option', $capacious_homepage_testimonials_option);
    }
endif;


/**
 * Blog Section Option
 * @since capacious 1.0.0
 *
 * @param null
 * @return array $capacious_homepage_blog_option
 *
 */
if ( !function_exists('capacious_homepage_blog_option') ) :
    function capacious_homepage_blog_option() {
        $capacious_homepage_blog_option =  array(
                                             'show'  => esc_html__( 'Show', 'capacious' ),
                                             'hide'  => esc_html__( 'Hide', 'capacious' )
                                              );
        return apply_filters( 'capacious_homepage_blog_option', $capacious_homepage_blog_option);
    }
endif;


/**
 * Contact Us Section Option
 * @since capacious 1.0.0
 *
 * @param null
 * @return array $capacious_homepage_contact_option
 *
 */
if ( !function_exists('capacious_homepage_contact_option') ) :
    function capacious_homepage_contact_option() {
        $capacious_homepage_contact_option =  array(
                                             'show'  => esc_html__( 'Show', 'capacious' ),
                                             'hide'  => esc_html__( 'Hide', 'capacious' )
                                              );
        return apply_filters( 'capacious_homepage_contact_option', $capacious_homepage_contact_option);
    }
endif;


/**
 * Reset Option Option
 *
 * @since capacious 1.0.0
 *
 * @param null
 * @return array $capacious_reset_option
 *
 */
if ( !function_exists('capacious_reset_option') ) :
    function capacious_reset_option() {
        $capacious_reset_option =  array(
            'do-not-reset' => esc_html__( 'Do Not Reset', 'capacious'),
            'reset-all' => esc_html__( 'Reset All', 'capacious'),
           
        );
        return apply_filters( 'capacious_reset_option', $capacious_reset_option );
    }
endif;


/**
 * Functions for get_theme_mod()
 *
 * @package Canyon Themes
 * @subpackage Capacious
 */

if (!function_exists('capacious_get_option')) :

    /**
     * Get theme option.
     *
     * @since 1.0.0
     *
     * @param string $key Option key.
     * @return mixed Option value.
     */
    function capacious_get_option($key = '')
    {
        if (empty($key))
        {
            return ;
        }
        $capacious_default_options = capacious_get_default_theme_options();

        $default = (isset($capacious_default_options[$key])) ? $capacious_default_options[$key] : '';

        $theme_option = get_theme_mod($key, $default);

        return $theme_option;

    }

endif;



//=============================================================
// Color reset
//=============================================================
if ( ! function_exists( 'capacious_reset_colors' ) ) :

    function capacious_reset_colors($data) {

        
         set_theme_mod('capacious_primary_color_option','#00AEFF');
         
         set_theme_mod('capacious_reset_value_option','do-not-reset');
    }

endif;
 add_action( 'capacious_colors_reset', 'capacious_reset_colors', 10 );


