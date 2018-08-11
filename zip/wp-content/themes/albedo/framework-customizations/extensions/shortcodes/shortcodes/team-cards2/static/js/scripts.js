(function($){

	"use strict";

	// Team members Cards / Carousel shortcode

	window.albedo_team_cards2_init = function() {
		$('.team-cards2').each( function() {

			// vars
			var $elem = $(this),
			id = $elem.attr('id'),
			options = {
				pagination: '#' + id + ' .swiper-pagination',
				spaceBetween: 30,
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

			// initial slide
			var initSlide = parseInt( $elem.data('start-slide') );
			$.extend(options, { initialSlide: initSlide });
			if( parseInt( $elem.data('slides-num') ) != 3 ) {
				$.extend(options, { centeredSlides: false });
				$elem.addClass('not-centered');
			}

			// display pagination
			var pagination = window.themeFrontCore.stringToBoolean( $elem.data('pagination') );
			$.extend(options, { paginationClickable: pagination } );
			if( pagination === false ) {
				$elem.addClass('no-pagination');
			} else {
				$elem.addClass('with-pagination');
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
	}

	window.albedo_team_cards2_init();

})( window.jQuery );
