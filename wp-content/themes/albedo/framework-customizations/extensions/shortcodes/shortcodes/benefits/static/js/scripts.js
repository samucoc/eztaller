(function($){

	"use strict";

	window.albedo_benefits_init = function() {

		// Benefits shortcode
		$('.shortcode-benefits .item, .shortcode-benefits-modern .item').hover( function() {
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

	window.albedo_benefits_init();

})( window.jQuery );
