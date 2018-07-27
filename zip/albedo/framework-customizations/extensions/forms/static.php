<?php if (!defined('FW')) die('Forbidden');

if (!is_admin()) {
	wp_dequeue_style( 'fw-ext-forms-default-styles' );

	wp_enqueue_script( 'fw-form-helpers', fw_get_framework_directory_uri('/static/js/fw-form-helpers.js') );
	wp_localize_script( 'fw-form-helpers', 'fwAjaxUrl', admin_url( 'admin-ajax.php', 'relative' ));

}
