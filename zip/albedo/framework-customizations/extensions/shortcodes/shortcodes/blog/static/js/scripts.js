(function($){

	"use strict";

	window.wplab_albedo_blog_carousel_init = function() {
		$('.shortcode-blog .post-gallery-carousel').each( function() {

			// vars
			var $elem = $(this),
			id = $elem.attr('id'),
			options = {
				pagination: '#' + id + ' .swiper-pagination',
				paginationClickable: true,
				spaceBetween: 0,
				slidesPerView: 1,
				autoHeight: true,
				effect: 'fade'
			};

			// run the swiper
			setTimeout( function() {
				var swiper = new Swiper('#' + id + ' .swiper-container', options );
			}, 800);

		});
	}

	window.wplab_albedo_blog_carousel_init();

	function wplab_albedo_blog_load_more( $moreElement, $shortcodeContainer, $postsContainer, nextPage, newPage, maxPages ) {

		$.ajax({
			url: wprotoEngineVars.ajaxurl,
			type: "POST",
			dataType: "json",
			data: {
				'action' : 'wplab_albedo_ajax_query_posts',
				'query_type' : 'load_more',
				'atts' : $moreElement.data('atts'),
				'paged' : nextPage
			},
			beforeSend: function() {

				$moreElement.addClass('loading');
				$shortcodeContainer.addClass('loading');

			},
			success: function( answer ) {

				$postsContainer.append( answer.html );

				wplab_albedo_blog_carousel_init();

				$moreElement.removeClass('loading');
				$shortcodeContainer.removeClass('loading');

				$moreElement.data('next-page', answer.next_page );

				if( newPage > maxPages ) {
					$moreElement.hide();
				}

				$('article, li.article').fitVids();

			}
		});

	}

	window.albedo_blog_init = function() {
		$('.shortcode-blog').each( function() {
			var $shortcode = $(this),
			$postsContainer = $shortcode.find('.posts-container');

			// AJAX Pagination: Load More button
			$shortcode.find( '.ajax-pagination-button').click( function() {
				if( $shortcode.hasClass('loading') ) {
					return false;
				}

				var $link = $(this),
				maxPages = parseInt( $link.data('max-pages') ),
				nextPage = parseInt( $link.data('next-page') ),
				newPage = nextPage + 1;

				$link.data('next-page', newPage );

				wplab_albedo_blog_load_more( $link, $shortcode, $postsContainer, nextPage, newPage, maxPages );

				return false;
			});

			// Infinite Scroll
			var $infiniteScrollPagination = $shortcode.find('.pagination.style-infinite');
			if ( $infiniteScrollPagination.length ) {

				var pos = $infiniteScrollPagination.offset().top - $(window).height();

				$(window).scroll( function(){

					var maxPages = parseInt( $infiniteScrollPagination.data('max-pages') ),
					nextPage = parseInt( $infiniteScrollPagination.data('next-page') ),
					newPage = nextPage + 1;

					if( $(window).scrollTop() >= pos && $infiniteScrollPagination.hasClass('loading') == false && ( nextPage <= maxPages ) ) {

						wplab_albedo_blog_load_more( $infiniteScrollPagination, $shortcode, $postsContainer, nextPage, newPage, maxPages );

					}

				});

			}

		});
	}

	window.albedo_blog_init();

})( window.jQuery );
