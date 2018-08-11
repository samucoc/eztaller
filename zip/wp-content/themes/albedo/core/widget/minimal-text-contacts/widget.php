<?php

	// Init the widget
	add_action( 'widgets_init', 'wplab_albedo_minimal_text_contacts_widget_register' );

	function wplab_albedo_minimal_text_contacts_widget_register() {
		register_widget( 'wplab_albedo_minimal_text_contacts_widget' );
	}

	class wplab_albedo_minimal_text_contacts_widget extends WP_Widget {

		/**
		 * Widget constructor
		 **/
		function __construct() {
			$widget_ops = array( 'classname' => 'wproto_minimal_text_contacts_widget', 'description' => esc_html__('A widget that displays some text and contact information', 'albedo') );

			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'wproto_minimal_text_contacts_widget' );

			parent::__construct( 'wproto_minimal_text_contacts_widget', esc_html__( '[ALBEDO FOOTER] Minimal: Text and Contact Information', 'albedo' ), $widget_ops, $control_ops );

			add_action( 'wp_enqueue_scripts', array( $this, 'add_styles' ) );

		}

		/**
		 * Add shortcode styles
		**/
		function add_styles() {
			if( is_active_widget( false, false, $this->id_base, true ) ) {
				wp_enqueue_style( 'fw-font-awesome');
				wp_enqueue_style( 'wplab-albedo-widget-minimal_text_contacts-variable', wplab_albedo_utils::locate_uri( '/core/widget/minimal-text-contacts/style_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
			}
		}

		/**
		 * Front-end output
		 **/
		function widget( $args, $instance ) {
			global $wplab_albedo_core;
			echo $args['before_widget']; ?>

		<!-- widget content -->
		<div class="widget-elements">

			<?php if( isset( $instance['free_text'] ) && $instance['free_text'] <> '' ): ?>
			<div class="elem free_text">
				<?php echo nl2br( wp_kses( $instance['free_text'], wp_kses_allowed_html( 'post') ) ); ?>
			</div>
			<?php endif; ?>

			<?php if( isset( $instance['email'] ) && $instance['email'] <> '' ): ?>
			<div class="elem mail">
				<i class="fa fa-envelope"></i> <?php echo wplab_albedo_utils::emailize( $instance['email'] ); ?>
			</div>
			<?php endif; ?>

			<?php if( isset( $instance['phone'] ) && $instance['phone'] <> '' ): ?>
			<div class="elem phone">
				<i class="fa fa-phone"></i> <?php echo wp_kses_post( $instance['phone'] ); ?>
			</div>
			<?php endif; ?>

			<?php if( isset( $instance['display_social_icons'] ) && $instance['display_social_icons'] ): ?>

			<div class="elem share-links">

				<?php foreach( $wplab_albedo_core->cfg['social_profiles'] as $k=>$v ):
					$link_url = isset( $instance[ $k ] ) ? $instance[ $k ] : '';
					$class_name = str_replace( '_', '-', str_replace( '_url', '', $k ) );
					if( $link_url <> '' ):
				?>
				<a rel="nofollow" class="<?php echo esc_attr( $class_name ); ?>" target="_blank" href="<?php echo esc_attr( $link_url ); ?>"><i class="<?php echo esc_attr( $wplab_albedo_core->cfg['social_icons'][ $k ] ); ?>"></i></a>
				<?php endif; endforeach; ?>

				<div class="clearfix"></div>
			</div>

			<?php endif; ?>

		</div>

		<?php echo $args['after_widget'];
		}

		/**
		 * Admin: save widget settings
		 **/
		function update( $new_instance, $old_instance ) {
			global $wplab_albedo_core;
			$instance = $old_instance;

			//Strip tags from title and name to remove HTML
			$instance['free_text'] = $new_instance['free_text'];
			$instance['email'] = $new_instance['email'];
			$instance['phone'] = $new_instance['phone'];
			$instance['display_social_icons'] = isset( $new_instance['display_social_icons'] ) ? absint( $new_instance['display_social_icons'] ) : 0;

			foreach( $wplab_albedo_core->cfg['social_profiles'] as $k=>$v ) {
				$instance[ $k ] = isset( $new_instance[ $k ] ) ? $new_instance[ $k ] : '';
			}

			return $new_instance;
		}

		/**
		 * Admin: widget settings form
		 **/
		function form( $instance ) {
			global $wplab_albedo_core;

			//Set up some default widget settings.
			$defaults = array(
				'free_text' => '',
				'email' => '',
				'phone' => '',
				'display_social_icons' => 0,
			);

			foreach( $wplab_albedo_core->cfg['social_profiles'] as $k=>$v ) {
				$defaults[ $k ] = '';
			}

			$instance = wp_parse_args( (array) $instance, $defaults );

			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'free_text' ) ); ?>"><?php esc_html_e('Free text:', 'albedo'); ?></label>
				<textarea style="width: 97%;" id="<?php echo esc_attr( $this->get_field_id( 'free_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'free_text' ) ); ?>"><?php echo esc_textarea( $instance['free_text'] ); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"><?php esc_html_e('Email:', 'albedo'); ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" value="<?php echo esc_attr( $instance['email'] ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>"><?php esc_html_e('Phone:', 'albedo'); ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'phone' ) ); ?>" value="<?php echo esc_attr( $instance['phone'] ); ?>" />
			</p>
			<p>
				<input type="checkbox" <?php checked( $instance['display_social_icons'], 1 ); ?> name="<?php echo esc_attr( $this->get_field_name( 'display_social_icons' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'display_social_icons' ) ); ?>" value="1" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'display_social_icons' ) ); ?>"><?php esc_html_e('Display Social Icons', 'albedo'); ?></label>
			</p>

			<?php
				foreach( $wplab_albedo_core->cfg['social_profiles'] as $k=>$v ):
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( $k ) ); ?>"><?php echo wp_kses_post( $v ); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_textarea( $instance[ $k ] ); ?>" id="<?php echo esc_attr( $this->get_field_id( $k ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $k ) ); ?>" />
			</p>
			<?php endforeach; ?>

			<?php
		}

	}
