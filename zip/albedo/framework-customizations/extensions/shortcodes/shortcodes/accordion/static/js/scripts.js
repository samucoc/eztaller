(function($){

	"use strict";

	window.wplab_albedo_accordion = function() {
		// Accordion shortcode
		$('.theme-accordion').each( function() {

			var $elem = $(this);

			$elem.find('.toggle-content').hide();
			$elem.find('.toggle-content:first').show();
			$elem.find('.item:first').addClass('open');

			$elem.find('.toggle-header').on('click', function() {
				$elem.find('.item').removeClass('open');
				$(this).parents('.item').addClass('open');
				$elem.find('.toggle-content').hide();
				var $content = $(this).next('.toggle-content');
				if( $content.is(':visible') == false ) {
					$content.slideDown();
				}

			});

		});
	}

	window.wplab_albedo_accordion();

})( window.jQuery );
