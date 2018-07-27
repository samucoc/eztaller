(function($){

	"use strict";

	window.wplab_albedo_svg_icon_init = function() {

		// Open media in LightBox
		var $lightboxItems = $('.media-svg-lightbox');
		if( $lightboxItems.length ) {

			$lightboxItems.lightGallery({
				mode: wplabAlbedoSVGIcon.lightboxEffect,
				cssEasing: 'cubic-bezier(' + wplabAlbedoSVGIcon.lightboxEasing +')',
				download: window.themeFrontCore.stringToBoolean( wplabAlbedoSVGIcon.lightboxDownload ),
				zoom: window.themeFrontCore.stringToBoolean( wplabAlbedoSVGIcon.lightboxZoom ),
				fullScreen: window.themeFrontCore.stringToBoolean( wplabAlbedoSVGIcon.lightboxFullscreen ),
				autoplay: window.themeFrontCore.stringToBoolean( wplabAlbedoSVGIcon.lightboxAutoplay ),
				thumbnail: window.themeFrontCore.stringToBoolean( wplabAlbedoSVGIcon.lightboxThumbs ),
				progressBar: false,
				autoplayControls: true,
				pause: parseInt( wplabAlbedoSVGIcon.lightboxAutoplaySpeed ),
				getCaptionFromTitleOrAlt: window.themeFrontCore.stringToBoolean( wplabAlbedoSVGIcon.lightboxCaptions ),
				selector: 'this'
			});
		}

	}

	window.wplab_albedo_svg_icon_init();

})( window.jQuery );
