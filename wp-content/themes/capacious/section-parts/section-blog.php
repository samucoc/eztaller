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
$section_option = capacious_get_option ( 'capacious_homepage_blog_option');
if( $section_option != 'hide' ) {
   $section_title =  capacious_get_option ( 'capacious_blog_section_title');
   $section_sub_title =  capacious_get_option( 'capacious_blog_section_sub_title');
   $view_all_text =  capacious_get_option( 'capacious_blog_section_view_all_text');
   $section_cat_id =   capacious_get_option( 'capacious_blog_categories_id');
   $blog_section_id=capacious_get_option( 'capacious_blog_section_id');
    if( $section_cat_id >= 0)
    {
      $category = get_category($section_cat_id);
?>
  <section id="<?php echo esc_attr($blog_section_id); ?>" class="section-padding">
        <div class="container">
          <header class="page-header section-header section-header-blog">
            <h1><?php echo esc_html($section_title) ?></h1>
            <span><?php echo esc_html($section_sub_title) ?></span>
          </header>
         <?php
          if(!empty($view_all_text) && $section_cat_id!=0 )
          {
         ?> 
          <div class="view-all text-right">
              <a href="<?php echo esc_url( get_category_link( $section_cat_id ) ); ?>" class="btn btn-theme hvr-sweep-to-right"><?php echo esc_html ($view_all_text ); ?></a>
          </div>
       <?php } ?>

         
          <div class="row">
            <?php  
               $section_cat_id = absint( capacious_get_option( 'capacious_blog_categories_id'));
             
                  
                    $sticky = get_option( 'sticky_posts' );
                   if ($section_cat_id !=0)
                   {
                      
                      $home_blog_section = array( 'cat' => $section_cat_id,'posts_per_page' =>3,  'ignore_sticky_posts' => true,'post__not_in' => $sticky,'order' => 'DESC');
                    }
                    else
                    {
                         
                        $home_blog_section = array(
                                    'ignore_sticky_posts' => true,
                                    'post__not_in' => $sticky,
                                    'post_type' => 'post',
                                    'posts_per_page' => 3,
                                    'order' => 'DESC'
                                );
                    }
                      $home_blog_section_query = new WP_Query( $home_blog_section);
                      if( $home_blog_section_query->have_posts() ) {
                         while( $home_blog_section_query->have_posts() ) {
                                $home_blog_section_query->the_post();
              ?>  
                    <div class="col-md-4 col-lg-4">
                      <div class="section-blog-box wow fadeInUp">
                        <?php 
                           if(has_post_thumbnail()) {
                                $image_id = get_post_thumbnail_id();
                                $image_url = wp_get_attachment_image_src($image_id,'full',true);
                         ?>
                             <img src="<?php  echo esc_url($image_url[0]) ?>" class="img-responsive" alt="<?php the_title_attribute(); ?>">
                         <?php } ?>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="row">
                              <div class="col-md-12 col-lg-12">
                                <div class="entry-meta">
                                    <span class="poston"><a class="btn btn-theme btn-sm"><i class="fa fa-clock-o"></i>  <?php echo esc_html(get_the_date( 'F,d,Y' )); ?></a></span>
                                    <span class="author"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>" class="btn btn-theme btn-sm"><i class="fa fa-user"></i> <?php echo esc_html( get_the_author_meta('display_name')) ?></a></span>
                                </div>
                              </div>
                            </div>
                            <p><?php echo esc_html( wp_trim_words(get_the_content(),7) );  ?></p>
                      </div>
                    </div>
                <?php }  wp_reset_postdata(); } ?>
          </div>
        </div>
      </section>

  <?php } } ?>