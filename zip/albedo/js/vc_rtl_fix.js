jQuery(document).ready(function() {

	function albedo_fix_vc_full_width_row() {
		var $elements = jQuery('[data-vc-full-width="true"]');
		jQuery.each($elements, function () {
			var $el = jQuery(this);
			$el.css('right', $el.css('left')).css('left', '');
		});
	}

	// Fixes rows in RTL
	jQuery(document).on('vc-full-width-row', function () {
		albedo_fix_vc_full_width_row();
	});

	// Run one time because it was not firing in Mac/Firefox and Windows/Edge some times
	albedo_fix_vc_full_width_row();

});
