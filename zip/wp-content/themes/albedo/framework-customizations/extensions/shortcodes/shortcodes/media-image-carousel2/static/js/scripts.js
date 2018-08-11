(function($){

	"use strict";

	window.albedo_images_carousel2_init = function() {

		$('.shortcode-images-carousel2').each( function() {

			// vars
			var $elem = $(this),
			id = $elem.attr('id'),
			options = {
				pagination: '#' + id + ' .swiper-pagination',
				//loopedSlides: 1,
				spaceBetween: 30,
				autoHeight: true,
				centeredSlides: true,
				slidesPerView: 2
			};

			// display pagination
			var pagination = window.themeFrontCore.stringToBoolean( $elem.data('pagination') );
			$.extend(options, { paginationClickable: pagination } );
			if( pagination === false ) {
				$elem.addClass('no-pagination');
			}

			// autoplay
			$.extend(options, { autoplay: $elem.data('autoplay') });
			$.extend(options, { autoplayStopOnLast: window.themeFrontCore.stringToBoolean($elem.data('autoplay-stop-on-last')) });
			$.extend(options, { autoplayDisableOnInteraction: window.themeFrontCore.stringToBoolean($elem.data('autoplay-disable-on-interaction')) });

			// initial slide
			$.extend(options, { initialSlide: $elem.data('initial-slide') });

			// run the swiper
			setTimeout( function() {
				var swiper = new Swiper('#' + id + ' .swiper-container', options );
			}, 800);
		});

		// Open media in LightBox
		var $lightboxItems = $('.shortcode-images-carousel2');
		if( $lightboxItems.length ) {

			$lightboxItems.lightGallery({
				mode: wplabAlbedoMediaImageCarousel2.lightboxEffect,
				cssEasing: 'cubic-bezier(' + wplabAlbedoMediaImageCarousel2.lightboxEasing +')',
				download: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaImageCarousel2.lightboxDownload ),
				zoom: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaImageCarousel2.lightboxZoom ),
				fullScreen: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaImageCarousel2.lightboxFullscreen ),
				autoplay: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaImageCarousel2.lightboxAutoplay ),
				thumbnail: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaImageCarousel2.lightboxThumbs ),
				getCaptionFromTitleOrAlt: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaImageCarousel2.lightboxCaptions ),
				progressBar: false,
				autoplayControls: true,
				pause: parseInt( wplabAlbedoMediaImageCarousel2.lightboxAutoplaySpeed ),
				selector: 'figure'
			});
		}

	}

	window.albedo_images_carousel2_init();

})( window.jQuery );
