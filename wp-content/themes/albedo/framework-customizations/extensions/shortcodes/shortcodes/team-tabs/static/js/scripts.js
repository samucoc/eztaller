(function($){

	"use strict";

	window.albedo_team_tabs_init = function() {
		// Team members tabs style
		$('.team-members-tabs').each( function() {

			var $tabs = $(this),
			effect = $tabs.data('effect'),
			$links = $tabs.find('.previews a'),
			$contents = $tabs.find('.tm-tabs-right .row');

			$contents.hide();
			$tabs.find('.tm-tabs-right .row:first').show().addClass('current');
			$tabs.find('.previews a:first').addClass('current');

			$links.click( function() {
				$links.removeClass('current');
				$(this).addClass('current');

				var index = $(this).index(),
				$toHideContent = $tabs.find('.tm-tabs-right .row.current');

				$contents.hide().attr('class', 'row');

				var $currContent = $contents.eq( index );
				$currContent.show().css('opacity', '0').addClass( effect + ' animated current');


			});

		});
	}

	window.albedo_team_tabs_init();

})( window.jQuery );
