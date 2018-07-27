(function($){

	"use strict";

	function wplab_albedo_blog_media_grid_gallery_init( $postsContainer ) {

		$postsContainer.find('article.format-gallery .gallery-pagination .pagination-link').off('click').on('click', function() {

			var $link = $(this),
			$links = $link.parent().find('a'),
			images = $link.data('images'),
			index = parseInt( $link.data('index') ),
			imagesLen = images.length;

			if( $link.hasClass('pagination-right') ) {
				index = index + 1;
				index = index % imagesLen;

			} else {

				if (index === 0) {
					index = imagesLen;
				}
				index = index - 1;

			}

			$link.parents('article').find('.thumb').css('background-image', 'url(' + images[ index ] + ')' );
			$links.data('index', index ).attr('data-index', index);

			return false;
		});

	}

	function wplab_albedo_blog_media_grid_load_more( $moreElement, $shortcodeContainer, $grid, nextPage, newPage, maxPages ) {

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

				$grid.append( answer.html );
				wplab_albedo_blog_media_grid_gallery_init( $grid );

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

	window.albedo_blog_media_grid_init = function() {

		$('.shortcode-blog-media-grid').each( function() {

			var $shortcode = $(this),
			gridId = $shortcode.find('.blog-media-grid-posts').attr('id'),
			$grid = $('#' + gridId);

			wplab_albedo_blog_media_grid_gallery_init( $grid );

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

				wplab_albedo_blog_media_grid_load_more( $link, $shortcode, $grid, nextPage, newPage, maxPages );

				return false;
			});

			// Infinite Scroll
			var $infiniteScrollPagination = $shortcode.find('.pagination.style-infinite');
			if ( $infiniteScrollPagination.length ) {

				$grid.waitForImages({
					waitForAll: true,
					finished: function() {

						var pos = $infiniteScrollPagination.offset().top - $(window).height();

						$(window).scroll( function(){

							var maxPages = parseInt( $infiniteScrollPagination.data('max-pages') ),
							nextPage = parseInt( $infiniteScrollPagination.data('next-page') ),
							newPage = nextPage + 1;

							if( $(window).scrollTop() >= pos && $infiniteScrollPagination.hasClass('loading') == false && ( nextPage <= maxPages ) ) {

								wplab_albedo_blog_media_grid_load_more( $infiniteScrollPagination, $shortcode, $grid, nextPage, newPage, maxPages );

							}

						});

					}
				});
			}

		});

	}

	window.albedo_blog_media_grid_init();

})( window.jQuery );
