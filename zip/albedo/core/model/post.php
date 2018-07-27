<?php
	/**
	 * Post model
	 **/
	class wplab_albedo_post extends wplab_albedo_database {
		/**
		 * Get items
		 * @return object
		 **/
		function get( $args = array() ) {
			global $post;

			$type = isset( $args['type'] ) ? $args['type'] : 'all';
			$terms = isset( $args['terms'] ) ? $args['terms'] : '';
			$order = isset( $args['order'] ) ? $args['order'] : 'date';
			$sort = isset( $args['sort'] ) ? $args['sort'] : 'DESC';
			$post_type = isset( $args['post_type'] ) ? $args['post_type'] : 'post';
			$tax_name = isset( $args['tax_name'] ) ? $args['tax_name'] : 'category';
			$featured_only = isset( $args['featured_only'] ) ? filter_var( $args['featured_only'], FILTER_VALIDATE_BOOLEAN ) : false;
			$featured_post_only = isset( $args['featured_post_only'] ) ? filter_var( $args['featured_post_only'], FILTER_VALIDATE_BOOLEAN ) : false;
			$sticky_only = isset( $args['sticky_only'] ) ? filter_var( $args['sticky_only'], FILTER_VALIDATE_BOOLEAN ) : false;
			$with_thumbnail_only = isset( $args['with_thumbnail_only'] ) ? filter_var( $args['with_thumbnail_only'], FILTER_VALIDATE_BOOLEAN ) : false;
			$paged = isset( $args['paged'] ) ? $args['paged'] : 1;
			$term_field = isset( $args['term_field'] ) ? $args['term_field'] : 'id';
			$exclude_current_post = isset( $args['exclude_current_post'] ) ? filter_var( $args['exclude_current_post'], FILTER_VALIDATE_BOOLEAN ) : false;
			$include_children_cats = isset( $args['include_children'] ) ? filter_var( $args['include_children'], FILTER_VALIDATE_BOOLEAN ) : true;
			$post_format = isset( $args['post_format'] ) ? $args['post_format'] : '';

			$q_args = array(
				'post_type' => $post_type,
				'post_status' => 'publish',
				'order' => $sort,
				'orderby' => $order,
				'paged' => $paged
			);

			if( isset( $args['orderby_meta_key'] ) ) {
				$q_args['orderby_meta_key'] = $args['orderby_meta_key'];
			}

			if( isset( $args['post_count'] ) ) {
				$q_args['post_count'] = (int)$args['post_count'];
			}

			if( isset( $args['limit'] ) ) {
				$q_args['limit'] = (int)$args['limit'];
			}

			if( isset( $args['posts_per_page'] ) ) {
				$q_args['posts_per_page'] = (int)$args['posts_per_page'];
			}

			if( $exclude_current_post ) {
				$q_args['post__not_in'] = isset( $post->ID ) ? array( $post->ID ) : array();
			}

			if( ! $sticky_only ) {
				$q_args['ignore_sticky_posts'] = 1;
			}

			if( $type == 'include' || $type == 'only' ) {
				$q_args['tax_query'] = array(
					array(
						'taxonomy' => $tax_name,
						'field' => $term_field,
						'terms' => $terms,
						'include_children' => $include_children_cats
					)
				);
			}

			if( $type == 'all_child' ) {
				$q_args['tax_query'] = array(
					array(
						'taxonomy' => $tax_name,
						'field' => $term_field,
						'terms' => $terms,
						'include_children' => true
					)
				);
			}

			if( $type == 'exclude' || $type == 'except' ) {
				$q_args['tax_query'] = array(
					array(
						'taxonomy' => $tax_name,
						'field' => $term_field,
						'terms' => $terms,
						'operator' => 'NOT IN',
						'include_children' => $include_children_cats
					)
				);
			}

			if( $post_format <> '' && $post_format != 'standard' ) {
				$q_args['tax_query'] = array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'post_format',
						'field'    => 'slug',
						'terms'    => array( 'post-format-' . $post_format ),
					)
				);
			} elseif( $post_format == 'standard' ) {
				$q_args['tax_query'] = array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'post_format',
						'field'    => 'slug',
						'terms'    => array( 'post-format-quote', 'post-format-link', 'post-format-chat', 'post-format-gallery', 'post-format-aside', 'post-format-audio', 'post-format-video', 'post-format-image' ),
						'operator' => 'NOT IN',
					)
				);

			}

			if( $featured_only ) {
				$q_args['meta_query'][] = array(
					'key' => 'featured',
					'value' => 'yes'
				);
			}

			if( $featured_post_only ) {
				$q_args['meta_query'][] = array(
					'key' => 'fw_option:featured',
					'value' => 'yes'
				);
			}

			if( $with_thumbnail_only ) {
				$q_args['meta_query'][] = array(
					'key' => '_thumbnail_id'
				);
			}

			if( $sticky_only ) {
				$q_args['post__in'] = get_option( 'sticky_posts' );
			}

			if( isset( $args['meta_query'] ) && isset( $q_args['meta_query'] ) ) {
				$q_args['meta_query'] = array_merge( $q_args['meta_query'], $args['meta_query'] );
			} elseif( isset( $args['meta_query'] ) ) {
				$q_args['meta_query'] = $args['meta_query'];
			}

			return new WP_Query( $q_args );

		}

		/**
		 * Get all posts
		 **/
		function get_all_posts( $post_type ) {
			global $post;

			$args = array(
				'post_type' => $post_type,
				'post_status' => 'publish',
				'nopaging' => true
			);

			return new WP_Query( $args );
		}

		/**
		 * Get popular posts
		 **/
		function get_popular_posts( $post_type, $limit ) {
			$args = array(
				'post_type' => $post_type,
				'post_status' => 'publish',
				'posts_per_page' => $limit,
				'order' => 'DESC',
				'ignore_sticky_posts' => true,
				'orderby' => 'comment_count'
			);

			return new WP_Query( $args );
		}

		/**
		 * Get recent posts
		 **/
		function get_recent_posts( $post_type, $limit ) {
			$args = array(
				'post_type' => $post_type,
				'post_status' => 'publish',
				'posts_per_page' => $limit,
				'order' => 'DESC',
				'ignore_sticky_posts' => true
			);

			return new WP_Query( $args );
		}

		/**
		 * Get related posts
		 **/
		function get_related_posts( $primary_post_id, $limit, $taxonomy = 'category', $with_thumbnail_only = false ) {

			$terms = wp_get_post_terms( $primary_post_id, $taxonomy );

			$response = false;

			if( count( $terms ) > 0 ) {

				$post_type = get_post_type( $primary_post_id );
				$post_terms_ids = array();

				foreach( $terms as $term ) {
					$post_terms_ids[] = $term->term_id;
				}

				$args = array(
					'post_type' => $post_type,
					'post_status' => 'publish',
					'posts_per_page' => $limit,
					'order' => 'DESC',
					'orderby' => 'rand',
					'ignore_sticky_posts' => true,
					'post__not_in' => array( $primary_post_id ),
					'tax_query' => array(
						'relation' => 'OR',
						array(
							'taxonomy' => $taxonomy,
							'field' => 'id',
							'terms' => $post_terms_ids
						)
					)
				);

				if( $with_thumbnail_only ) {
					$args['meta_query'][] = array(
						'key' => '_thumbnail_id'
					);
				}

				$response = new WP_Query( $args );

			}

			return $response;
		}

		/**
		 * Get random posts
		 **/
		function get_random_posts( $post_type, $limit, $with_thumbnail_only = false ) {
			$args = array(
				'post_type' => $post_type,
				'post_status' => 'publish',
				'posts_per_page' => $limit,
				'ignore_sticky_posts' => true,
				'orderby' => 'rand'
			);

			if( $with_thumbnail_only ) {
				$args['meta_query'][] = array(
					'key' => '_thumbnail_id'
				);
			}

			return new WP_Query( $args );
		}

		/**
		 * Return custom fields in a nice way
		 **/
		function get_post_custom( $post_id ) {
			$custom_fields = get_post_custom( $post_id );
			$return = array();
			if( is_array( $custom_fields ) && count( $custom_fields ) > 0 ) {
				foreach( $custom_fields as $k=>$v ) {
					if( $k[0] != '_' )
						$return[$k] = $v[0];
				}
			}
			return (object)$return;
		}

		/**
		 * Get featured products
		 **/
		function get_featured_products( $limit ) {

			$args = array(
				'post_type' => 'product',
				'post_status' => 'publish',
				'posts_per_page' => $limit,
				'meta_key' => '_featured',
				'meta_value' => 'yes',
			);

			return new WP_Query( $args );

		}

		/**
		 * Get Best Sellers
		 **/
		function get_best_sellers( $limit ) {

			$args = array(
				'post_type' => 'product',
				'post_status' => 'publish',
				'posts_per_page' => $limit,
				'meta_key' => 'total_sales',
				'orderby' => 'meta_value_num',
			);

			return new WP_Query( $args );

		}

		/**
		 * Get top rated products
		 **/
		function get_top_rated_products( $limit, $with_thumbnail_only = false ) {
			$args = array(
				'post_type' => 'product',
				'post_status' => 'publish',
				'posts_per_page' => $limit,
			);

			if( $with_thumbnail_only ) {
				$args['meta_query'][] = array(
					'key' => '_thumbnail_id'
				);
			}

			add_filter('posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses'));

			$products = new WP_Query( $args );

			remove_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );

			return $products;
		}

		/**
		 * Get on sale products
		 **/
		function get_onsale_products( $limit, $with_thumbnail_only = false ) {

			$products_ids_on_sale = wc_get_product_ids_on_sale();

			$args = array(
				'post_type' => 'product',
				'post_status' => 'publish',
				'posts_per_page' => $limit,
				'post__in' => $products_ids_on_sale
			);

			if( $with_thumbnail_only ) {
				$args['meta_query'][] = array(
					'key' => '_thumbnail_id'
				);
			}

			return new WP_Query( $args );
		}

		/**
		 * Get MailChimp forms
		 **/
		function get_mailchimp_forms() {

			$args = array(
				'post_type' => 'mc4wp-form',
				'post_status' => 'publish',
				'posts_per_page' => -1
			);

			return new WP_Query( $args );

		}

		/**
		 * Get WPForms
		 **/
		function get_wpforms() {

			$args = array(
				'post_type' => 'wpforms',
				'post_status' => 'publish',
				'posts_per_page' => -1
			);

			return new WP_Query( $args );

		}

		/**
		 * Get minimum and maximum prices for WooCommerce products
		 **/
		function woo_get_min_max_prices() {
			global $wpdb, $wp_the_query;

			$args       = $wp_the_query->query_vars;
			$tax_query  = isset( $args['tax_query'] ) ? $args['tax_query'] : array();
			$meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();

			if ( ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {
				$tax_query[] = array(
					'taxonomy' => $args['taxonomy'],
					'terms'    => array( $args['term'] ),
					'field'    => 'slug',
				);
			}

			foreach ( $meta_query + $tax_query as $key => $query ) {
				if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
					unset( $meta_query[ $key ] );
				}
			}

			$meta_query = new WP_Meta_Query( $meta_query );
			$tax_query  = new WP_Tax_Query( $tax_query );

			$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
			$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

			$sql  = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} ";
			$sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
			$sql .= " 	WHERE {$wpdb->posts}.post_type IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_post_type', array( 'product' ) ) ) ) . "')
						AND {$wpdb->posts}.post_status = 'publish'
						AND price_meta.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
						AND price_meta.meta_value > '' ";
			$sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

			if ( $search = WC_Query::get_main_search_query_sql() ) {
				$sql .= ' AND ' . $search;
			}

			return $wpdb->get_row( $sql );
		}

	}
