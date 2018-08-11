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
$section_option = capacious_get_option( 'capacious_homepage_our_team_option');
if( $section_option != 'hide' ) {
  $section_title = capacious_get_option( 'capacious_our_team_section_title' );
  $section_sub_title = capacious_get_option( 'capacious_our_team_section_sub_title' );
  $team_section_id = capacious_get_option( 'capacious_our_team_section_id');
  $section_cat_id = capacious_get_option( 'capacious_our_team_cat_id');
  if(!empty($section_cat_id))
{

  $category = get_category($section_cat_id);
   $count = $category->category_count;
 if($count>0)
 {
 ?>
   <section id="<?php echo esc_attr($team_section_id) ; ?>" class="team-section section-padding">
      <div class="container">
        <header class="page-header section-header">
          <h1><?php echo esc_html($section_title) ?></h1>
          <span><?php echo esc_html($section_sub_title) ?></span>
        </header>  
      
        <div class="team-list">
             <?php
                $i=0;
               
                if( !empty( $section_cat_id ) ) {
                      $home_team_section = array( 'cat' => $section_cat_id,'posts_per_page' => 4 );
                      $home_team_section_query = new WP_Query( $home_team_section);
                      if( $home_team_section_query->have_posts() ) {
                         while( $home_team_section_query->have_posts() ) {
                            $home_team_section_query->the_post();
                          if(has_post_thumbnail()){
                            $image_id = get_post_thumbnail_id();
                            $image_path = wp_get_attachment_image_src( $image_id, 'small', true );
                           }
                            $designation = get_post_meta( get_the_ID(), 'capacious_pro_designation', true );
                             ?>
                              <div class="col-lg-6 col-md-6 col-sm-6 item wow <?php if($i%2!=0){ echo 'fadeInRight'; } else { echo 'fadeInLeft'; } ?>">
                                <div class="col-lg-6 col-md-12 content-wrap hvr-bounce-to-top">
                                    <h6><?php the_title(); ?></h6>
                                    <span><?php the_excerpt(); ?></span>
                                   <p><?php echo esc_html( wp_trim_words(get_the_content(),38))?></p>
                                </div>
                                <?php if(!empty($image_path )) { ?>
                                    <div class="col-lg-6 col-md-12 img-wrap"><img src="<?php echo esc_url($image_path[0]);?>" alt="">
                                    </div>
                                <?php } ?>
                              </div>
                 <?php
                     $i++;}
                  }
                 wp_reset_postdata();
                }    
            ?>
        </div>
      </div>
    </section>
  <?php }}} ?>