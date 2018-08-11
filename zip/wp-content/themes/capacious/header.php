<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package capacious
 */
$enable_topheader_section= capacious_get_option('capacious_top_header_section');
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="UTF-8">
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<?php wp_head(); ?>
</head>
<body data-spy="scroll" data-target=".scrollspy" <?php body_class(); ?>>
   <!-- preloader -->
   <!-- preloader -->
  <div class="preloader">
    <div class="loader">&nbsp;</div>
  </div>
 
   <!--Header Section Start Here -->
   <?php  $section_id = capacious_get_option( 'slider_section_id'); ?>
  <header class="header-section" id="<?php echo esc_attr($section_id); ?>" >
   <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'capacious' ); ?></a>
       <?php
        
            if( $enable_topheader_section != 'hide' ) {
              $phone_number = capacious_get_option( 'capacious_top_header_phone_no');
              $email_address = capacious_get_option( 'capacious_top_header_email');
              $phone_no_icon = capacious_get_option( 'capacious_phone_number_icon');
              $email = capacious_get_option( 'capacious_email_icon');
            ?>
              <div class="top-header">
               <div class="container">
                 <div class="row ">
                   <ul class="contact-detail2 col-sm-7 pull-left">
                    <?php
                      if(!empty($phone_number))
                      {
                     ?> 
                      <li> <a href="<?php echo esc_url('tel:'.$phone_number) ?>" target="_blank"><i class="fa <?php echo esc_attr($phone_no_icon); ?>"></i><?php echo esc_html($phone_number); ?></a> </li>
                     <?php }
                      if(!empty($email_address))
                      {
                     ?>

                     <li> <a href="<?php echo esc_url('mailto:'.$email_address); ?>" target="_blank"><i class="fa <?php echo esc_attr($email); ?>"></i> <?php echo esc_html($email_address); ?></a> </li>
                    <?php } ?>
                   </ul>
                   <?php if( has_nav_menu( 'social-menu' ) ){ ?>
                   <div class="social-links col-xs-12 col-sm-5 pull-right">

                      <?php wp_nav_menu( array( 'theme_location' => 'social-menu', 'menu_class' => 'social-icons hidden-xs pull-right' ) ); ?>
                      <?php } ?>
                   </div>
                 </div>
               </div>
             </div>
        <?php } ?>
    <div id="nav" class="navbar navbar-static-top">
      <div class="container main-menu">
        <div class="navbar-header" >
          <button aria-expanded="false" aria-controls="bs-navbar" data-target="#bs-navbar" data-toggle="collapse" type="button" class="navbar-toggle collapsed"> 
            <span class="sr-only"><?php echo esc_html__("Toggle navigation","capacious"); ?></span> 
            <span class="icon-bar"></span> <span class="icon-bar"></span> 
            <span class="icon-bar"></span> 
          </button>
          <div class="navbar-brand">
          <?php 
            if(has_custom_logo())
             { 
          ?>
           <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
              <?php the_custom_logo();?>
          </a> 

           <?php
         } else {
				if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				endif;
         
				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo esc_html($description); /* WPCS: xss ok. */ ?></p>
					<?php
				endif;
         }
         ?>
        </div>
        </div>
       <?php if( has_nav_menu( 'primary' ) ){?>
        <nav class="collapse navbar-collapse pull-right" id="bs-navbar">
          <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav navbar-nav' ) ); ?>
          
        </nav>
       <?php } ?> 
      </div>
    </div>
  </header>
  <!-- Header Section End Here --> 




  
