(function($){

	"use strict";

	window.albedo_tabs_init = function() {
		$('.theme-tabs').each( function() {

			var $elem = $(this);

			$elem.find('.tab_content').hide();
			$elem.find('.tab_content:first').show();
			$elem.find('.nav-desktop a.a-tab-desktop:first, .tab_content:first').addClass('open');

			$elem.find('.nav-desktop a.a-tab-desktop').off('click').on('click', function() {

				var tabNum = $(this).data('item');
				$elem.find('.nav-desktop a.a-tab-desktop, .tab_content').removeClass('open');
				$(this).addClass('open');

				$elem.find('.nav-mobile select').val( tabNum ).trigger('change');

			});

			$elem.find('.nav-mobile select').off('change').on('change', function() {

				var tabNum = $(this).val();
				$elem.find('nav > a, .tab_content').removeClass('open');
				$elem.find('nav > a').eq( tabNum ).addClass('open');
				$elem.find('.tab_content').hide();

				var $content = $elem.find( '.tab_number_' + tabNum );
				if( $content.is(':visible') == false ) {
					$content.fadeIn();
				}

			});

		});
	}

	window.albedo_tabs_resize = function() {
		$('.theme-tabs').each( function() {
			var $elem = $(this),
			responsiveBreak = $elem.data('responsive-break');

			responsiveBreak = responsiveBreak == '' ? 767 : responsiveBreak;

			if( $(window).width() < responsiveBreak ) {
				$elem.addClass('mobile');
				$elem.find('.tab-content-image, .nav-desktop').hide();
				$elem.find('.nav-mobile').show();
			} else {
				$elem.removeClass('mobile');
				$elem.find('.tab-content-image, .nav-desktop').show();
				$elem.find('.nav-mobile').hide();
			}

		});
	}

	// Tabs shortcode
	window.albedo_tabs_init();
	window.albedo_tabs_resize();

	$(window).resize( function() {
		window.albedo_tabs_resize();
	});

})( window.jQuery );
