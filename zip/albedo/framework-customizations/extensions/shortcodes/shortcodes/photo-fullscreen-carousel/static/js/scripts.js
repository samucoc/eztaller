(function($){

	"use strict";

	window.albedo_portfolio_full_screen_photos_carousel_init = function() {

		$('.photo-fullscreen-carousel').each( function() {

			// vars
			var $elem = $(this),
			id = $elem.attr('id'),
			options = {
				pagination: '#' + id + ' .swiper-pagination',
				//loopedSlides: 1,
				spaceBetween: 100,
				autoHeight: true,
				centeredSlides: true,
				coverflow: {
					slideShadows: false
				},
				flip: {
					slideShadows: false
				},
				cube: {
					slideShadows: false,
					shadow: false
				},
				fade: {
					crossFade: true
				}
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

			// loop
			$.extend(options, { loop: window.themeFrontCore.stringToBoolean( $elem.data('loop') ) });

			$.extend(options, {
				slidesPerView: $elem.data('slides-num'),
				autoHeight: false,
				breakpoints: {
					992: {
						slidesPerView: $elem.data('slides-medium-num')
					},
					767: {
						slidesPerView: $elem.data('slides-small-num'),
						autoHeight: true
					}
				}
			});

			// run the swiper
			setTimeout( function() {
				var swiper = new Swiper('#' + id + ' .swiper-container', options );
			}, 800);
		});

		// Open media in LightBox
		var $lightboxItems = $('.photo-fullscreen-carousel');
		if( $lightboxItems.length ) {

			$lightboxItems.lightGallery({
				mode: wplabAlbedoFullScreenPhotoCarousel.lightboxEffect,
				cssEasing: 'cubic-bezier(' + wplabAlbedoFullScreenPhotoCarousel.lightboxEasing +')',
				download: window.themeFrontCore.stringToBoolean( wplabAlbedoFullScreenPhotoCarousel.lightboxDownload ),
				zoom: window.themeFrontCore.stringToBoolean( wplabAlbedoFullScreenPhotoCarousel.lightboxZoom ),
				fullScreen: window.themeFrontCore.stringToBoolean( wplabAlbedoFullScreenPhotoCarousel.lightboxFullscreen ),
				autoplay: window.themeFrontCore.stringToBoolean( wplabAlbedoFullScreenPhotoCarousel.lightboxAutoplay ),
				thumbnail: window.themeFrontCore.stringToBoolean( wplabAlbedoFullScreenPhotoCarousel.lightboxThumbs ),
				getCaptionFromTitleOrAlt: window.themeFrontCore.stringToBoolean( wplabAlbedoFullScreenPhotoCarousel.lightboxCaptions ),
				progressBar: false,
				autoplayControls: true,
				pause: parseInt( wplabAlbedoFullScreenPhotoCarousel.lightboxAutoplaySpeed ),
				selector: 'figure'
			});
		}

	}

	window.albedo_portfolio_full_screen_photos_carousel_init();

})( window.jQuery );
