(function($){

	"use strict";

	$('body').waitForImages({
		waitForAll: true,
		finished: function() {

			// particle ground effect
			window.wplab_albedo_particle_ground();

		}
	});

	window.wplab_albedo_particle_ground = function() {

		$('.particle-ground-section').each( function() {

			var $elem = $(this),
			id = $elem.attr('id'),
			dotColor = $elem.data('dot-color'),
			lineColor = $elem.data('line-color'),
			particleRadius = $elem.data('particle-radius'),
			lineWidth = $elem.data('line-width'),
			curvedLines = window.themeFrontCore.stringToBoolean( $elem.data('curved-lines') ),
			parallax = window.themeFrontCore.stringToBoolean( $elem.data('parallax') ),
			parallaxMultiplier = $elem.data('parallax-multiplier'),
			proximity = $elem.data('proximity'),
			minSpeedX = $elem.data('min-speed-x'),
			maxSpeedX = $elem.data('max-speed-x'),
			minSpeedY = $elem.data('min-speed-y'),
			maxSpeedY = $elem.data('max-speed-y'),
			directionX = $elem.data('direction-x'),
			directionY = $elem.data('direction-y'),
			destiny = $elem.data('destiny');

			setTimeout( function() {

				$( '#' + id ).particleground({
					dotColor: dotColor,
					lineColor: lineColor,
					particleRadius: particleRadius,
					lineWidth: lineWidth,
					curvedLines: curvedLines,
					parallax: parallax,
					parallaxMultiplier: parallaxMultiplier,
					proximity: proximity,
					minSpeedX: minSpeedX,
					maxSpeedX: maxSpeedX,
					minSpeedY: minSpeedY,
					maxSpeedY: maxSpeedY,
					directionX: directionX,
					directionY: directionY,
					destiny: destiny
				});

			}, 800);

		});

	}

})( window.jQuery );
