/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Layout type
	wp.customize( 'fw_options[layout_type]', function( value ) {
		value.bind( function( newval ) {

			newval = JSON.parse(newval);
			$('body').removeClass( function (index, classNames) {
				var current_classes = classNames.split(" "),
						classes_to_remove = [];

				$.each(current_classes, function (index, class_name) {
					if (/layout-type.*/.test( class_name )) {
						classes_to_remove.push(class_name);
					}
				});
				// turn the array back into a string
				return classes_to_remove.join(" ");
			});

			$('body').addClass('layout-type-' + newval[0].value);

			if( newval[0].value == 'default' ) {

				window.wplab_albedo_layout_fn.do_layout();

			} else {

				var $elements = $( '.stretch_row_content_no_paddings, .stretch_row_content, .stretch_row');
				$.each( $elements, function(key, item) {

					$(this).css({
						'right': 'auto',
						'left': 'auto',
						'width' : 'auto',
						'padding-left' : 0,
						'padding-right' : 0
					});

				});

			}

		});
	});

	// Layout width
	wp.customize( 'fw_options[layout_width]', function( value ) {
		value.bind( function( newval ) {
			newval = JSON.parse(newval);
			$('#wrap').css('max-width', newval[0].value );
		});
	});

	// Cols paddings
	wp.customize( 'fw_options[layout_column_padding]', function( value ) {
		value.bind( function( newval ) {
			newval = JSON.parse(newval);
			$('.container, .container-fluid, .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12, .fw-col-xs-1, .fw-col-sm-1, .fw-col-md-1, .fw-col-lg-1, .fw-col-xs-2, .fw-col-sm-2, .fw-col-md-2, .fw-col-lg-2, .fw-col-xs-3, .fw-col-sm-3, .fw-col-md-3, .fw-col-lg-3, .fw-col-xs-4, .fw-col-sm-4, .fw-col-md-4, .fw-col-lg-4, .fw-col-xs-5, .fw-col-sm-5, .fw-col-md-5, .fw-col-lg-5, .fw-col-xs-6, .fw-col-sm-6, .fw-col-md-6, .fw-col-lg-6, .fw-col-xs-7, .fw-col-sm-7, .fw-col-md-7, .fw-col-lg-7, .fw-col-xs-8, .fw-col-sm-8, .fw-col-md-8, .fw-col-lg-8, .fw-col-xs-9, .fw-col-sm-9, .fw-col-md-9, .fw-col-lg-9, .fw-col-xs-10, .fw-col-sm-10, .fw-col-md-10, .fw-col-lg-10, .fw-col-xs-11, .fw-col-sm-11, .fw-col-md-11, .fw-col-lg-11, .fw-col-xs-12, .fw-col-sm-12, .fw-col-md-12, .fw-col-lg-12').css('padding-left', newval[0].value + 'px' ).css('padding-right', newval[0].value + 'px' );
		});
	});

	// Framed layout margins
	wp.customize( 'fw_options[framed_margins]', function( value ) {
		value.bind( function( newval ) {
			newval = JSON.parse(newval);
			newval = newval[0].value;
			$('body.layout-type-framed #wrap').css('margin', newval + ' auto');
		});
	});

	// Framed layout corners
	wp.customize( 'fw_options[framed_corners]', function( value ) {
		value.bind( function( newval ) {
			newval = JSON.parse(newval);
			newval = newval[0].value;
			$('body.layout-type-framed #wrap').css('border-radius', newval );
		});
	});

	// Box top padding
	wp.customize( 'fw_options[box_top_padding]', function( value ) {
		value.bind( function( newval ) {
			newval = JSON.parse(newval);
			newval = newval[0].value;
			$('body.layout-type-framed #wrap, body.layout-type-boxed #wrap').css('padding-top', newval );
		});
	});

	// Box bottom padding
	wp.customize( 'fw_options[box_bottom_padding]', function( value ) {
		value.bind( function( newval ) {
			newval = JSON.parse(newval);
			newval = newval[0].value;
			$('body.layout-type-framed #wrap, body.layout-type-boxed #wrap').css('padding-bottom', newval );
		});
	});

	// Sidebar size
	wp.customize( 'fw_options[sidebar_size]', function( value ) {
		value.bind( function( newval ) {

			newval = JSON.parse(newval);

			var sideSize = newval[0].value,
			contentSize = 12 - sideSize;

			if( $('#sidebar-second').length ) {
				contentSize = Math.ceil( 12 - sideSize * 2 );
			}

			if( $('#sidebar-gap').length && ! $('#sidebar-second').length ) {
				contentSize = contentSize - 1;
			}

			$( "#sidebar, #content, #sidebar-second").removeClass( function (index, classNames) {
				var current_classes = classNames.split(" "),
						classes_to_remove = [];

				$.each(current_classes, function (index, class_name) {
					if (/col-md.*/.test( class_name )) {
						classes_to_remove.push(class_name);
					}
				});
				// turn the array back into a string
				return classes_to_remove.join(" ");
			});

			$('#sidebar, #sidebar-second').addClass('col-md-' + sideSize);
			$('#content').addClass('col-md-' + contentSize);

		});
	});

	// Widgets style
	wp.customize( 'fw_options[widgets_style]', function( value ) {
		value.bind( function( newval ) {

			newval = JSON.parse(newval);
			newval = newval[0].value;

			$( ".aside").removeClass( function (index, classNames) {
				var current_classes = classNames.split(" "),
						classes_to_remove = [];

				$.each(current_classes, function (index, class_name) {
					if (/widgets-style.*/.test( class_name )) {
						classes_to_remove.push(class_name);
					}
				});
				// turn the array back into a string
				return classes_to_remove.join(" ");
			});

			$('.aside').addClass('widgets-style-' + newval);

		});
	});

	// Hide sidebar on mobiles
	wp.customize( 'fw_options[hide_sidebar_on_mobiles]', function( value ) {
		value.bind( function( newval ) {

			newval = JSON.parse(newval);

			if( newval[0].value === '"yes"' ) {
				$('.aside').addClass('hide-on-phones');
			} else {
				$('.aside').removeClass('hide-on-phones');
			}

		});
	});


} )( jQuery );
