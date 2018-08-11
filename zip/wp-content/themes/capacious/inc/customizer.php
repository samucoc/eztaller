<?php
/**
 * capacious Theme Customizer.
 *
 * @package capacious
*/
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

require get_template_directory() . '/inc/customizer/customizer-pro/class-customize.php';
function capacious_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    $default = capacious_get_default_theme_options();
	/**
    * Customizer setting 
    */
    require get_template_directory() . '/inc/customizer/capacious-customizer-function.php';
    require get_template_directory() . '/inc/customizer/capacious-sanitize.php';
    require get_template_directory() . '/inc/customizer/customizer.php';
    require get_template_directory() . '/inc/customizer/capacious-layout-design-options.php';
    require get_template_directory() . '/inc/customizer/capacious-theme-options.php';
}
add_action( 'customize_register', 'capacious_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function capacious_customize_preview_js() {
	wp_enqueue_script( 'capacious-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'capacious_customize_preview_js' );
/**
 * Binds JS handlers for Admin section.
 */
function capacious_customize_backend_scripts() {
   
    wp_enqueue_style( 'capacious-custom-font-awesome', get_template_directory_uri() . '/inc/customizer/css/custom_font_awesome.css', array(), '7.1.0' );  

    wp_enqueue_script( 'capacious-admin-customizer', get_template_directory_uri() . '/inc/customizer/js/admin-scripts.js', array( 'jquery', 'customize-controls' ), '20160714', true );
     
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '7.1.0' );
    
}
add_action( 'customize_controls_enqueue_scripts', 'capacious_customize_backend_scripts', 10 );


