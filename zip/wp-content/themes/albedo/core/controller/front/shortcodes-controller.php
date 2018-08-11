<?php
/**
 * Shortcodes controller
 **/
class wplab_albedo_shortcodes_controller {

	function __construct() {

		// replace default gallery shortcode
		add_filter('post_gallery', array( $this, 'gallery' ), 10, 2 );

	}

	/**
	 * WordPress Gallery shortcode
	 **/
	function gallery( $output, $params ) {
		global $post, $wplab_albedo_core;

		$ids_str = isset( $params['ids'] ) && $params['ids'] <> '' ? $params['ids'] : '';

		$ids = array();
		if( $ids_str <> '' ) {
			$ids = explode( ',', $ids_str );
		}

		$args = array(
			'post_type' => 'attachment',
			'numberposts' => -1,
			'post_status' => null,
			'orderby' => 'menu_order'
		);

		if( is_array( $ids ) && count( $ids ) > 0 ) {
			$args['include'] = $ids;
		} else {
			$args['post_parent'] = $post->ID;
		}

		$data['items'] = get_posts( $args );

		if( count( $data['items'] ) > 0 && is_array( $data['items'] ) ) {

			ob_start();
			$wplab_albedo_core->view->load_partial( 'shortcodes/gallery', $data );
			return ob_get_clean();

		}
	}

}
