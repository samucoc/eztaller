(function($){

	"use strict";

	window.albedo_simple_polls_init = function() {

		// Simple polls shortcode
		$('.shortcode-simple-polls').each( function() {

			var $elem = $(this),
			poll_id = $elem.data('poll-id');

			$(this).find('input').on( 'change', function() {

				var $check = $(this),
				vote_title = $.trim( $check.parents('.vote-item').find('label').text() ),
				vote = $check.is(':checked'),
				title_md5 = $.md5( 'wplab_albedo_poll_id_' + poll_id + '_' + vote_title );

				$.ajax({
					url: wplabAlbedoPolls.ajaxurl,
					type: "POST",
					data: {
						'action' : 'wplab_albedo_simple_vote',
						'poll_id' : poll_id,
						'vote_title' : vote_title,
						'vote' : vote
					},
					beforeSend: function() {

					},
					success: function() {

						$.cookie( title_md5, vote, { path: '/', expires: 365 });

					},
					error: function() {

					}
				});

			});

		});

	}

	window.albedo_simple_polls_init();

})( window.jQuery );
