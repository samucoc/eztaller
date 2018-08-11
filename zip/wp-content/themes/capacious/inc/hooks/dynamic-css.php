<?php
/**
 * Dynamic css
 *
 * @since capacious 1.0.0
 *
 * @param null
 * @return null
 *
 */

if ( ! function_exists( 'capacious_dynamic_css')):
 function capacious_dynamic_css() {
 

 $primary_color= esc_attr( capacious_get_option( 'capacious_primary_color_option' ));


    $custom_css='';

/*Menu Hover*/
    $custom_css .=".navbar-nav li a:hover{
            color:".$primary_color.";
        }
    ";
    /*Menu Active*/
  $custom_css .=".navbar-nav li.active{
            color:".$primary_color.";
      }
    ";
 
    
    /* Link  color*/
    $custom_css .=" a,
    .news-block .date{
            color:". $primary_color.";
        }
    ";
    /* Link  color Hover*/
    $custom_css .=" a:hover,
    .news-block .date:hover{
            color:".$primary_color.";
        }
    ";
  

    $custom_css .="
        .section-header h1::before,
        .services-section .item .fa, 
        .what-we-section .item ul li .fa,a:hover, .news-block .date:hover,.fa-user:before,.fa-clock-o:before,.fa-comments:before,.fa-tags:before,
        #testimonial .item blockquote img,
        .contact-detail li p i,a.scroll-top,.site-title a, 
        .footer-section .section-header h1::before{
            border-color:".$primary_color.";
        }
    ";
    $custom_css .="
        .btn-theme,
        .process,
        .team-section .item .content-wrap{
            background: ".$primary_color.";
        }
    ";


    /* Button Color Option*/
    $custom_css .="
        .btn-theme, 
        button, 
        input[type=\"button\"], 
        input[type=\"reset\"], 
        input[type=\"submit\"], 
        .nav-links .nav-previous, 
        .nav-links .nav-next, 
        .cat-links a {
            color:#fff;
            background:".$primary_color.";
        }
    ";

$custom_css .="
         .wpcf7-submit{
                background:".$primary_color."!important;
        }
    ";
   
   $custom_css .="
         .site-title a{
                color:".$primary_color.";
        }
    ";


    /* Process Background Color*/
    $custom_css .=" .process,.purchase-now{
            background:".$primary_color.";
        }
    ";
   
   $custom_css.=".single-section .entry-meta span, .single-section .entry-meta span a, span.cat-links
                 {
                     color:".$primary_color.";
                  }  ";
  
    /* Inner Page Header breadcrumb Background color*/
    $custom_css .=".inner-title {
            background: ".$primary_color.";
        }
    ";

      /*==================== Primary Color ========================*/
    $custom_css .=" a,
        .news-block .date,
        .services-section .item .fa,
        .what-we-section .item ul li .fa,
        #testimonial .item blockquote small,.news-block .name span,.news-block .comments i,
        .services-section .item .fa
        {
            color:".$primary_color.";
        }
    ";

    /*------------------------------------------------------------------------------------------------- */

   
    /*custom css*/
   
    wp_add_inline_style( 'capacious-style', $custom_css);

}
endif;
add_action( 'wp_enqueue_scripts', 'capacious_dynamic_css', 99);