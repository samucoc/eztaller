jQuery.noConflict()( function($){
	"use strict";

	var albedoTableMedia;

	var albedoTablesEditor = {

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

			if( $('#albedo-pricing-table-editor').length ) {

				$('#albedo-pricing-table-editor tbody').sortable({
					update : function() {
						self.updatePricingTable();
					},
					items: "tr:not(.system-item)"
				});

			}

			//$('#albedo-pricing-table-editor *[title]').tipsy({gravity: 's'});

		},
		/**
			Set page events
		**/
		events: function() {

			var self = this;

			// upload icon
			$( '#albedo-pricing-table-editor' ).on('click', '.albedo-upload-icon', function() {

				var $link = $(this),
				$link_parent = $link.parent();

				albedoTableMedia = wp.media.frames.wprotoMedia = wp.media({
					className: 'media-frame wproto-media-frame',
					frame: 'select',
					multiple: false,
					title: wplabAlbedoVars.strSelectImage,
					library: {
						type: 'image'
					},
					button: {
						text: wplabAlbedoVars.strSelect
					}
				});

				albedoTableMedia.on('select', function(){
					//var media_attachment = wprotoMedia.state().get('selection').first().toJSON();
					var file = albedoTableMedia.state().get('selection').first().toJSON();
					$link_parent.find('input.icon-id').val( file.id );
					$link_parent.find('input.icon-url').val( file.url );
					$link_parent.find('.plan-icon').css('background-image', 'url('+file.url+')').addClass('with-icon');

				});

				albedoTableMedia.open();

				return false;

			});

			// remove icon
			$( '#albedo-pricing-table-editor' ).on('click', '.albedo-remove-icon', function() {

				var $link = $(this),
				$link_parent = $link.parent();

				$link_parent.find('input.icon-id').val( '' );
				$link_parent.find('input.icon-url').val( '' );
				$link_parent.find('.plan-icon').css('background-image', 'none').removeClass('with-icon');

				return false;

			});

			// delete feature button
			$( '#albedo-pricing-table-editor' ).on('click', '.albedo-delete-feature', function() {

				$(this).parents('tr').fadeOut( 500, function() { $(this).remove(); self.updatePricingTable(); });

				return false;
			});

			// delete package
			$( '#albedo-pricing-table-editor' ).on( 'click', '.albedo-delete-package', function() {

				if( $('th.package-title').length == 1 ) {
					return false;
				}

				var table = $('#albedo-pricing-table-editor');
				var index = table.find('tfoot th').index( $(this).parents('th') );

				table.find('thead, tfoot').find('tr th:eq(' + index + ')').fadeOut( 500, function() { $(this).remove() });
				table.find('tbody tr').each( function() {
					$(this).find('td:eq(' + index + ')').fadeOut( 500, function() { $(this).remove(); self.updatePricingTable(); })
				});

				return false;
			});

			// make package featured
			$( '#albedo-pricing-table-editor' ).on('click', '.albedo-make-featured-price', function() {
				if( $(this).hasClass('button-primary') ) {
					$(this).removeClass('button-primary');
					$(this).find('input').attr('checked', false );
				} else {
					$('.albedo-make-featured-price').removeClass('button-primary');
					$('.albedo-make-featured-price input').removeAttr('checked');
					$(this).addClass('button-primary');
					$(this).find('input').attr('checked', 'checked');
				}
				return false;
			});

			// mark description column
			$( '#albedo-pricing-table-editor' ).on('click', '.albedo-make-desc-col', function() {
				if( $(this).hasClass('button-primary') ) {
					$(this).removeClass('button-primary');
					$(this).find('input').attr('checked', false );
				} else {
					$('.albedo-make-desc-col').removeClass('button-primary');
					$('.albedo-make-desc-col input').removeAttr('checked');
					$(this).addClass('button-primary');
					$(this).find('input').attr('checked', 'checked');
				}
				return false;
			});

			// add package
			$('.albedo-add-pricing-package').click( function() {

				var table = $('#albedo-pricing-table-editor');

				$( '<th class="package-title"><input name="pt[packages][names][0][]" type="text" value="' + wplabAlbedoVars.strPackageName + '" /></th>' ).insertBefore( table.find('thead th:last') );
				$( '<th class="center"><a href="javascript:;" class="albedo-delete-package button"><i class="fa fa-times"></i></a> <a href="javascript:;" class="albedo-make-desc-col button"><i class="fa fa-info-circle"></i><input type="radio" name="pt[pricing_table][desc_col]" value="0" /></a> <a href="javascript:;" class="albedo-make-featured-price button"><i class="fa fa-star"></i><input type="radio" name="pt[pricing_table][featured]" value="0" /></a></th>' ).insertBefore( table.find('tfoot th:last') );
				table.find('tbody tr.system-item, tbody tr.custom-item').each( function() {

					$(this).find( 'td' ).eq( $(this).find('td').length - 2 ).clone().insertBefore( $(this).find('td:last') );
					$(this).find( 'td' ).eq( $(this).find('td').length - 2 ).find('input, textarea').val('');
					$(this).find( 'td' ).eq( $(this).find('td').length - 2 ).find('div.plan-icon').css('background-image', 'none').removeClass('with-icon');

				});

				self.updatePricingTable();
				return false;
			});

			// add feature
			$('.albedo-add-pricing-feature').click( function() {

				var table = $('#albedo-pricing-table-editor');
				var pLen = table.find('thead th').length - 2;
				var fLen = $('tr.custom-item').length;
				var html = '<tr style="display: none" class="move custom-item"><td class="ex description"><a href="javascript:;" class="button albedo-delete-feature"><i class="fa fa-times"></i></a> <input name="pt[features][user_features_names][' + fLen + '][]" type="text" value="' + wplabAlbedoVars.strYourFeature + '" /></td>';

				if( pLen > 0 ) {
					for( var i=0; i<pLen; i++ ) {
						html = html + '<td><input name="pt[features][user_features_values][0][]" type="text" value="' + wplabAlbedoVars.strValue + '" /></td>';
					}
				}

				html = html + '<td class="ex center"><img width="16" height="16" src="' + wplabAlbedoVars.moveImgSrc + '" alt="" /></td></tr>';
				table.append( html );
				table.find('tbody tr:last').fadeIn(500, function() {
					self.updatePricingTable();
				});

				return false;
			});

		},

		/**************************************************************************************************************************
			Class methods
		**************************************************************************************************************************/
		updatePricingTable: function() {

			var table = $('#albedo-pricing-table-editor');

			table.find('thead th').not('.ex').each( function( index ) {
				$(this).find('input').attr('name', 'pt[packages][names][' + index + ']');
			});

			table.find('tbody tr').each( function() {

				$(this).find('td').not('.ex').each( function( index ) {

					var i = index;

					$(this).find('input, textarea').each( function() {

						var currName = $(this).attr('name');

						var pattern = /\[[0-9]+\]/i;
						var newName = currName.replace( pattern, '[' + i + ']');

						$(this).attr('name', newName);

					});

				});

			});

			table.find('tfoot th').not('.ex').each( function( index ) {
				$(this).find('input').attr('name', 'pt[pricing_table][featured]').val( index );
				$(this).find('input').attr('name', 'pt[pricing_table][desc_col]').val( index );
			});

		}
	}

	albedoTablesEditor.initialize();

});
