(function($){

	"use strict";

	window.wplab_albedo_init_video_bg = function() {
		$('.video-bg-section .video-bg').YTPlayer({
			showControls: false,
			loop: true,
			autoPlay: true
		});
	}

	window.wplab_albedo_init_video_bg();

})( window.jQuery );
