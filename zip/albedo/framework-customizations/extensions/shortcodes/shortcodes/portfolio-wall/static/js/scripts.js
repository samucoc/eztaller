(function($){

	"use strict";

	window.albedo_portfolio_wall_init = function() {
		$('.portfolio-wall-shortcode').each( function() {

			var $shortcode = $(this);

			if( $shortcode.hasClass('lightbox-yes') ) {
				$shortcode.find('.lightbox-link').lightGallery({
					mode: wplabAlbedoPortfolioWall.lightboxEffect,
					cssEasing: 'cubic-bezier(' + wplabAlbedoPortfolioWall.lightboxEasing +')',
					download: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioWall.lightboxDownload ),
					zoom: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioWall.lightboxZoom ),
					fullScreen: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioWall.lightboxFullscreen ),
					autoplay: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioWall.lightboxAutoplay ),
					thumbnail: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioWall.lightboxThumbs ),
					getCaptionFromTitleOrAlt: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioWall.lightboxCaptions ),
					progressBar: false,
					autoplayControls: true,
					pause: parseInt( wplabAlbedoPortfolioWall.lightboxAutoplaySpeed ),
					selector: 'this'
				});
			}

		});
	}

	window.albedo_portfolio_wall_init();

})( window.jQuery );
