(function($){

	"use strict";

	window.albedo_logos_carousel_init = function() {

		$('.logos-carousel.style-carousel').each( function() {

			// vars
			var $elem = $(this),
			id = $elem.attr('id'),
			options = {
				pagination: '#' + id + ' .swiper-pagination',
				spaceBetween: 30,
				autoHeight: false,
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

			// slides num
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

	}

	window.albedo_logos_carousel_init();

})( window.jQuery );
