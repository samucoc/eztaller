(function($){

	"use strict";

	window.wplab_albedo_layout_fn = {

		do_layout: function() {
			/**
				Make section full-height
			**/
			$(".full-height-section").each(function() {
				$(this).css( 'min-height', $(window).height() + 'px').css( 'line-height', $(window).height() + 'px');
			});

			/**
				Make row stretch outside container for default page template
			**/

			if( $('body').hasClass('layout-type-framed') || $('body').hasClass('layout-type-boxed') ) {
				return true;
			}

			var $elements = $( '.stretch_row_content_no_paddings, .stretch_row_content, .stretch_row');

			$.each( $elements, function(key, item) {

				var $el = $(this);
				var $el_full = $el.next( '.row-full-width');
				$el_full.length || ( $el_full = $el.parent().next( '.row-full-width') );

				if( $el_full.length ) {

					var el_margin_left = parseInt( $el.css( 'margin-left'), 10),
						el_margin_right = parseInt( $el.css( 'margin-right'), 10),
						offset = 0 - $el_full.offset().left - el_margin_left,
						width = $(window).width();

					if( $('body').hasClass('rtl') ) {

						if( $el.css({
							position: 'relative',
							right: offset,
							width: $(window).width()
						}), $el.hasClass( 'stretch_row')) {

							var padding = -1 * offset;
							0 > padding && ( padding = 0);
							var paddingRight = width - padding - $el_full.width() + el_margin_left + el_margin_right;
							0 > paddingRight && ( paddingRight = 0), $el.css({
								'padding-left': padding + 'px',
								'padding-right': paddingRight + 'px'
							});
						}

					} else {

						if( $el.css({
							position: 'relative',
							left: offset,
							width: $(window).width()
						}), $el.hasClass( 'stretch_row')) {

							var padding = -1 * offset;
							0 > padding && ( padding = 0);
							var paddingRight = width - padding - $el_full.width() + el_margin_left + el_margin_right;
							0 > paddingRight && ( paddingRight = 0), $el.css({
								'padding-left': padding + 'px',
								'padding-right': paddingRight + 'px'
							});
						}

					}

				}

			});

		}

	};

	// do Layout
	window.wplab_albedo_layout_fn.do_layout();

	$(window).resize( function() {
		window.wplab_albedo_layout_fn.do_layout();
	});

})( window.jQuery );
