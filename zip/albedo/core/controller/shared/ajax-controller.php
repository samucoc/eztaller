<?php
/**
 *	AJAX actions controller
 **/
class wplab_albedo_ajax_controller {

	function __construct() {

		// Get latest tweets
		add_action( 'wp_ajax_wplab_albedo_get_latest_tweets', array( $this, 'theme_get_latest_tweets' ) );
		add_action( 'wp_ajax_nopriv_wplab_albedo_get_latest_tweets', array( $this, 'theme_get_latest_tweets' ) );

		// Simple vote
		add_action( 'wp_ajax_wplab_albedo_simple_vote', array( $this, 'simple_vote' ) );
		add_action( 'wp_ajax_nopriv_wplab_albedo_simple_vote', array( $this, 'simple_vote' ) );

		// Post like
		add_action( 'wp_ajax_wplab_albedo_like_post', array( $this, 'like_post' ) );
		add_action( 'wp_ajax_nopriv_wplab_albedo_like_post', array( $this, 'like_post' ) );

		// AJAX Search
		add_action( 'wp_ajax_wplab_albedo_ajax_search', array( $this, 'ajax_search' ) );
		add_action( 'wp_ajax_nopriv_wplab_albedo_ajax_search', array( $this, 'ajax_search' ) );

		// AJAX Query Posts
		add_action( 'wp_ajax_wplab_albedo_ajax_query_posts', array( $this, 'query_posts' ) );
		add_action( 'wp_ajax_nopriv_wplab_albedo_ajax_query_posts', array( $this, 'query_posts' ) );

		// Delete sidebars
		add_action( 'wp_ajax_wplab_albedo_delete_sidebars', array( $this, 'delete_sidebars' ));

		// Purge lc cache
		add_action( 'wp_ajax_wplab_albedo_purge_lc_cache', array( $this, 'purge_lc_cache' ) );

	}

	/**
	 * Load latest tweets
	 **/
	function theme_get_latest_tweets() {

		if( wplab_albedo_utils::is_unyson() && function_exists( 'fw_ext_social_twitter_get_connection') ) {

			$twitter = fw_ext_social_twitter_get_connection();

			$tweets = $twitter->get('statuses/user_timeline', array( 'count' => 10 ) );

			if( is_array( $tweets ) && count( $tweets ) > 0 ) {

				if( isset( $_POST['type'] ) && $_POST['type'] == 'carousel' ) {
					echo '<div class="tweets-carousel">';
				} else {
					echo '<div class="tweets">';
				}

				$limit = isset( $_POST['count'] ) ? absint( $_POST['count'] ) : 10;
				$i=0;

				foreach( $tweets as $tweet ) {
					$i++;

					if( $i > $limit ) {
						break;
					} else {
						echo '<div class="item"><div class="inside"><i class="fa fa-twitter"></i> ' . str_replace( '<a', '<a target="_blank"', make_clickable( $tweet->text ) ) . ' <span class="time">' . human_time_diff( strtotime( $tweet->created_at ) ) . ' ' . esc_html__('ago', 'albedo') . '</span>' . '</div></div>';
					}

				}

				echo '</div>';

			} else {
				esc_html_e( 'Can not load latest tweets', 'albedo' );
			}

		}


		exit;
	}

	/**
	 * Simple vote
	 **/
	function simple_vote() {

		$poll_id = absint( $_POST['poll_id'] );
		$vote_title = md5( wp_kses_post( trim( $_POST['vote_title'] ) ) );
		$vote_result = filter_var( $_POST['vote'], FILTER_VALIDATE_BOOLEAN ) ? 1 : -1;

		$saved_results = get_post_meta( $poll_id, 'vote_results', true );
		$new_results = array();

		if( is_array( $saved_results ) && !empty( $saved_results ) ) {

			foreach( $saved_results as $key => $value ) {

				if( $key === $vote_title ) {
					$new_results[ $vote_title ] = $value + $vote_result;
				} else {
					$new_results[ $key ] = $value;
				}

			}

		} else {
			$new_results[ $vote_title ] = $vote_result;
		}

		$new_results[ $vote_title ] = absint( $new_results[ $vote_title ] );

		update_post_meta( $poll_id, 'vote_results', $new_results );

		die;
	}

