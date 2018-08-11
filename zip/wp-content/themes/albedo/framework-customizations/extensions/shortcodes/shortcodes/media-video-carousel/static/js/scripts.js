(function($){

	"use strict";

	window.wplab_albedo_videos_carousel_init = function() {

		$('.shortcode-videos-carousel').each( function() {

			// vars
			var $elem = $(this),
			id = $elem.attr('id'),
			options = {
				prevButton: '#' + id + ' .swiper-button-prev',
				nextButton: '#' + id + ' .swiper-button-next',
				centeredSlides: true,
				effect: 'coverflow',
				slidesPerView: 2,
				initialSlide: $elem.data('init-slide'),
				touchEventsTarget: 'wrapper',
				onClick: function( swiper, ev ) {
					$elem.find('.swiper-slide-active .img-shortcode-wrapper').click();
					return false;
				},
				coverflow: {
					rotate: 50,
					stretch: 0,
					depth: 300,
					modifier: 1,
					slideShadows : false
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

			// run the swiper
			setTimeout( function() {
				var swiper = new Swiper('#' + id + ' .swiper-container', options );
			}, 800);
		});

		// Open media in LightBox
		var $lightboxItems = $('.shortcode-videos-carousel');
		if( $lightboxItems.length ) {

			$lightboxItems.lightGallery({
				mode: wplabAlbedoMediaVideoCarousel.lightboxEffect,
				cssEasing: 'cubic-bezier(' + wplabAlbedoMediaVideoCarousel.lightboxEasing +')',
				download: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaVideoCarousel.lightboxDownload ),
				zoom: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaVideoCarousel.lightboxZoom ),
				fullScreen: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaVideoCarousel.lightboxFullscreen ),
				autoplay: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaVideoCarousel.lightboxAutoplay ),
				thumbnail: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaVideoCarousel.lightboxThumbs ),
				getCaptionFromTitleOrAlt: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaVideoCarousel.lightboxCaptions ),
				progressBar: false,
				autoplayControls: true,
				pause: parseInt( wplabAlbedoMediaVideoCarousel.lightboxAutoplaySpeed ),
				selector: 'figure'
			});
		}

	}

	window.wplab_albedo_videos_carousel_init();

})( window.jQuery );
