(function($){

	"use strict";

	function _wplab_albedo_benefits2_check_mobile( $elem ) {

		if( $(window).width() < 992 ) {
			$elem.trigger("sticky_kit:detach");
			$elem.parent('.col-nav').height('auto');
		} else {
			$elem.parent('.col-nav').height( $elem.parent().parent().find('ul.grid').outerHeight() );
			$elem.stick_in_parent({
				offset_top: parseInt( $elem.data('top-offset') ),
				spacer: false
			});
		}

	}

	window.albedo_benefits_v2_init = function() {
		// Benefits shortcode
		$('.shortcode-benefits-v2 .item').hover( function() {
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

		$('.shortcode-benefits-v2').each( function() {

			var $elem = $(this),
			gridId = $(this).find('ul.grid').attr('id');

			new AnimOnScroll( document.getElementById( gridId ), {
				minDuration : 0.4,
				maxDuration : 0.7,
				viewportFactor : 0.2
			});

			$elem.find('nav a:first').addClass('current');

			$elem.find('.shortcode-benefits-v2-filters a').click( function() {
				var $a = $(this);
				$elem.find('a').removeClass('current');
				$a.addClass('current');

				$elem.find('.grid-item').addClass('shown').removeClass('animate');

				var $isotope = $('#' + gridId ).isotope({
					itemSelector: "li",
					transitionDuration: 0
				});

				$isotope.off('layoutComplete').on( 'layoutComplete', function() {

					$elem.find( '.grid-item' + $a.data('term') ).css('opacity', '0').each( function() {

						var $i = $(this);

						$("body").queue(function(next) {
							$i.addClass('animate');
							next();
						}).delay(10);

					});

				});

				$isotope.isotope('shuffle').isotope({ filter: $a.data('term') });

				_wplab_albedo_benefits2_check_mobile( $elem.find('.col-nav nav') );
				$(document.body).trigger("sticky_kit:recalc");


			});

			setTimeout( function() {

				if( $elem.hasClass('sticky-nav') ) {

					_wplab_albedo_benefits2_check_mobile( $elem.find('.col-nav nav') );

					jQuery( window ).resize(function() {
						_wplab_albedo_benefits2_check_mobile( $elem.find('.col-nav nav') );
					});

				}

			}, 1500);

		});
	}

	window.albedo_benefits_v2_init();

})( window.jQuery );
