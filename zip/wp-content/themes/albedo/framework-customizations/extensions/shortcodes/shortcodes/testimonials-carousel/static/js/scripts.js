(function($){

	"use strict";

	// Testimonials shortcode
	$('.shortcode-testimonials').each( function() {

		// vars
		var $elem = $(this),
		id = $elem.attr('id'),
		options = {
			pagination: '#' + id + ' .swiper-pagination',
			prevButton: '#' + id + ' .swiper-button-prev',
			nextButton: '#' + id + ' .swiper-button-next',
			//loopedSlides: 1,
			spaceBetween: 30,
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

		// parallax
		$.extend(options, { parallax: window.themeFrontCore.stringToBoolean( $elem.data('parallax') ) });

		// run the swiper
		setTimeout( function() {
			var swiper = new Swiper('#' + id + ' .swiper-container', options );
		}, 800);
	});

})( window.jQuery );
