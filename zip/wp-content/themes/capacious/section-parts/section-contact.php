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
$section_option =  capacious_get_option( 'capacious_homepage_contact_option' );
if( $section_option != 'hide' ) {
	$section_title =  capacious_get_option( 'capacious_contact_section_title' );
	$section_sub_title =  capacious_get_option( 'capacious_contact_section_sub_title' ) ;
  $contact_section_id =  capacious_get_option( 'capacious_contact_section_id' ) ;
  $section_contact_form= capacious_get_option('capacious_contact_section_form_editor');
  
?>
 <section id="<?php echo esc_attr($contact_section_id) ; ?>" class="contact-section section-padding">
      <div class="container">
        <header class="page-header section-header">
          <h1><?php echo esc_html($section_title) ?></h1>
          <span><?php echo esc_html($section_sub_title) ?></span>
        </header>
      </div>
     <?php
      if(!empty($section_contact_form))
      {
     ?>
        <div class="container form-section">
          <div class="row">
            <div class="form col-sm-12 col-md-12 contact-form wow fadeInLeft">
                    <?php echo do_shortcode($section_contact_form); ?>
            </div>
            
          </div>
        </div>
    <?php } ?>
    </section>
  <?php } ?>