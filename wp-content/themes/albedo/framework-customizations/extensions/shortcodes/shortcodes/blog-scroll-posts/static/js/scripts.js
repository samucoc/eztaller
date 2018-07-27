(function($){

	"use strict";

	window.albedo_blog_scroll_posts_init = function() {
		$('.shortcode-blog-scroll-posts .inside').each( function() {

			$(this).scrollbox();

		});
	}

	window.albedo_blog_scroll_posts_init();

})( window.jQuery );
