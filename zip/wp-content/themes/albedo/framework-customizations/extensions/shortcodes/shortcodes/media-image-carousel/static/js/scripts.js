(function($){

	"use strict";

	window.albedo_images_carousel_init = function() {

		$('.shortcode-images-carousel').each( function() {

			// vars
			var $elem = $(this),
			id = $elem.attr('id'),
			options = {
				pagination: '#' + id + ' .swiper-pagination',
				//loopedSlides: 1,
				spaceBetween: 40,
				autoHeight: true,
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
				},
				onInit: function(s) {
					var activeSlideHeight = s.slides.eq(s.activeIndex).find('img').height();
					s.container.css({height: activeSlideHeight+'px'});
				},
				onSlideChangeStart: function (s) {
					var activeSlideHeight = s.slides.eq(s.activeIndex).find('img').height();
					s.container.css({height: activeSlideHeight+'px'});
				}
			};

			// display pagination
			var pagination = window.themeFrontCore.stringToBoolean( $elem.data('pagination') );
			$.extend(options, { paginationClickable: pagination } );
			if( pagination === false ) {
				$elem.addClass('no-pagination');
			}

			// slider effect
			var effect = $elem.data('effect');
			$.extend(options, { effect: effect } );
			$elem.addClass('slider-effect-' + effect );

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
		var $lightboxItems = $('.shortcode-images-carousel');
		if( $lightboxItems.length ) {

			$lightboxItems.lightGallery({
				mode: wplabAlbedoMediaImageCarousel.lightboxEffect,
				cssEasing: 'cubic-bezier(' + wplabAlbedoMediaImageCarousel.lightboxEasing +')',
				download: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaImageCarousel.lightboxDownload ),
				zoom: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaImageCarousel.lightboxZoom ),
				fullScreen: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaImageCarousel.lightboxFullscreen ),
				autoplay: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaImageCarousel.lightboxAutoplay ),
				thumbnail: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaImageCarousel.lightboxThumbs ),
				getCaptionFromTitleOrAlt: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaImageCarousel.lightboxCaptions ),
				progressBar: false,
				autoplayControls: true,
				pause: parseInt( wplabAlbedoMediaImageCarousel.lightboxAutoplaySpeed ),
				selector: 'figure'
			});
		}

	}

	window.albedo_images_carousel_init();

})( window.jQuery );
