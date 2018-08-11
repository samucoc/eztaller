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
$section_option = capacious_get_option( 'capacious_homepage_about_option' );
if( $section_option != 'hide' ) 
{
	$section_title = capacious_get_option( 'capacious_about_section_title' );
	$section_sub_title = capacious_get_option( 'capacious_about_section_sub_title' );
	$about_section_id =  capacious_get_option( 'capacious_about_section_id');
	 
	  if(!empty($about_section_id ))
	{
	    global $image_paths;
	    $about_section_page_id = absint( capacious_get_option( 'capacious_about_page_id'));
		if( !empty( $about_section_page_id ) )
		{
			$page_query = new WP_Query( 'page_id='.$about_section_page_id );
			if( $page_query -> have_posts() )
			{
				while( $page_query -> have_posts() ) 
				{
					$page_query -> the_post();
					if(has_post_thumbnail())
					{
		               $image_id = get_post_thumbnail_id();
		               $image_url = wp_get_attachment_image_src($image_id,'full',true);
		               $image_paths= $image_url[0];
		            }   
	?>
					    <section id="<?php echo esc_attr($about_section_id); ?>" class="about-section">
					      <div class="section-padding">
					        <div class="container">
					          <div class="row about-list">
					            <div class=" <?php if(!empty($image_paths)) { echo "col-md-6"; } else { echo "col-md-12" ;}?> col-xs-12 item wow fadeInLeft">
						              <header class="page-header section-header">
						                <h1><?php echo esc_html($section_title) ?></h1>
						                <span><?php echo esc_html($section_sub_title) ?></span> 
						              </header>
						               <p><?php echo esc_html( wp_trim_words(get_the_content(),100));  ?> </p>
						               <a class=" btn btn-theme hvr-sweep-to-right" href="<?php the_permalink() ?>"><?php echo esc_html__("Read More","capacious"); ?></a> 
		                           
					            </div>
					            <?php
	     			            	if(!empty($image_paths)){
						         ?>
							            <div class="col-md-6 hidden-xs item wow fadeInRight"> 
							              <img src="<?php echo esc_url($image_paths);?>" alt="" class="img-responsive">
							            </div>
							    <?php } wp_reset_postdata();?>  

					          </div>
					        </div>
					      </div>
					    </section>
	<?php 
	            } 
	        } 
	    }
	}
}
			


  ?>