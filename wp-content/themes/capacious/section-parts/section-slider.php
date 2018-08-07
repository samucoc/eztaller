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
$section_option = capacious_get_option( 'capacious_homepage_slider_option' );
if( $section_option != 'hide' ) {
	$section_image = capacious_get_option( 'capacious_slider_section_image' );
	$section_cat_id = capacious_get_option('capacious_slider_cat_id');
  
if(!empty($section_cat_id))
{

   $category = get_category($section_cat_id);

   $count = $category->category_count;

 if($count>0)
 {
?>
 <section id="banner" class="banner-section">
    <div class="section-padding">
      <div id="carousel-slider" class="carousel slide" data-interval="4000">
      <!-- Indicators -->
      <?php 
	    	if($count>1)
			 {
	    ?> 
        <ol class="carousel-indicators">
            <?php
              $category = get_category($section_cat_id);
              $count = $category->category_count;
             for($i=0;$i<$count;$i++)
             {
               ?>
		          <li data-target="#carousel-slider" data-slide-to="<?php echo absint($i) ; ?>" class=" <?php if($i== 0){ echo 'active' ;} ?>">
		          </li>
           <?php } ?>
        </ol>
      <?php } ?>  
        <div class="carousel-inner">
            <?php
                $i=0;
	           	
				if( !empty( $section_cat_id ) ) {
					$home_slider_section =  array( 'cat' => $section_cat_id, 'posts_per_page' => -1 );
					 $home_slider_section_query = new WP_Query( $home_slider_section);
					if( $home_slider_section_query->have_posts() ) {

                 	while( $home_slider_section_query->have_posts() ) {
						$home_slider_section_query->the_post();
						 
                   ?>
			        <div class="item <?php if($i== 0){ echo esc_attr("active","capacious"); } ?>" style="background-image: url(<?php echo esc_url($section_image) ?>);">
			            <div class="container">
				              <div class="col-md-7 col-sm-12 dest-detail wow fadeInLeft" data-wow-duration="3s">
				                <div class="titles">
				                  <h1><?php the_title() ?></h1>
				                 </div>
				                <p><?php echo esc_html(wp_trim_words(get_the_content(),15 ));  ?> </p>
                           
				                <a href="<?php the_permalink(); ?>" class="btn btn-theme hvr-sweep-to-right"><?php echo esc_html__("Get Started",'capacious');?></a> 
                           
				              </div>
			              <div class="col-md-5 hidden-xs  wow fadeInRight" data-wow-duration="3s">
			              		<?php if(has_post_thumbnail()){
					                   $image_id = get_post_thumbnail_id();
					                   $image_url = wp_get_attachment_image_src($image_id,'full',true); ?>
					              		  <img src="<?php echo esc_url($image_url[0]) ?>" alt="" class="img-responsive">
					             <?php } ?>
			              </div>
			            </div>
			        </div>
                 <?php
                	  $i++; 
                	     }
				       }
					wp_reset_postdata();
				}
        ?>
        </div>

	    <?php 
	    	if($count>1)
			 {
	    ?>    
	        <a class="left carousel-control" href="#carousel-slider" role="button" data-slide="prev">
	          <i class="fa fa-chevron-left"></i>
	        </a>
	        <a class="right carousel-control" href="#carousel-slider" role="button" data-slide="next">
	          <i class="fa fa-chevron-right"></i>
	        </a>
      <?php } ?>


      </div>
    </div>
  </section>
  <?php } } }?>