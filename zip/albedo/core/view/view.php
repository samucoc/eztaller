<?php
	/**
	 * Anything to do with templates
	 * and outputting client code
	 **/
	class wplab_albedo_view {
		/**
		 * Load view WITHOUT header/footer, in case you would like
		 * to nest templates, to loop through the same template, or
		 * to use a mixture of different templates in any other way.
		 **/
		function load_partial( $path = '', $data = array() ) {

			//! TODO: Secure this, e.g. don't allow '..'
			$full_path = wplab_albedo_utils::locate_path( '/core/view/' . $path . '.php' );

			if( ! file_exists( $full_path ) ) {
				$full_path = get_template_directory() . '/' . $path . '.php';
			}

			if ( file_exists( $full_path ) ) {
				require $full_path;
			} else {
				throw new Exception( 'The view path ' . $full_path . ' can not be found.' );
			}
		}

		/**
		 * Load view WITHOUT header/footer for AJAX purposes. We will
		 * have to exit, or AJAX success code 1/0 will be outputted.
		 **/
		function load_ajax_partial( $path = '', $data = array() ) {
			$this->load_partial( $path, $data );
			exit;
		}

	}
