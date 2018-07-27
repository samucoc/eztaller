(function($){

	"use strict";

  // Open media in LightBox
	var $lightboxItems = $('.lightbox-images');
	if( $lightboxItems.length ) {

		$lightboxItems.lightGallery({
			mode: wplabAlbedoLightboxSingle.lightboxEffect,
			cssEasing: 'cubic-bezier(' + wplabAlbedoLightboxSingle.lightboxEasing +')',
			download: window.themeFrontCore.stringToBoolean( wplabAlbedoLightboxSingle.lightboxDownload ),
			zoom: window.themeFrontCore.stringToBoolean( wplabAlbedoLightboxSingle.lightboxZoom ),
			fullScreen: window.themeFrontCore.stringToBoolean( wplabAlbedoLightboxSingle.lightboxFullscreen ),
			autoplay: window.themeFrontCore.stringToBoolean( wplabAlbedoLightboxSingle.lightboxAutoplay ),
			thumbnail: window.themeFrontCore.stringToBoolean( wplabAlbedoLightboxSingle.lightboxThumbs ),
			getCaptionFromTitleOrAlt: window.themeFrontCore.stringToBoolean( wplabAlbedoLightboxSingle.lightboxCaptions ),
			progressBar: false,
			autoplayControls: true,
			pause: parseInt( wplabAlbedoLightboxSingle.lightboxAutoplaySpeed ),
			selector: 'figure'
		});
	}

})( window.jQuery );
