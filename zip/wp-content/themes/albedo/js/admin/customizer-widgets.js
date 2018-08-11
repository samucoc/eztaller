jQuery.noConflict()( function($){
	"use strict";

	var wprotoMedia;

	var wprotoCustomizerCore = {

		/**
			Constructor
		**/
		initialize: function() {

			this.build();
			this.events();

		},
		/**
			Build page elements
		**/
		build: function() {



		},
		/**
			Check for events
		**/
		events: function() {

			var self = this;

			/** custom media uploader **/
			$('body').on( 'click', '.wplab_albedo_media_upload', function(e) {
				e.preventDefault();

				var $elem = $(this),
				$parent = $elem.parent().parent(),
				$input_img = $parent.find('.wplab_albedo_media_image'),
				$input_id = $parent.find('.wplab_albedo_media_id');

				wprotoMedia = wp.media.frames.wprotoMedia = wp.media({
					className: 'media-frame wproto-media-frame',
					frame: 'select',
					multiple: false,
					title: wplabAlbedoVars.strSelectImage,
					button: {
						text: wplabAlbedoVars.strSelect
					}
				});

				wprotoMedia.on('select', function() {
					var attachment = wprotoMedia.state().get('selection').first().toJSON();
					$input_img.attr('src', attachment.url);
					$input_id.val(attachment.id);
				}).open();

			});

			$('body').on( 'click', '.wplab_albedo_media_remove', function(e) {
				e.preventDefault();

				var $elem = $(this),
				$parent = $elem.parent().parent(),
				$input_img = $parent.find('.wplab_albedo_media_image'),
				$input_id = $parent.find('.wplab_albedo_media_id');

				$input_img.attr('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAAUEBAAAACwAAAAAAQABAAACAkQBADs=');
				$input_id.val('');

			});


		}


	}

	wprotoCustomizerCore.initialize();

});
