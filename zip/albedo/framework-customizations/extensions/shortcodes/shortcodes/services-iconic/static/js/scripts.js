(function($){

	"use strict";

	window.albedo_services_iconic_init = function() {
		// Iconic services shortcode
		$('.shortcode-services-iconic .item').hover( function() {
			var $icon = $(this).find('.animate-on-hover'),
			animationClass = $icon.data('hover-animation');

			$icon.removeClass('animated').removeClass( animationClass );
			$icon.filter(':not(:animated)').addClass( animationClass + ' animated' );

		}, function() {
			var $icon = $(this).find('.animate-on-hover'),
			animationClass = $icon.data('hover-animation');

			$icon.off('webkitAnimationEnd oanimationend oAnimationEnd msAnimationEnd animationend').on('webkitAnimationEnd oanimationend oAnimationEnd msAnimationEnd animationend', function() {
				$icon.removeClass( animationClass ).removeClass('animated');
			});

		});
	}

	window.albedo_services_iconic_init();

})( window.jQuery );
