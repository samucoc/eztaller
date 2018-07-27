(function($){

	"use strict";

	window.albedo_testimonials_init = function() {

		// Testimonials shortcode
		$('.shortcode-testimonials, .shortcode-testimonials-carousel, .shortcode-testimonials-carousel2, .shortcode-testimonials-carousel3, .shortcode-testimonials-magazine').each( function() {

			// vars
			var $elem = $(this),
			id = $elem.attr('id'),
			thumbsId = $elem.data('thumbs-id'),
			hasThumbsPagination = $elem.hasClass('thumbs-pagination'),
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
				},
				onInit: function( swiper ) {
					var nextText = $elem.find('.swiper-slide-next .author').text();
					$elem.find('.swiper-button-next .name').text( nextText );

					var prevText = $elem.find('.swiper-slide-prev .author').text();
					$elem.find('.swiper-button-prev .name').text( prevText );

					if( hasThumbsPagination ) {
						var currThumb = $elem.find('.swiper-slide-active').data('img-url'),
						prevThumb = $elem.find('.swiper-slide-prev').data('img-url'),
						nextThumb = $elem.find('.swiper-slide-next').data('img-url');

						if( currThumb !== undefined ) {
							$('#' + thumbsId + ' .current-slide-thumb' ).css('background-image', 'url(' + currThumb + ')');
						} else {
							$('#' + thumbsId + ' .current-slide-thumb' ).css('opacity', '0' );
						}

						if( prevThumb !== undefined ) {
							$('#' + thumbsId + ' .prev-slide-thumb' ).css('background-image', 'url(' + prevThumb + ')').css('opacity', '0.3' );
						} else {
							$('#' + thumbsId + ' .prev-slide-thumb' ).css('opacity', '0' );
						}

						if( nextThumb !== undefined ) {
							$('#' + thumbsId + ' .next-slide-thumb' ).css('background-image', 'url(' + nextThumb + ')').css('opacity', '0.3' );
						} else {
							$('#' + thumbsId + ' .next-slide-thumb' ).css('opacity', '0' );
						}

					}
				},
				onTransitionEnd: function( swiper ) {
					var nextText = $elem.find('.swiper-slide-next .author').text();
					$elem.find('.swiper-button-next .name').text( nextText );

					var prevText = $elem.find('.swiper-slide-prev .author').text();
					$elem.find('.swiper-button-prev .name').text( prevText );

					if( hasThumbsPagination ) {
						var currThumb = $elem.find('.swiper-slide-active').data('img-url'),
						prevThumb = $elem.find('.swiper-slide-prev').data('img-url'),
						nextThumb = $elem.find('.swiper-slide-next').data('img-url');

						var $currThumb = $('#' + thumbsId + ' .current-slide-thumb' ),
						currThumbEffect = $('#' + thumbsId ).data('effect');

						$currThumb.removeClass('animated').removeClass( currThumbEffect );

						if( currThumb !== undefined ) {
							$currThumb.addClass( currThumbEffect ).addClass('animated').css('background-image', 'url(' + currThumb + ')');
						} else {
							$('#' + thumbsId + ' .current-slide-thumb' ).css('opacity', '0' );
						}

						$currThumb.off('webkitAnimationEnd oanimationend oAnimationEnd msAnimationEnd animationend').on('webkitAnimationEnd oanimationend oAnimationEnd msAnimationEnd animationend', function() {
							$currThumb.removeClass('animated').removeClass( currThumbEffect );
						});

						if( prevThumb !== undefined ) {
							$('#' + thumbsId + ' .prev-slide-thumb' ).css('background-image', 'url(' + prevThumb + ')').css('opacity', '0.3' );
						} else {
							$('#' + thumbsId + ' .prev-slide-thumb' ).css('opacity', '0' );
						}

						if( nextThumb !== undefined ) {
							$('#' + thumbsId + ' .next-slide-thumb' ).css('background-image', 'url(' + nextThumb + ')').css('opacity', '0.3' );
						} else {
							$('#' + thumbsId + ' .next-slide-thumb' ).css('opacity', '0' );
						}
					}
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

			// slides per view
			if( $elem.hasClass('shortcode-testimonials-carousel2') ) {
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
			}

			// run the swiper
			setTimeout( function() {
				var swiperGallery = new Swiper('#' + id + ' .swiper-container', options );

				if( hasThumbsPagination ) {
					$('#' + thumbsId + ' a' ).click( function() {

						var $elem = $(this);

						if( $elem.is(':visible') ) {

							if( $elem.hasClass('prev-slide-thumb')) {
								swiperGallery.slidePrev();
							} else if( $elem.hasClass('next-slide-thumb')) {
								swiperGallery.slideNext();
							}

						}

						return false;

					});
				}

			}, 800);
		});

	}

	window.albedo_testimonials_init();

})( window.jQuery );
