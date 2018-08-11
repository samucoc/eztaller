(function($){

	"use strict";

	if( $('.tweets-block').length ) {

		$('.tweets-block').each( function() {
			var $block = $(this);
			var count = $block.data('count');

			$.ajax({
				url: wprotoEngineVars.ajaxurl,
				type: "POST",
				data: {
					'action' : 'wplab_albedo_get_latest_tweets',
					'count' : count
				},
				success: function( response ) {

					$('.tweets-block').each( function() {
						$block.replaceWith( response );
					});

				}
			});

		});

	}

})( window.jQuery );
