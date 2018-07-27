<?php
/**
 * Do stuff common to all model classes
 * that extend this database class
 **/
class wplab_albedo_database {
	/**
	 * Class vars
	 **/
	protected $wpdb = null;
	protected $tables = array();

	/**
	 * Make Wordpress dbase object and other
	 * models available to all model classes.
	 * Also, define database tables.
	 **/
	function __construct() {
		global $wpdb;
		$this->wpdb = $wpdb;

		$this->tables = array(
			'revslider_sliders' => $this->wpdb->prefix . "revslider_sliders",
			'revslider_slides' => $this->wpdb->prefix . "revslider_slides",
			'layerslider' => $this->wpdb->prefix . "layerslider",
			'essgrids' => $this->wpdb->prefix . "eg_grids",
			'ninjaforms3' => $this->wpdb->prefix . "nf3_forms",
			'masterslider' => $this->wpdb->prefix . "masterslider_sliders",
			'wedocs' => $this->wpdb->prefix . "posts",
			'gopricing' => $this->wpdb->prefix . "posts",
			'gravityforms' => $this->wpdb->prefix . "rg_form",
			'mailchimp' => $this->wpdb->prefix . "posts",
			'posts' => $this->wpdb->prefix . "posts"
		);

	}
}
