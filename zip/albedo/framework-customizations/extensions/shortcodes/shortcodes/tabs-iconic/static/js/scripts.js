(function($){

	"use strict";

	// Tabs shortcode
	_wplab_albedo_iconic_tabs_resize();

	$(window).resize( function() {
		_wplab_albedo_iconic_tabs_resize();
	});

	$('.theme-iconic-tabs').each( function() {

		var $elem = $(this);

		$elem.find('.tab_content').hide();
		$elem.find('.tab_content:first').show();
		$elem.find('nav a:first, .tab_content:first').addClass('open');

		$elem.find('nav a').on('click', function() {

			var tabNum = $(this).data('item');
			$elem.find('nav a, .tab_content').removeClass('open');
			$(this).addClass('open');
			$elem.find('.tab_content').hide();

			var $content = $elem.find( '.tab_number_' + tabNum );
			if( $content.is(':visible') == false ) {
				$content.addClass('opened').fadeIn();
			}

			if( $(window).width() <= 767 ) {
				$('html, body').animate({
					scrollTop: $elem.find('.tabs').offset().top - 20
				}, 300);
			}

		});

		$elem.find('nav a').hover( function() {
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

	});

	function _wplab_albedo_iconic_tabs_resize() {
		$('.theme-iconic-tabs').each( function() {
			var $elem = $(this),
			responsiveBreak = $elem.data('responsive-break');

			responsiveBreak = responsiveBreak == '' ? 767 : responsiveBreak;

			if( $(window).width() < responsiveBreak ) {
				$elem.addClass('mobile');
			} else {
				$elem.removeClass('mobile');
			}

		});
	}

})( window.jQuery );
