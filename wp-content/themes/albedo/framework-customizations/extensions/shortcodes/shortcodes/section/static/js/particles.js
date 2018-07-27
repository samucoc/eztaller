(function($){

	"use strict";

	if( $('.particles-element').length ) {

		setTimeout( function() {

			$('.particles-element').each( function() {
				$(this).height( $(this).parents('.pb-section').outerHeight() ).width( $('body').width() );
			});

		}, 700 );

		$(window).on('resize', function() {

			$('.particles-element').each( function() {
				$(this).height( $(this).parents('.pb-section').outerHeight() ).width( $('body').width() );
			});

		});


	}

	window.wplab_albedo_particles = function() {

		setTimeout( function() {

			$('.albedo-particles-js').each( function() {

				var $elem = $(this),
				id = $elem.attr('id');

				particlesJS( "particles-" + id,
					$.parseJSON( JSON.stringify( $elem.data('particles-config') ))
				);

			});

		}, 800);

	}

	$('body').waitForImages({
		waitForAll: true,
		finished: function() {

			// particles effect
			window.wplab_albedo_particles();

		}
	});

})( window.jQuery );
