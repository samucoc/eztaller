(function($){

	"use strict";

	window.wplab_albedo_mouse_parallax = function() {

		$('.parallax-js-section').find('.parallax-scene').each( function() {
			$(this).parallax({
				invertX: false,
				invertY: false
			});
		});

	}

	window.wplab_albedo_mouse_parallax();

})( window.jQuery );
