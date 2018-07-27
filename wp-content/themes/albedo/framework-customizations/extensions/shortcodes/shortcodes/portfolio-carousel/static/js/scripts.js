(function($){

	"use strict";

	window.wplab_albedo_portfolio_carousel_init = function() {
		$('.shortcode-portfolio-carousel').each( function() {

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
			var initSlide = parseInt( $elem.data('initial-slide') );
			$.extend(options, { initialSlide: initSlide });
			if( initSlide != 3 ) {
				$.extend(options, { centeredSlides: false });
				$elem.addClass('not-centered');
			}

			// run the swiper
			setTimeout( function() {
				var swiper = new Swiper('#' + id + ' .swiper-container', options );
			}, 800);
		});

		// Open media in LightBox
		var $lightboxItems = $('.shortcode-portfolio-carousel');
		if( $lightboxItems.length ) {

			$lightboxItems.lightGallery({
				mode: wplabAlbedoPortfolioCarousel.lightboxEffect,
				cssEasing: 'cubic-bezier(' + wplabAlbedoPortfolioCarousel.lightboxEasing +')',
				download: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioCarousel.lightboxDownload ),
				zoom: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioCarousel.lightboxZoom ),
				fullScreen: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioCarousel.lightboxFullscreen ),
				autoplay: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioCarousel.lightboxAutoplay ),
				thumbnail: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioCarousel.lightboxThumbs ),
				getCaptionFromTitleOrAlt: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioCarousel.lightboxCaptions ),
				progressBar: false,
				autoplayControls: true,
				pause: parseInt( wplabAlbedoPortfolioCarousel.lightboxAutoplaySpeed ),
				selector: 'figure'
			});
		}
	}

	window.wplab_albedo_portfolio_carousel_init();

})( window.jQuery );
