<?php
/**
 * Plugins / third party data model
 **/
class wplab_albedo_thirdparty extends wplab_albedo_database {

	/**
	 * Get Revolution Slider slideshows
	 **/
	function get_rev_sliders() {

		$table = $this->tables['revslider_sliders'];

		return $this->wpdb->get_results(
			"SELECT *
				FROM $table
				WHERE 1"
		);

	}

	/**
	 * Get LayerSlider slideshows
	 **/
	function get_layerslider_sliders() {

		$table = $this->tables['layerslider'];

		return $this->wpdb->get_results(
			"SELECT *
				FROM $table
				WHERE 1"
		);

	}

	/**
	 * Get Essential Grid grids
	 **/
	function get_essential_grids() {

		$table = $this->tables['essgrids'];

		return $this->wpdb->get_results(
			"SELECT *
				FROM $table
				WHERE 1"
		);

	}

	/**
	 * Get Masterslider grids
	 **/
	function get_masterslider_sliders() {

		$table = $this->tables['masterslider'];

		return $this->wpdb->get_results(
			"SELECT *
				FROM $table
				WHERE status = 'published'"
		);

	}

	/**
	 * Get WeDocs docs
	 **/
	function get_wedocs() {

		$table = $this->tables['wedocs'];

		return $this->wpdb->get_results(
			"SELECT *
				FROM $table
				WHERE post_type = 'docs' AND post_parent = 0"
		);

	}

	/**
	 * Get Polls
	 **/
	function get_polls() {

		$table = $this->tables['posts'];

		return $this->wpdb->get_results(
			"SELECT *
				FROM $table
				WHERE post_type = 'polls' AND post_parent = 0 AND post_status = 'publish'"
		);

	}

	/**
	 * Get GoPricing Tables
	 **/
	function get_gopricing() {

		$table = $this->tables['gopricing'];

		return $this->wpdb->get_results(
			"SELECT *
				FROM $table
				WHERE post_type = 'go_pricing_tables'"
		);

	}

	/**
	 * Get Gravity Forms
	 **/
	function get_gravityforms() {

		$table = $this->tables['gravityforms'];

		return $this->wpdb->get_results(
			"SELECT *
				FROM $table
				WHERE is_active = 1"
		);

	}

	/**
	 * Get Ninja Forms Form
	 **/
	function get_ninja_forms() {

		$table = $this->tables['ninjaforms3'];

		return $this->wpdb->get_results(
			"SELECT *
				FROM $table
				WHERE 1"
		);

	}

	/**
	 * Get MailChimp Form
	 **/
	function get_mailchimp_forms() {

		$table = $this->tables['mailchimp'];

		return $this->wpdb->get_results(
			"SELECT *
				FROM $table
				WHERE post_type = 'mc4wp-form'"
		);

	}

}
