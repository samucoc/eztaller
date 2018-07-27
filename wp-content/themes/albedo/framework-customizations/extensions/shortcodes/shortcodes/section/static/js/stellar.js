(function($){

	"use strict";

	window.wplab_albedo_is_mobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
		BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
		iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
		Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
		Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
		any: function() {
			return (window.wplab_albedo_is_mobile.Android() || window.wplab_albedo_is_mobile.BlackBerry() || window.wplab_albedo_is_mobile.iOS() || window.wplab_albedo_is_mobile.Opera() || window.wplab_albedo_is_mobile.Windows());
		}
	};

	window.wplab_albedo_simple_parallax = function() {

		if( $('.parallax-section, .video-parallax').length ) {
			$.stellar({
				horizontalScrolling: false,
				responsive: true
			});
		}

	}

	$('body').waitForImages({
		waitForAll: true,
		finished: function() {

			// parallax effect
			if( !window.wplab_albedo_is_mobile.any() ){
				window.wplab_albedo_simple_parallax();
			} else {
				$('.parallax-section').each( function() {
					var $elem = $(this);
					$elem.css('background-image', 'url("' + $elem.data('lazy-src')  + '")').css('background-attachment', 'scroll');
				});
			}

		}
	});

})( window.jQuery );
