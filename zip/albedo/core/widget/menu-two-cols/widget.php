<?php

	// Init the widget
	add_action( 'widgets_init', 'wplab_albedo_menu_two_cols_widget_register' );

	function wplab_albedo_menu_two_cols_widget_register() {
		register_widget( 'wplab_albedo_menu_two_cols_widget' );
	}

	class wplab_albedo_menu_two_cols_widget extends WP_Widget {

		/**
		 * Widget constructor
		 **/
		function __construct() {
			$widget_ops = array( 'classname' => 'wproto_menu_two_cols_widget', 'description' => esc_html__('A widget that displays chosen menu in two columns', 'albedo') );

			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'wproto_menu_two_cols_widget' );

			parent::__construct( 'wproto_menu_two_cols_widget', esc_html__( '[ALBEDO] Two Columns Menu', 'albedo' ), $widget_ops, $control_ops );
		}

		/**
		 * Front-end output
		 **/
		function widget( $args, $instance ) {

			echo $args['before_widget']; ?>

			<!-- widget title -->
			<?php if ( isset( $instance['title'] ) && $instance['title'] <> '' ) : ?>

				<?php echo $args['before_title']; ?>

					<?php echo apply_filters( 'widget_title', $instance['title'] ); ?>

				<?php echo $args['after_title']; ?>

			<?php endif; ?>

			<!-- widget content -->
				<div class="two-cols-menu">

				<?php if( isset( $instance['menu'] ) && $instance['menu'] <> '' ): ?>

					<?php
						wp_nav_menu( array(
							'menu' => $instance['menu'],
							'fallback_cb' => false,
							'container' => false
						));
					?>

				<?php endif; ?>

				<div class="clearfix"></div>

				</div>

			<?php echo $args['after_widget'];
		}

		/**
		 * Admin: save widget settings
		 **/
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			//Strip tags from title and name to remove HTML
			$instance['title'] = strip_tags( str_replace( '\'', "&#39;", $new_instance['title'] ) );
			$instance['menu'] = isset( $new_instance['menu'] ) ? $new_instance['menu'] : '';

			return $instance;
		}

		/**
		 * Admin: widget settings form
		 **/
		function form( $instance ) {

			//Set up some default widget settings.
			$defaults = array(
				'title' => esc_html__( 'Useful Links', 'albedo' ),
				'menu' => ''
			);

			$instance = wp_parse_args( (array) $instance, $defaults );

			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Widget title:', 'albedo'); ?></label>
				<input type="text" style="width: 97%;" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'menu' ) ); ?>"><?php esc_html_e('Choose menu:', 'albedo'); ?></label>
				<?php
					$theme_menus = get_terms('nav_menu');
				?>
				<select id="<?php echo esc_attr( $this->get_field_id( 'menu' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'menu' ) ); ?>">
					<?php if( count( $theme_menus ) > 0 ): foreach( $theme_menus as $menu ): ?>
					<option <?php selected( $menu->slug, $instance['menu'] ); ?> value="<?php echo esc_attr( $menu->slug ); ?>"><?php echo strip_tags( $menu->name ); ?></option>
					<?php endforeach; endif; ?>
				</select>
			</p>
			<?php
		}

	}
