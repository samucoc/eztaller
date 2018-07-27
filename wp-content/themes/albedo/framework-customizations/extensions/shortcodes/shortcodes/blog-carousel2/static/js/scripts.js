(function($){

	"use strict";

	function wplab_albedo_blog_posts_carousel2_auto_height( $elem ) {
		var heights = $elem.find('.swiper-slide-prev, .swiper-slide-next, .swiper-slide-active').map(function () {
			return $(this).height();
		}).get(),

		maxHeight = Math.max.apply(null, heights);

		$elem.find('.swiper-wrapper').height( maxHeight );
	}

	window.albedo_blog_carousel2_init = function() {
		$('.shortcode-blog-carousel2').each( function() {

			// vars
			var $elem = $(this),
			id = $elem.attr('id'),
			options = {
				prevButton: '#' + id + ' .swiper-button-prev',
				nextButton: '#' + id + ' .swiper-button-next',
				spaceBetween: 30,
				onSlideChangeStart: function() {

					wplab_albedo_blog_posts_carousel2_auto_height( $elem );

				},
				onTransitionEnd: function() {

					wplab_albedo_blog_posts_carousel2_auto_height( $elem );

				}
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
			var pagination = window.themeFrontCore.stringToBoolean( $elem.data( 'pagination') );
			if( pagination === false ) {
				$elem.addClass( 'no-pagination');
			}

			// autoplay
			$.extend(options, { autoplay: $elem.data( 'autoplay') });
			$.extend(options, { autoplayStopOnLast: window.themeFrontCore.stringToBoolean( $elem.data( 'autoplay-stop-on-last')) });
			$.extend(options, { autoplayDisableOnInteraction: window.themeFrontCore.stringToBoolean( $elem.data( 'autoplay-disable-on-interaction')) });

			// initial slide
			$.extend(options, { initialSlide: $elem.data('initial-slide') });

			// run the swiper
			setTimeout( function() {
				var swiper = new Swiper('#' + id + ' .swiper-container', options );
			}, 800);

		});
	}

	window.albedo_blog_carousel2_init();

})( window.jQuery );
