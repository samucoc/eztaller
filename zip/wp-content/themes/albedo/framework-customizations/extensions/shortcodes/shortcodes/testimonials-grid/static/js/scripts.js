(function($){

	"use strict";

	window.albedo_testimonials_grid_init = function() {

		// Testimonials Grid shortcode
		$('.shortcode-testimonials-grid').each( function() {

			var elem = $(this),
			gridId = $(this).find('ul.grid').attr('id');

			new AnimOnScroll( document.getElementById( gridId ), {
				minDuration : 0.4,
				maxDuration : 0.7,
				viewportFactor : 0.2
			});

		});

		$('.shortcode-testimonials-grid .item-content').hover( function() {
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

	window.albedo_testimonials_grid_init();

})( window.jQuery );
