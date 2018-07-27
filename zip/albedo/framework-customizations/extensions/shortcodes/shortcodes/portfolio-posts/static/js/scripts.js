(function($){

	"use strict";

	function wplab_albedo_portfolio_masonry_grid_lightbox_init( $shortcode ) {
		$shortcode.find('.lightbox-link').lightGallery({
			mode: wplabAlbedoPortfolioMasonryGrid.lightboxEffect,
			cssEasing: 'cubic-bezier(' + wplabAlbedoPortfolioMasonryGrid.lightboxEasing +')',
			download: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioMasonryGrid.lightboxDownload ),
			zoom: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioMasonryGrid.lightboxZoom ),
			fullScreen: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioMasonryGrid.lightboxFullscreen ),
			autoplay: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioMasonryGrid.lightboxAutoplay ),
			thumbnail: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioMasonryGrid.lightboxThumbs ),
			getCaptionFromTitleOrAlt: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioMasonryGrid.lightboxCaptions ),
			progressBar: false,
			autoplayControls: true,
			pause: parseInt( wplabAlbedoPortfolioMasonryGrid.lightboxAutoplaySpeed ),
			selector: 'this'
		});
	}

	function wplab_albedo_portfolio_masonry_grid_init( gridId ) {

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
	}

	function wplab_albedo_portfolio_masonry_grid_load_more( $moreElement, $shortcodeContainer, $grid, nextPage, newPage, maxPages ) {

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
				wplab_albedo_portfolio_masonry_grid_init( $grid.attr('id') );

				// lightbox
				if( $shortcodeContainer.hasClass('with-lightbox') ) {
					wplab_albedo_portfolio_masonry_grid_lightbox_init( $shortcodeContainer );
				}

				$moreElement.removeClass('loading');
				$shortcodeContainer.removeClass('loading');

				$moreElement.data('next-page', answer.next_page );

				if( newPage > maxPages ) {
					$moreElement.hide();
				}

			}
		});

	}

	window.wplab_albedo_portfolio_posts_init = function() {
		$('.portfolio-masonry-grid-shortcode').each( function() {

			var $shortcode = $(this),
			gridId = $shortcode.find('ul.grid').attr('id'),
			$grid = $('#' + gridId),
			$filters = $shortcode.find('.posts-filters a');

			wplab_albedo_portfolio_masonry_grid_init( gridId );

			// lightbox
			if( $shortcode.hasClass('with-lightbox') ) {
				wplab_albedo_portfolio_masonry_grid_lightbox_init( $shortcode );
			}

			// init filters
			$filters.click( function() {

				if( $shortcode.hasClass('loading') ) {
					return false;
				}

				$filters.removeClass('current');
				var $link = $(this),
				$container = $link.parent(),
				$loadMoreButton = $shortcode.find('.ajax-pagination-button, .pagination.style-infinite');

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

						$shortcode.addClass('loading');

						$.each( $grid.find('.item'), function( index, item) {
							setTimeout( function() {
								$( item ).addClass('fadeOut animated');
							}, 150 * index );
						});

					},
					success: function( answer ) {

						$grid.html( answer.html );
						$shortcode.removeClass('loading');
						wplab_albedo_portfolio_masonry_grid_init( gridId );

						// Check posts count for Load More Button
						$loadMoreButton.data('next-page', answer.next_page).data('max-pages', answer.max_pages ).data('atts', answer.atts);
						if( answer.next_page > answer.max_pages ) {
							$loadMoreButton.hide();
						} else {
							$loadMoreButton.show();
						}

						// lightbox
						if( $shortcode.hasClass('with-lightbox') ) {
							wplab_albedo_portfolio_masonry_grid_lightbox_init( $shortcode );
						}

					}
				});

				return false;

			});

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

				wplab_albedo_portfolio_masonry_grid_load_more( $link, $shortcode, $grid, nextPage, newPage, maxPages );

				// lightbox
				if( $shortcode.hasClass('with-lightbox') ) {
					wplab_albedo_portfolio_masonry_grid_lightbox_init( $shortcode );
				}

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

								wplab_albedo_portfolio_masonry_grid_load_more( $infiniteScrollPagination, $shortcode, $grid, nextPage, newPage, maxPages );

								// lightbox
								if( $shortcode.hasClass('with-lightbox') ) {
									wplab_albedo_portfolio_masonry_grid_lightbox_init( $shortcode );
								}

							}

						});

					}
				});
			}

		});
	}

	window.wplab_albedo_portfolio_posts_init();

})( window.jQuery );
