(function($){

	"use strict";


	window.wplab_albedo_images_gallery_init = function() {

		// Justified Gallery Grid

		var $items = $('.justified-gallery');

		if( $items.length ) {

			$items.each( function() {

				var $item = $(this);

				$item.justifiedGallery({
					rowHeight: parseInt( $item.data('row-height') ),
					maxRowHeight: parseInt( $item.data('max-row-height') ),
					lastRow: 'nojustify',
					margins: parseInt( $item.data('margins') ),
					border: 0,
					captions: window.themeFrontCore.stringToBoolean( $item.data('captions') ),
					randomize: window.themeFrontCore.stringToBoolean( $item.data('randomize') ),
					cssAnimation: true,
					selector: 'figure, div:not(.spinner)',
					captionSettings: {
						animationDuration: 500,
						visibleOpacity: 0.7,
						nonVisibleOpacity: 0.0
					}
				});

			});

			// Open media in LightBox
			var $lightboxItems = $('.justified-gallery');
			if( $lightboxItems.length ) {

				$lightboxItems.lightGallery({
					mode: wplabAlbedoImageGallery.lightboxEffect,
					cssEasing: 'cubic-bezier(' + wplabAlbedoImageGallery.lightboxEasing +')',
					download: window.themeFrontCore.stringToBoolean( wplabAlbedoImageGallery.lightboxDownload ),
					zoom: window.themeFrontCore.stringToBoolean( wplabAlbedoImageGallery.lightboxZoom ),
					fullScreen: window.themeFrontCore.stringToBoolean( wplabAlbedoImageGallery.lightboxFullscreen ),
					autoplay: window.themeFrontCore.stringToBoolean( wplabAlbedoImageGallery.lightboxAutoplay ),
					thumbnail: window.themeFrontCore.stringToBoolean( wplabAlbedoImageGallery.lightboxThumbs ),
					getCaptionFromTitleOrAlt: window.themeFrontCore.stringToBoolean( wplabAlbedoImageGallery.lightboxCaptions ),
					progressBar: false,
					autoplayControls: true,
					pause: parseInt( wplabAlbedoImageGallery.lightboxAutoplaySpeed ),
					selector: 'figure'
				});
			}

		}



	}

	window.wplab_albedo_images_gallery_init();

})( window.jQuery );
