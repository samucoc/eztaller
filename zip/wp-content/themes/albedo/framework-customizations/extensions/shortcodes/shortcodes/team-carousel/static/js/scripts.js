(function($){

	"use strict";

	window.albedo_team_carousel_init = function() {

		// Team members Cards / Carousel shortcode
		$('.team-carousel').each( function() {

			// vars
			var $elem = $(this),
			id = $elem.attr('id'),
			options = {
				pagination: '#' + id + ' .swiper-pagination',
				spaceBetween: 0,
				autoHeight: true,
				slidesPerView: 3,
				centeredSlides: true,
				breakpoints: {
					992: {
						slidesPerView: 2
					},
					767: {
						slidesPerView: 1,
						autoHeight: true
					}
				}
			};

			// initial slide
			$.extend(options, { initialSlide: parseInt( $elem.data('init-slide') ) });

			// display pagination
			var pagination = window.themeFrontCore.stringToBoolean( $elem.data('pagination') );
			$.extend(options, { paginationClickable: pagination } );
			if( pagination === false ) {
				$elem.addClass('no-pagination');
			} else {
				$elem.addClass('with-pagination');
			}

			// autoplay
			$.extend(options, { autoplay: $elem.data('autoplay') });
			$.extend(options, { autoplayStopOnLast: window.themeFrontCore.stringToBoolean($elem.data('autoplay-stop-on-last')) });
			$.extend(options, { autoplayDisableOnInteraction: window.themeFrontCore.stringToBoolean($elem.data('autoplay-disable-on-interaction')) });

			// loop
			$.extend(options, { loop: window.themeFrontCore.stringToBoolean( $elem.data('loop') ) });

			// run the swiper
			setTimeout( function() {
				var swiper = new Swiper('#' + id + ' .swiper-container', options );
			}, 800);
		});

	}

	window.albedo_team_carousel_init();

})( window.jQuery );