	/**
	 * Like post
	 **/
	function like_post() {

		$post_id = absint( $_POST['post_id'] );
		$vote_result = filter_var( $_POST['vote'], FILTER_VALIDATE_BOOLEAN ) ? 1 : -1;

		$votes_count = get_post_meta( $post_id, 'likes', true );

		$votes_count = absint( $votes_count + $vote_result );

		update_post_meta( $post_id, 'likes', $votes_count );

		printf( _nx( '1 Like', '%1$s Likes', $votes_count, 'post likes', 'albedo' ), number_format_i18n( $votes_count ) );

		die;
	}

	/**
	 * AJAX Search
	 **/
	function ajax_search() {

		if( ! filter_var( fw_get_db_settings_option( 'ajax_search/enabled' ), FILTER_VALIDATE_BOOLEAN ) ) {
			die;
		}

		$answer = array();

		$search_string = $_POST['query'];

		$query_args = array(
			'post_type' => array_values( fw_get_db_settings_option( 'ajax_search/yes/ajax_search_source_post_types' ) ),
			'post_status' => 'publish',
			's' => $search_string
		);

		$posts = new WP_Query( $query_args );

		if( $posts->have_posts() ) {

			while ( $posts->have_posts() ) : $posts->the_post();

				$post_type = get_post_type();
				if( $post_type == '') {
					$post_type = 'post';
				}

				$post_type_obj = get_post_type_object( $post_type );

				$answer['suggestions'][] = array(
					'value' => get_the_title(),
					'data' => array(
						'link' => get_permalink(),
						'category' => $post_type_obj->labels->name
					)
				);

			endwhile;

		} else {
			$answer['suggestions'] = array();
		}

		//echo '<pre>';
		//var_dump( $answer );

		die( json_encode( $answer ) );
	}

	/**
		* Query posts using AJAX
		* used for Filters, AJAX load more posts etc...
		*
	**/
	function query_posts() {
		global $wplab_albedo_core;

		if( ! isset( $_POST['atts'] ) || ! is_array( $_POST['atts'] ) ) die( esc_html__('Wrong AJAX Query', 'albedo'));

		$answer = array();

		if( $_POST['query_type'] == 'filter' ) {

			$_POST['atts']['query_data']['type'] = 'include';
			if( trim( $_POST['term'] ) == '' ) {
				$_POST['atts']['query_data']['type'] = 'all';
			}
			$_POST['atts']['query_data']['terms'] = $_POST['term'];
			$_POST['atts']['query_data']['paged'] = 1;

		} elseif( $_POST['query_type'] == 'load_more' ) {

			$_POST['atts']['query_data']['paged'] = $_POST['paged'];

		}

		$posts = $wplab_albedo_core->model('post')->get( $_POST['atts']['query_data'] );

		set_query_var( 'wplab_albedo_tpl_settings', $_POST['atts'] );

		ob_start();

		if( $posts->have_posts() ) {
			while ( $posts->have_posts() ): $posts->the_post();
				get_template_part( stripcslashes( $_POST['atts']['tpl'] ) );
			endwhile;
		}
		$answer['html'] = ob_get_clean();
		$answer['max_pages'] = $posts->max_num_pages;
		$answer['next_page'] = $_POST['atts']['query_data']['paged'] + 1;
		$answer['atts'] = $_POST['atts'];

		echo json_encode( $answer );

		exit;

	}

	// temporary code until unyson developers will fix their shit
	function delete_sidebars() {

		if( current_user_can('edit_theme_options') ) {
			parse_str( $_POST['data'], $sidebars );
			if( isset( $sidebars['wproto-sidebar'] ) && !empty( $sidebars['wproto-sidebar'] ) ) {

				$custom_sides = get_option('albedo-fw-sidebars-options');

				foreach( $sidebars['wproto-sidebar'] as $side ) {
					unset( $custom_sides['sidebars'][$side] );
				}

				update_option( 'albedo-fw-sidebars-options', $custom_sides );

			}
		}

		die;
	}

	/**
	 * Purge lc cache
	**/
	function purge_lc_cache() {
		delete_transient( 'd3BsYWJfYWxiZWRvX2FjdGl2ZV9kb21haW4=' );
		die;
	}

}
