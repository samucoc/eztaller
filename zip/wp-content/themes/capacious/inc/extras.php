<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package capacious
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function capacious_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
   
   if (!is_front_page() || is_home() ) {
		$classes[] = 'inner-page';
	}

    // Add design layout of sidebar
	  
       $sidebardesignlayout= esc_attr(get_post_meta(get_the_ID(), 'capacious_sidebar_layout', true  ));
			if(is_singular() &&  $sidebardesignlayout!="default-sidebar")
		{
		   $sidebardesignlayout=esc_attr( get_post_meta(get_the_ID(), 'capacious_sidebar_layout', true  ));

		}else

		{
			 $sidebardesignlayout = esc_attr( capacious_get_option( 'capacious_sidebar_layout_option'));
		}

	  

	$classes[] = $sidebardesignlayout;


	return $classes;
}
add_filter( 'body_class', 'capacious_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function capacious_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
	}
}
add_action( 'wp_head', 'capacious_pingback_header' );
