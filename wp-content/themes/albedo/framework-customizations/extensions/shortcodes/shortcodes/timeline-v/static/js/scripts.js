(function($){

	"use strict";

	// Vertical timeline shortcode

	function _wplab_albedo_timeline_v_check_mobile( $elem ) {
		if( $(window).width() < 767 ) {
			$elem.find('.col-events').trigger("sticky_kit:detach");
		} else {
			$elem.find('.col-events').stick_in_parent({
				recalc_every: 1,
				offset_top: $elem.find('.col-events').data('scroll-offset')
			});
		}
	}

	window.albedo_timeline_v_init = function() {
		$('.vertical-timeline').each( function() {

			var $elem = $(this),
			$nav = $elem.find('.event'),
			$panels = $elem.find('.item-content');

			if( $elem.hasClass('sticky') ) {

				_wplab_albedo_timeline_v_check_mobile( $elem );

				jQuery( window ).resize(function() {
					_wplab_albedo_timeline_v_check_mobile( $elem );
				});

			}

			$nav.click( function() {
				$nav.removeClass('selected');
				$(this).addClass('selected');
				$(this).prevAll().addClass('date-before');
				$(this).nextAll().removeClass('date-before');
				$panels.find('selected').removeClass('fadeIn').addClass('fadeOut');
				$panels.hide().removeClass('selected').removeClass('wow').removeClass('animated');
				$panels.eq( $(this).index() ).css('display', 'block').css('opacity', '1').addClass('animated');

				$('html, body').animate({
					scrollTop: $elem.offset().top - 100
				}, 800);

			});

		});
	}

	window.albedo_timeline_v_init();

})( window.jQuery );
