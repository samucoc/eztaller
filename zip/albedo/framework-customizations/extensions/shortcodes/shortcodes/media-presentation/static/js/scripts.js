(function($){

	"use strict";

	function _wplab_albedo_presentation_resize() {

		$('.shortcode-presentation').each( function() {

			var $elem = $(this);
			$elem.find('.swiper-slide, .row').height('auto');
			var maxHeight = Math.max.apply(null, $elem.find('.swiper-slide').map(function () {
				return $(this).outerHeight();
			}).get());

			$elem.find('.swiper-slide').height( maxHeight );
			$elem.find('.row').height( maxHeight );
			$elem.height( maxHeight ).css('overflow-y', 'hidden');

		});

	}

	window.albedo_presentation_slider_init = function() {

		// Presentation shortcode
		$('.shortcode-presentation').each( function() {

			// vars
			var $elem = $(this),
			id = $elem.attr('id'),
			options = {
				pagination: '#' + id + ' .swiper-pagination',
				direction: 'vertical',
				slidesPerView: 1,
				autoHeight: true
			};

			// display pagination
			var pagination = window.themeFrontCore.stringToBoolean( $elem.data('pagination') );
			$.extend(options, { paginationClickable: pagination } );
			if( pagination === false ) {
				$elem.addClass('no-pagination');
			}

			// mouse control
			$.extend(options, {mousewheelControl: window.themeFrontCore.stringToBoolean($elem.data('mousewheel'))});

			// autoplay
			$.extend(options, { autoplay: $elem.data('autoplay') });
			$.extend(options, { autoplayStopOnLast: window.themeFrontCore.stringToBoolean($elem.data('autoplay-stop-on-last')) });
			$.extend(options, { autoplayDisableOnInteraction: window.themeFrontCore.stringToBoolean($elem.data('autoplay-disable-on-interaction')) });

			// loop
			$.extend(options, { loop: window.themeFrontCore.stringToBoolean( $elem.data('loop') ) });

			_wplab_albedo_presentation_resize();
			new Swiper('#' + id + ' .swiper-container', options );

		});

		$(window).resize( function() {
			_wplab_albedo_presentation_resize();
		});

		// Open media in LightBox
		var $lightboxItems = $('.shortcode-presentation a.media-svg-lightbox');
		if( $lightboxItems.length ) {

			$lightboxItems.lightGallery({
				mode: wplabAlbedoMediaPresentation.lightboxEffect,
				cssEasing: 'cubic-bezier(' + wplabAlbedoMediaPresentation.lightboxEasing +')',
				download: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaPresentation.lightboxDownload ),
				zoom: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaPresentation.lightboxZoom ),
				fullScreen: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaPresentation.lightboxFullscreen ),
				autoplay: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaPresentation.lightboxAutoplay ),
				thumbnail: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaPresentation.lightboxThumbs ),
				getCaptionFromTitleOrAlt: window.themeFrontCore.stringToBoolean( wplabAlbedoMediaPresentation.lightboxCaptions ),
				progressBar: false,
				autoplayControls: true,
				pause: parseInt( wplabAlbedoMediaPresentation.lightboxAutoplaySpeed ),
				selector: 'this'
			});
		}

	}

	window.albedo_presentation_slider_init();

})( window.jQuery );
