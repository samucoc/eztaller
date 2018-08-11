<?php
/**
 * WooCommerce front-end controller
 **/
class wplab_albedo_woocommerce_controller {

	function __construct() {

		if( wplab_albedo_utils::is_woocommerce() ) {

			// Remove WooCommerce default styles
			add_filter( 'woocommerce_enqueue_styles', '__return_false' );

			// override breadcrumbs
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
			add_filter( 'woocommerce_show_page_title', '__return_false' );

			// Override search form
			add_filter( 'get_product_search_form', array( $this, 'custom_woo_search' ) );

			// Ordering boxes
			add_action( 'init', array( $this, 'setup_woocommerce' ), 1 );
			// custom posts per page
			add_filter( 'loop_shop_per_page', array( $this, 'custom_products_per_page' ) );

			// custom number of columns
			// add_filter( 'loop_shop_columns', array( $this, 'custom_loop_columns') );

			// Number of related products
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_number' ) );

			// Update cart totals via AJAX
			add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'update_header_cart_totals' ) );

			// move add to cart button over product thumbnail
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );

			// change default HTML markup for products list
			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 10 );

			// move rating on single product page
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 4 );

			// move tabs on single product
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
			add_action( 'wplab_albedo_single_product_footer', 'woocommerce_upsell_display', 15 );
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			add_action( 'wplab_albedo_single_product_footer', 'woocommerce_output_related_products', 10 );

		}

	}

	/**
	 * Disable ordering boxes
	 **/
	function setup_woocommerce() {

		if( function_exists('fw_get_db_customizer_option') && ! filter_var( fw_get_db_customizer_option( 'woo_ordering_boxes' ), FILTER_VALIDATE_BOOLEAN ) ) {
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
			remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
		}

	}

	/**
	 * Override WooSearch Form
	 **/
	function custom_woo_search() {
		ob_start();
		?>
		<form class="search-form" action="<?php echo get_site_url(); ?>" method="get">
			<input type="hidden" name="post_type" value="product" />
			<input type="search" name="s" value="" placeholder="<?php esc_html_e( 'Type and hit enter...', 'albedo' ); ?>" />
		</form>
		<?php
		return ob_get_clean();
	}

	/**
	 * Custom posts per page
	 **/
	function custom_products_per_page() {
		if( function_exists('fw_get_db_customizer_option') ) {
			return absint( fw_get_db_customizer_option( 'woo_posts_count' ) );
		}
	}

	/**
	 * Change number of columns for products
	 **/
	function custom_loop_columns() {
		if( function_exists('fw_get_db_customizer_option') ) {
			return absint( fw_get_db_customizer_option( 'woo_products_per_row' ) );
		}
	}

	/**
	 * Update header cart totals
	 **/
	function update_header_cart_totals( $fragments ) {

		$fragments['.header-cart-toggle span'] = '<span class="count">' . WC()->cart->get_cart_contents_count() . '</span>';

		return $fragments;
	}

	/**
	 * Related products number
	 **/
	function related_products_number( $args ) {
		if( wplab_albedo_utils::is_unyson() ) {
			$args['posts_per_page'] = absint( fw_get_db_customizer_option( 'woo_related_products_number' ) );
			//$args['columns'] = absint( fw_get_db_customizer_option( 'woo_related_products_cols' ) );
		}
		return $args;
	}

}
