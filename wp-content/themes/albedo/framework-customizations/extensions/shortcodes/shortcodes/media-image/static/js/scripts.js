(function($){

	"use strict";

	window.wplab_albedo_image_init = function() {

		// Open media in LightBox
		var $items = $('.img-shortcode-wrapper[data-src]');
		if( $items.length ) {

			$items.lightGallery({
				mode: wplabAlbedoMediaImage.lightboxEffect,
				cssEasing: 'cubic-bezier(' + wplabAlbedoMediaImage.lightboxEasing +')',
				selector: 'this',
				download: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaImage.lightboxDownload ),
				zoom: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaImage.lightboxZoom ),
				fullScreen: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaImage.lightboxFullscreen ),
				autoplay: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaImage.lightboxAutoplay ),
				thumbnail: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaImage.lightboxThumbs ),
				getCaptionFromTitleOrAlt: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaImage.lightboxCaptions ),
				pause: wplabAlbedoMediaImage.lightboxAutoplaySpeed
			});
		}

	}

	window.wplab_albedo_image_init();

})( window.jQuery );
