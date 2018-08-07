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
$section_option = capacious_get_option( 'capacious_homepage_quote_option');
if( $section_option != 'hide' ) {
	$quote_title = capacious_get_option( 'capacious_quote_section_title' );
	$quote_a_quote_text = capacious_get_option( 'capacious_quote_get_a_quate_txt');
	$quote_a_quote_link = capacious_get_option( 'capacious_quote_get_a_quate_link');
?>
    <section class="process">
	    <div class="container">
	      <div class="content">
	        <div class="col-md-8 des wow bounceInLeft" data-wow-duration="0.3s"> <?php echo esc_html($quote_title) ?></div>
	        
	       <?php if(!empty($quote_a_quote_text)) { ?>
	               <div class="col-md-4 wow bounceInRight" data-wow-duration="0.3s"> <a href="<?php echo esc_url($quote_a_quote_link) ?>" target="_blank" class="btn btn-theme hvr-sweep-to-right"><?php echo esc_html($quote_a_quote_text) ?></a> 
	               </div>
           <?php } ?>

	      </div>
	    </div>
    </section>
  <?php } ?>