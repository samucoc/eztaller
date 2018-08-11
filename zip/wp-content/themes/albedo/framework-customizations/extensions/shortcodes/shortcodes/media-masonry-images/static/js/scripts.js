(function($){

	"use strict";

	window.albedo_masonry_images_init = function() {

		// Masonry grid
		$('.images-masonry-gallery').each( function() {

			var $grid = $(this),
			margins = parseInt( $grid.data('margins') ) / 2,
			gridId = $(this).find('ul.grid').attr('id');

			$grid.find('.grid-item').css('padding', margins + 'px');
			$grid.css('margin-left', - margins + 'px' );
			$grid.css('margin-right', - margins + 'px' );
			$grid.css('margin-top', - margins + 'px' );

			new AnimOnScroll( document.getElementById( gridId ), {
				minDuration : 0.4,
				maxDuration : 0.7,
				viewportFactor : 0.2
			});

		});


		// Open media in LightBox
		var $lightboxItems = $('.images-masonry-gallery');
		if( $lightboxItems.length ) {

			$lightboxItems.lightGallery({
				mode: wplabAlbedoMediaMasonryImages.lightboxEffect,
				cssEasing: 'cubic-bezier(' + wplabAlbedoMediaMasonryImages.lightboxEasing +')',
				download: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaMasonryImages.lightboxDownload ),
				zoom: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaMasonryImages.lightboxZoom ),
				fullScreen: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaMasonryImages.lightboxFullscreen ),
				autoplay: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaMasonryImages.lightboxAutoplay ),
				thumbnail: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaMasonryImages.lightboxThumbs ),
				getCaptionFromTitleOrAlt: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaMasonryImages.lightboxCaptions ),
				progressBar: false,
				autoplayControls: true,
				pause: parseInt( wplabAlbedoMediaMasonryImages.lightboxAutoplaySpeed ),
				selector: 'figure'
			});
		}

	}

	window.albedo_masonry_images_init();

})( window.jQuery );
