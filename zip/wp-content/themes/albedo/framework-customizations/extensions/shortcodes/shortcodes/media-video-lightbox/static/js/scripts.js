(function($){

	"use strict";

	window.albedo_video_lightbox_init = function() {

		// Open media in LightBox
		var $items = $('.video-shortcode-wrapper');
		if( $items.length ) {

			$items.lightGallery({
				mode: wplabAlbedoVideoLightbox.lightboxEffect,
				cssEasing: 'cubic-bezier(' + wplabAlbedoVideoLightbox.lightboxEasing +')',
				selector: 'this',
				download: wplabAlbedoVideoLightbox.lightboxDownload,
				zoom: wplabAlbedoVideoLightbox.lightboxZoom,
				fullScreen: wplabAlbedoVideoLightbox.lightboxFullscreen,
				thumbnail: wplabAlbedoVideoLightbox.lightboxThumbs,
				speed: wplabAlbedoVideoLightbox.lightboxSpeed,
				autoplay: wplabAlbedoVideoLightbox.lightboxAutoplay,
				pause: wplabAlbedoVideoLightbox.lightboxAutoplaySpeed,
				getCaptionFromTitleOrAlt: window.themeFrontCore.stringToBoolean( wplabAlbedoVideoLightbox.lightboxCaptions )
			});
		}

	}

	window.albedo_video_lightbox_init();

})( window.jQuery );
