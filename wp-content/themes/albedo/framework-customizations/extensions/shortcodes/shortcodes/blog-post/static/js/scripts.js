(function($){

	"use strict";

	window.albedo_blog_post_init = function() {

		$('.shortcode-blog-post.post-format-gallery').each( function() {

			var $block = $(this);

			$block.find('.gallery-pagination a').click( function() {

				var $link = $(this),
				img = $link.data('img');

				$link.parent().find('a').removeClass('current');
				$link.addClass('current');

				$block.find('.inside').css('background-image', 'url(' + img + ')');

				return false;

			});

		});

	}

	window.albedo_blog_post_init();

})( window.jQuery );
