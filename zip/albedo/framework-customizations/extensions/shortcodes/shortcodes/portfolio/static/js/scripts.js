(function($){

	"use strict";

	function wplab_albedo_init_portfolio( $elem, rowHeight, rowMaxHeight, margins, captions ) {
		$elem.justifiedGallery({
			rowHeight: parseInt( rowHeight ),
			maxRowHeight: parseInt( rowMaxHeight ),
			lastRow: 'nojustify',
			margins: parseInt( margins ),
			border: 0,
			captions: window.themeFrontCore.stringToBoolean( captions ),
			randomize: false,
			cssAnimation: true,
			selector: 'article',
			captionSettings: {
				animationDuration: 500,
				visibleOpacity: 0.7,
				nonVisibleOpacity: 0.0
			}
		});
	}

	function wplab_albedo_portfolio_load_more( $moreElement, $postsContainer, $shortcodeContainer, $itemsGallery, nextPage, newPage, maxPages ) {

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

				if( ! $('#wplab_albedo_temp_div').length ) {
					$('body').append('<div style="display: none;" id="wplab_albedo_temp_div"></div>');
				}
				var $tempDiv = $('#wplab_albedo_temp_div');
				$tempDiv.append( answer.html );

				$tempDiv.find('.item').css('opacity', '0').addClass('new-item');
				$postsContainer.append( $tempDiv.html() );
				$tempDiv.remove();

				$moreElement.removeClass('loading');
				$shortcodeContainer.removeClass('loading');
				$itemsGallery.justifiedGallery('norewind');

				$moreElement.data('next-page', answer.next_page );

				if( newPage > maxPages ) {
					$moreElement.hide();
				}

				$.each( $postsContainer.find('.new-item'), function( index, item) {
					setTimeout( function() {
						$( item ).addClass('fadeIn animated');
					}, 150 * index );
				});

			}
		});

	}

	window.wplab_albedo_portfolio_init = function() {
		// Justified Gallery Grid
		var $items = $('.portfolio-shortcode');

		if( $items.length ) {

			$items.each( function() {

				var $this = $(this),
				$itemsGallery = $this.find('.justified-gallery'),
				$itemsFilters = $this.find('.posts-filters a'),
				rowHeight = $itemsGallery.data('grid-row-height'),
				rowMaxHeight = $itemsGallery.data('grid-row-max-height'),
				margins = $itemsGallery.data('grid-margins'),
				captions = $itemsGallery.data('grid-captions');

				// init grid
				wplab_albedo_init_portfolio( $itemsGallery, rowHeight, rowMaxHeight, margins, captions );

				// filtering
				$itemsFilters.click( function() {

					if( $items.hasClass('loading') ) {
						return false;
					}

					$items.addClass('loading');

					$itemsFilters.removeClass('current');
					var $link = $(this),
					$container = $link.parent(),
					$postsContainer = $( '#' + $container.data('target-id') ),
					$loadMoreButton = $items.find('.ajax-pagination-button, .pagination.style-infinite');

					$link.addClass('current');

					$.ajax({
						url: wprotoEngineVars.ajaxurl,
						type: "POST",
						dataType: "json",
						data: {
							'action' : 'wplab_albedo_ajax_query_posts',
							'query_type' : 'filter',
							'term' : $link.data('term'),
							'atts' : $container.data('atts')
						},
						beforeSend: function() {

							$.each( $postsContainer.find('.item'), function( index, item) {
								setTimeout( function() {
									$( item ).addClass('fadeOut animated');
								}, 150 * index );
							});

						},
						success: function( answer ) {

							$postsContainer.html( answer.html );
							$postsContainer.find('.item').css('opacity', '0');

							wplab_albedo_init_portfolio( $itemsGallery, rowHeight, rowMaxHeight, margins, captions );
							$items.removeClass('loading');

							// Check posts count for Load More Button
							$loadMoreButton.data('next-page', answer.next_page).data('max-pages', answer.max_pages ).data('atts', answer.atts);
							if( answer.next_page > answer.max_pages ) {
								$loadMoreButton.hide();
							} else {
								$loadMoreButton.show();
							}

							$.each( $postsContainer.find('.item'), function( index, item) {
								setTimeout( function() {
									$( item ).addClass('fadeIn animated');
								}, 150 * index );
							});

						}
					});

					return false;
				});

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

									wplab_albedo_portfolio_load_more( $infiniteScrollPagination, $postsContainer, $items, $itemsGallery, nextPage, newPage, maxPages );

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

					wplab_albedo_portfolio_load_more( $link, $postsContainer, $items, $itemsGallery, nextPage, newPage, maxPages );

					return false;
				});

			});

		}
	}

	window.wplab_albedo_portfolio_init();

})( window.jQuery );
