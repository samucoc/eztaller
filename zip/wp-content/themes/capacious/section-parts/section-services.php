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
// retrieving Customizer Value 
$section_option = capacious_get_option( 'capacious_homepage_service_option');
if( $section_option != 'hide' ) {
	$section_title = capacious_get_option( 'capacious_services_section_title');
	$section_sub_title = capacious_get_option( 'capacious_services_section_sub_title' );
	$section_bg_image = capacious_get_option( 'capacious_services_section_image' );
  $service_section_id = capacious_get_option( 'capacious_services_section_id' );
?>
	

      <section id="<?php echo esc_attr($service_section_id); ?>" class="section-padding services-section">
      <div class="container">
        <div class="row">
          <div class="col-md-7 wow fadeInLeft">
            <header class="page-header section-header">
               <h1><?php echo esc_html($section_title) ?></h1>
	           <span><?php echo esc_html($section_sub_title) ?></span> 
            </header>
                <?php
                   $capacious_default_service_icon = array( 'fa-desktop', 'fa-print', 'fa-paint-brush', 'fa-mobile','fa-flash','fa-support' );
                	 $capacious_separator_label = array( 'First', 'Second', 'Third', 'Forth', 'Fifth', 'Sixth' );

                     foreach ( $capacious_separator_label as $icon_key => $icon_value) { 

                		$service_icon=capacious_get_option( 'capacious_service_icon_'.$icon_key,$capacious_default_service_icon[$icon_key] );
                		$service_page_id_value = capacious_get_option('capacious_service_page_id_'.$icon_key);
                	if( !empty( $service_page_id_value ) ) {
                		 $service_page_query = new WP_Query( array( 'page_id' => $service_page_id_value ) );
								if( $service_page_query->have_posts() ) {
									while ( $service_page_query->have_posts() ) {
										$service_page_query->the_post();
                ?>
								              <div class="col-md-6 col-xs-12 item">
                               <?php if( !empty($service_icon ) ) { ?>
								                   <i class=" fa <?php echo esc_attr($service_icon); ?>"> </i>
                                 <?php } ?>
								                <div class="media-left">
                                   <h6><?php the_title(); ?></h6>

								                  <p><?php echo esc_html( wp_trim_words(get_the_content(),8));  ?> </p>
								                </div>
								              </div>
			     <?php 	              
								               }

								           }  
                          wp_reset_postdata();     
                       }
                    } 

                    ?>
          </div>
          <div class="col-md-5 col-xs-12 hidden-xs wow fadeInRight">
            <figure class="fluid-image-outer">
              <img src="<?php echo esc_url($section_bg_image) ?>" alt=""> 
            </figure>
          </div>
         </div>
      </div>
    </section>
  <?php } ?>