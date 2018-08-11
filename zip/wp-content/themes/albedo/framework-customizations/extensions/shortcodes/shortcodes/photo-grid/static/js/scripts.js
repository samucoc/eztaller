(function($){

	"use strict";

	function wplab_albedo_init_photo_grid_lightbox( $elem ) {

		// Open media in LightBox
		$elem.lightGallery({
			mode: wplabAlbedoPhotoGrid.lightboxEffect,
			cssEasing: 'cubic-bezier(' + wplabAlbedoPhotoGrid.lightboxEasing +')',
			download: window.themeFrontCore.stringToBoolean( wplabAlbedoPhotoGrid.lightboxDownload ),
			zoom: window.themeFrontCore.stringToBoolean( wplabAlbedoPhotoGrid.lightboxZoom ),
			fullScreen: window.themeFrontCore.stringToBoolean( wplabAlbedoPhotoGrid.lightboxFullscreen ),
			autoplay: window.themeFrontCore.stringToBoolean( wplabAlbedoPhotoGrid.lightboxAutoplay ),
			thumbnail: window.themeFrontCore.stringToBoolean( wplabAlbedoPhotoGrid.lightboxThumbs ),
			getCaptionFromTitleOrAlt: window.themeFrontCore.stringToBoolean( wplabAlbedoPhotoGrid.lightboxCaptions ),
			progressBar: false,
			autoplayControls: true,
			pause: parseInt( wplabAlbedoPhotoGrid.lightboxAutoplaySpeed ),
			selector: 'figure'
		});

	}

	function wplab_albedo_init_photo_grid( $elem, rowHeight, rowMaxHeight, margins ) {
		$elem.justifiedGallery({
			rowHeight: parseInt( rowHeight ),
			maxRowHeight: parseInt( rowMaxHeight ),
			lastRow: 'nojustify',
			margins: parseInt( margins ),
			border: 0,
			captions: false,
			randomize: false,
			cssAnimation: true,
			selector: 'figure, div:not(.spinner)'
		});

		wplab_albedo_init_photo_grid_lightbox( $elem );

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
				$itemsGallery.data('lightGallery').destroy(true);
				wplab_albedo_init_photo_grid_lightbox( $itemsGallery );

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

	window.albedo_portfolio_justified_photos_grid_init = function() {
		// Justified Gallery Grid
		var $items = $('.photo-grid-gallery');

		if( $items.length ) {

			$items.each( function() {

				var $this = $(this),
				$itemsGallery = $this.find('.justified-gallery'),
				rowHeight = $itemsGallery.data('row-height'),
				rowMaxHeight = $itemsGallery.data('max-row-height'),
				margins = $itemsGallery.data('margins');

				// init grid
				wplab_albedo_init_photo_grid( $itemsGallery, rowHeight, rowMaxHeight, margins );

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


			});

		}
	}

	window.albedo_portfolio_justified_photos_grid_init();

})( window.jQuery );
