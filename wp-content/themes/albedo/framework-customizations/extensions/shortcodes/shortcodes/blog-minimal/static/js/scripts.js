(function($){

	"use strict";

	function wplab_albedo_blog_minimal_load_more( $moreElement, $shortcodeContainer, $postsContainer, nextPage, newPage, maxPages ) {

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

				$shortcodeContainer.find('.video-bg-section').each( function() {

					var videoId = $(this).data('video-id');
					var mute = window.themeFrontCore.stringToBoolean( $(this).data('video-mute') );
					var pauseOnScroll = window.themeFrontCore.stringToBoolean( $(this).data('video-pause-scroll') );

					$( '#' + $(this).attr('id') + ' .video-bg' ).YTPlayer({
						videoId: videoId,
						mute: mute,
						pauseOnScroll: pauseOnScroll
					});

				});

				$moreElement.removeClass('loading');
				$shortcodeContainer.removeClass('loading');

				$moreElement.data('next-page', answer.next_page );

				if( newPage > maxPages ) {
					$moreElement.hide();
				}

			}
		});

	}

	window.albedo_blog_minimal_init = function() {
		$('.shortcode-blog-minimal').each( function() {
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

				wplab_albedo_blog_minimal_load_more( $link, $shortcode, $postsContainer, nextPage, newPage, maxPages );

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

						wplab_albedo_blog_minimal_load_more( $infiniteScrollPagination, $shortcode, $postsContainer, nextPage, newPage, maxPages );

					}

				});

			}

		});
	}

	window.albedo_blog_minimal_init();

})( window.jQuery );
