jQuery.noConflict()( function($){
	"use strict";

	var wprotoMedia;

	var wprotoThemeCore = {

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

			var self = this;

			/**
			if( $('#widgets-right').length && typeof( fwEvents ) !== undefined ) {

				var timeoutId;
				$(document).on('widget-updated widget-added', function(){
					clearTimeout(timeoutId);
					timeoutId = setTimeout(function(){ // wait a few milliseconds for html replace to finish
						fwEvents.trigger('fw:options:init', { $elements: $('#widgets-right .fw-backend-option') });
					}, 2000 );
				});

			}
			**/

		},
		/**
			Check for events
		**/
		events: function() {

			var self = this;

			/** custom media uploader **/
			$('#wpbody-content').on( 'click', '.wplab_albedo_media_upload', function(e) {
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

			$('#wpbody-content').on( 'click', '.wplab_albedo_media_remove', function(e) {
				e.preventDefault();

				var $elem = $(this),
				$parent = $elem.parent().parent(),
				$input_img = $parent.find('.wplab_albedo_media_image'),
				$input_id = $parent.find('.wplab_albedo_media_id');

				$input_img.attr('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAAUEBAAAACwAAAAAAQABAAACAkQBADs=');
				$input_id.val('');

			});

			/** delete chosen sidebars **/
			$( '.fw-settings-form' ).on( 'click', '#wproto-delete-sidebars', function() {

				var sidebars = $('#wproto-sidebars-list input').serialize();

				$.ajax({
					url: ajaxurl,
					type: "POST",
					data: {
						'action' : 'wplab_albedo_delete_sidebars',
						'data' : sidebars
					},
					success: function() {

						$('#wproto-sidebars-list input:checked').parent().remove();

					}
				});

				return false;
			});

			/** purge cache for combined CSS & JS files **/
			$( '.fw-settings-form' ).on( 'click', '#wproto-purge-combined-cache', function() {

				var $button = $(this);

				if( $button.is(':disabled') ) {
					return false;
				}

				$button.attr('disabled', 'disabled');
				fw.loading.show();

				// make AJAX call to chear the cache

				$.ajax({
					url: ajaxurl,
					type: "POST",
					data: {
						'action' : 'wplab_albedo_purge_combined_assets'
					},
					success: function() {

						$button.removeAttr('disabled');
						fw.loading.hide();

						var modalDialog = $( '<div title="' + wplabAlbedoVars.allDone + '">' + wplabAlbedoVars.allCachePurged + '<br/></div>' ).dialog({
							modal: true,
							width: 500,
							resizable: false,
							draggable: false,
							buttons: {
								"OK": function() {
									$( this ).dialog( "close" );
								}
							}
						});

					}
				});

				return false;
			});

			/** purge activation cache **/
			$( '.fw-settings-form' ).on( 'click', '#wproto-purge-activation-cache', function() {

				var $button = $(this);

				if( $button.is(':disabled') ) {
					return false;
				}

				$button.attr('disabled', 'disabled');
				fw.loading.show();

				// make AJAX call to chear the cache

				$.ajax({
					url: ajaxurl,
					type: "POST",
					data: {
						'action' : 'wplab_albedo_purge_lc_cache'
					},
					success: function() {

						$button.removeAttr('disabled');
						fw.loading.hide();

						var modalDialog = $( '<div title="' + wplabAlbedoVars.allDone + '">' + wplabAlbedoVars.allCachePurged + '<br/></div>' ).dialog({
							modal: true,
							width: 500,
							resizable: false,
							draggable: false,
							buttons: {
								"OK": function() {
									$( this ).dialog( "close" );
								}
							}
						});

					}
				});

				return false;
			});

		},

		/**
			Check for a valid email address
		**/
		isEmail: function( email ) {
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		}

	}

	wprotoThemeCore.initialize();

});
