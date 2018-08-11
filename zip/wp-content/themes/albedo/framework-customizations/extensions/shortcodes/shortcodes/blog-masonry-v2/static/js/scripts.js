(function($){

	"use strict";

	function wplab_albedo_blog_masonry_v2_carousel_init() {
		$('.shortcode-blog-masonry-v2 .post-gallery-carousel').each( function() {

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

	function wplab_albedo_blog_masonry_v2_init( gridId ) {

		var $grid = $('#' + gridId),
		margins = parseInt( $grid.data('grid-margins') ) / 2;

		$grid.find('.grid-item').css('padding', margins + 'px');
		$grid.css('margin-left', - margins + 'px' );
		$grid.css('margin-right', - margins + 'px' );
		$grid.css('margin-top', - margins + 'px' );

		new AnimOnScroll( document.getElementById( gridId ), {
			minDuration : 0.4,
			maxDuration : 0.7,
			viewportFactor : 0.2
		});

		wplab_albedo_blog_masonry_v2_carousel_init();
	}

	function wplab_albedo_blog_masonry_v2_load_more( $moreElement, $shortcodeContainer, $grid, nextPage, newPage, maxPages ) {

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
				wplab_albedo_blog_masonry_v2_init( $grid.attr('id') );

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

	window.albedo_blog_masonry_v2_init = function() {

		$('.shortcode-blog-masonry-v2').each( function() {

			var $shortcode = $(this),
			gridId = $shortcode.find('ul.grid').attr('id'),
			$grid = $('#' + gridId);

			wplab_albedo_blog_masonry_v2_init( gridId );

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

				wplab_albedo_blog_masonry_v2_load_more( $link, $shortcode, $grid, nextPage, newPage, maxPages );

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

								wplab_albedo_blog_masonry_v2_load_more( $infiniteScrollPagination, $shortcode, $grid, nextPage, newPage, maxPages );

							}

						});

					}
				});
			}

		});

	}

	window.albedo_blog_masonry_v2_init();

})( window.jQuery );
