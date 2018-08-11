(function($){

	"use strict";

	window.wplab_albedo_portfolio_featured_carousel_init = function() {
		$('.shortcode-portfolio-featured-carousel').each( function() {

			// vars
			var $elem = $(this),
			id = $elem.attr('id'),
			options = {
				pagination: '#' + id + ' .swiper-pagination',
				spaceBetween: 60,
				slidesPerView: 1,
				autoHeight: true,
				effect: 'fade'
			};

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
	}

	window.wplab_albedo_portfolio_featured_carousel_init();

})( window.jQuery );
