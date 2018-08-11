(function($){

	"use strict";

	function wplab_albedo_shop_load_more( $moreElement, $postsContainer, $shortcodeContainer, nextPage, newPage, maxPages ) {

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

				$moreElement.removeClass('loading');
				$shortcodeContainer.removeClass('loading');

				$moreElement.data('next-page', answer.next_page );

				if( newPage > maxPages ) {
					$moreElement.hide();
				}

			}
		});

	}

	window.wplab_albedo_shop_init = function() {
		// Justified Gallery Grid
		var $items = $('.shop-shortcode');

		if( $items.length ) {

			$items.each( function() {

				var $this = $(this);

				// filtering


				// Infinite Scroll
				var $infiniteScrollPagination = $this.find('.pagination.style-infinite');
				if ( $infiniteScrollPagination.length ) {

					$items.waitForImages({
						waitForAll: true,
						finished: function() {

							var $postsContainer = $( '#' + $infiniteScrollPagination.data('posts-container-id') ),
							pos = $infiniteScrollPagination.offset().top - $(window).height();

							$(window).scroll( function(){

								var maxPages = parseInt( $infiniteScrollPagination.data('max-pages') ),
								nextPage = parseInt( $infiniteScrollPagination.data('next-page') ),
								newPage = nextPage + 1;

								if( $(window).scrollTop() >= pos && $infiniteScrollPagination.hasClass('loading') == false && ( nextPage <= maxPages ) ) {

									wplab_albedo_shop_load_more( $infiniteScrollPagination, $postsContainer, $items, nextPage, newPage, maxPages );

								}

							});

						}
					});

				}

				// AJAX Pagination: Load More button
				$this.find( '.ajax-pagination-button').click( function() {

					if( $items.hasClass('loading') ) {
						return false;
					}

					var $link = $(this),
					$postsContainer = $( '#' + $link.data('posts-container-id') ),
					maxPages = parseInt( $link.data('max-pages') ),
					nextPage = parseInt( $link.data('next-page') ),
					newPage = nextPage + 1;

					$link.data('next-page', newPage );

					wplab_albedo_shop_load_more( $link, $postsContainer, $items, nextPage, newPage, maxPages );

					return false;
				});

			});

		}
	}

	window.wplab_albedo_shop_init();

})( window.jQuery );
