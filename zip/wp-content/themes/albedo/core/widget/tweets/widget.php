<?php

	// Init the widget
	add_action( 'widgets_init', 'wplab_albedo_tweets_widget_register' );

	function wplab_albedo_tweets_widget_register() {
		register_widget( 'wplab_albedo_tweets_widget' );
	}

	class wplab_albedo_tweets_widget extends WP_Widget {

		/**
		 * Widget constructor
		 **/
		function __construct() {
			$widget_ops = array( 'classname' => 'wproto_tweets_widget', 'description' => esc_html__('A widget that displays your Twitter Feed', 'albedo') );

			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'wproto_tweets_widget' );

			parent::__construct( 'wproto_tweets_widget', esc_html__( '[ALBEDO] Latest Tweets', 'albedo' ), $widget_ops, $control_ops );

			add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts_styles') );

		}

		/**
		 * Add shortcode styles
		**/
		function add_scripts_styles() {
			if( is_active_widget( false, false, $this->id_base, true ) ) {
				wp_enqueue_style( 'fw-font-awesome');
				wp_enqueue_style( 'wplab-albedo-widget-tweets-variable', wplab_albedo_utils::locate_uri( '/core/widget/tweets/style_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
				wp_enqueue_script( 'wplab-albedo-widget-tweets', wplab_albedo_utils::locate_uri( '/core/widget/tweets/scripts.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
			}
		}

		/**
		 * Front-end output
		 **/
		function widget( $args, $instance ) {
			global $wplab_albedo_core;

			if( wplab_albedo_utils::is_unyson() ):
			echo $args['before_widget'];
		?>

			<!-- widget title -->
			<?php if ( isset( $instance['title'] ) && $instance['title'] <> '' ) : ?>

				<?php echo $args['before_title']; ?>

					<?php echo apply_filters( 'widget_title', $instance['title'] ); ?>

				<?php echo $args['after_title']; ?>

			<?php endif; ?>

			<!-- widget content -->

			<div class="tweets-block" data-count="<?php echo esc_attr( $instance['count'] ); ?>"><i class="fa fa-twitter"></i> <?php esc_html_e( 'Loading latest tweets...', 'albedo' ); ?></div>

			<?php echo $args['after_widget'];
			endif;
		}

		/**
		 * Admin: save widget settings
		 **/
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			//Strip tags from title and name to remove HTML
			$instance['title'] = strip_tags( str_replace( '\'', "&#39;", $new_instance['title'] ) );
			$instance['count'] = isset( $new_instance['count'] ) ? absint( $new_instance['count'] ) : 3;

			return $instance;
		}

		/**
		 * Admin: widget settings form
		 **/
		function form( $instance ) {

			//Set up some default widget settings.
			$defaults = array(
				'title' => esc_html__( 'Twitter Feed', 'albedo' ),
				'count' => 3,
			);

			$instance = wp_parse_args( (array) $instance, $defaults );

			?>
			<p>
				<?php printf( wp_kses_post( __('Twitter API can be configured on <a href="%s" target="_blank">Unyson Social Extension Settings Page</a>.', 'albedo' ) ), admin_url('admin.php?page=fw-extensions&sub-page=extension&extension=social') ); ?>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Widget title:', 'albedo'); ?></label>
				<input type="text" style="width: 97%;" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e('Tweets count:', 'albedo'); ?></label>
				<select name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" class="widefat">
					<?php for( $i=1; $i<11; $i++ ): ?>
					<option <?php echo $instance['count'] == $i ? 'selected="selected"' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
				</select>
			</p>

			<?php
		}

	}
