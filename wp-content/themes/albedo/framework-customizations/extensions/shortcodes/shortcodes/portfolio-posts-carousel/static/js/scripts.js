(function($){

	"use strict";

	window.wplab_albedo_portfolio_posts_carousel_init = function() {
		$('.shortcode-portfolio-posts-carousel').each( function() {

			// vars
			var $elem = $(this),
			id = $elem.attr('id'),
			options = {
				nextButton: '#' + id + ' .swiper-button-next',
				prevButton: '#' + id + ' .swiper-button-prev',
				spaceBetween: 30,
				centeredSlides: true
			};

			// responsive
			$.extend(options, {
				slidesPerView: $elem.data('slides'),
				autoHeight: true,
				breakpoints: {
					992: {
						slidesPerView: 2,
						//centeredSlides: false,
						autoHeight: true
					},
					767: {
						slidesPerView: $elem.data('slides-small'),
						//centeredSlides: false,
						autoHeight: true
					}
				}
			});

			// display pagination
			var pagination = window.themeFrontCore.stringToBoolean( $elem.data('pagination') );
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
			if( parseInt( $elem.data('slides') ) != 3 ) {
				$.extend(options, { centeredSlides: false });
				$elem.addClass('not-centered');
			}

			// run the swiper
			setTimeout( function() {
				var swiper = new Swiper('#' + id + ' .swiper-container', options );
			}, 800);

			if( $elem.hasClass('with-lightbox') ) {
				$elem.find('.lightbox-link').lightGallery({
					mode: wplabAlbedoPortfolioPostsCarousel.lightboxEffect,
					cssEasing: 'cubic-bezier(' + wplabAlbedoPortfolioPostsCarousel.lightboxEasing +')',
					download: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioPostsCarousel.lightboxDownload ),
					zoom: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioPostsCarousel.lightboxZoom ),
					fullScreen: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioPostsCarousel.lightboxFullscreen ),
					autoplay: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioPostsCarousel.lightboxAutoplay ),
					thumbnail: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioPostsCarousel.lightboxThumbs ),
					getCaptionFromTitleOrAlt: window.themeFrontCore.stringToBoolean( wplabAlbedoPortfolioPostsCarousel.lightboxCaptions ),
					progressBar: false,
					autoplayControls: true,
					pause: parseInt( wplabAlbedoPortfolioPostsCarousel.lightboxAutoplaySpeed ),
					selector: 'this'
				});
			}

		});
	}

	window.wplab_albedo_portfolio_posts_carousel_init();

})( window.jQuery );
