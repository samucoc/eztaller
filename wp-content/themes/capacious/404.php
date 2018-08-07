<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package capacious
 */
get_header(); 
$breadcrump_option=capacious_get_option( 'capacious_breadcrump_option');
?>
<div class="header-space"></div>
<section id="inner-title" class="inner-title">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-lg-6"><h2><?php echo esc_html__("404","capacious"); ?></h2></div>
      <div class="col-md-6 col-lg-6">
        <div class="breadcrumbs">
          <?php 
            if('disable'!=$breadcrump_option)
            {
              capacious_breadcrumb_trail();
            }
           ?>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="page-not-404">
  <div class="container">
    <div class="row">
      <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="page-404">
          <h1><?php echo esc_html__("404","capacious"); ?></h1>
          <h2><?php echo esc_html__("Sorry, it appears the page you were looking for dose't exist anymore or might have been moved.","capacious"); ?></h2>
        </div>
      </div>
      <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="page-subscribe">
         	<h3><?php echo esc_html__("Please Search Again","capacious"); ?></h3>
         	<div class="control-group form-group">
            <div class="controls">
              <?php get_search_form();?>
            </div>
          </div>
        </div>  
      </div>
    </div>  
  </div>
</section>  
<?php get_footer();
