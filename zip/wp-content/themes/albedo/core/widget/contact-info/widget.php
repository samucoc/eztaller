<?php

	// Init the widget
	add_action( 'widgets_init', 'wplab_albedo_contact_info_widget_register' );

	function wplab_albedo_contact_info_widget_register() {
		register_widget( 'wplab_albedo_contact_info_widget' );
	}

	class wplab_albedo_contact_info_widget extends WP_Widget {

		/**
		 * Widget constructor
		 **/
		function __construct() {
			$widget_ops = array( 'classname' => 'wproto_contact_info_widget', 'description' => esc_html__('A widget that displays contact information and social icons', 'albedo') );

			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'wproto_contact_info_widget' );

			parent::__construct( 'wproto_contact_info_widget', esc_html__( '[ALBEDO] Contact Information', 'albedo' ), $widget_ops, $control_ops );

			add_action( 'wp_enqueue_scripts', array( $this, 'add_styles' ) );

		}

		/**
		 * Add shortcode styles
		**/
		function add_styles() {
			if( is_active_widget( false, false, $this->id_base, true ) ) {
				wp_enqueue_style( 'fw-font-awesome');
				wp_enqueue_style( 'wplab-albedo-widget-contact_info-variable', wplab_albedo_utils::locate_uri( '/core/widget/contact-info/style_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
			}
		}

		/**
		 * Front-end output
		 **/
		function widget( $args, $instance ) {
			global $wplab_albedo_core;
			echo $args['before_widget']; ?>

			<!-- widget title -->
			<?php if ( isset( $instance['title'] ) && $instance['title'] <> '' ) : ?>

				<?php echo $args['before_title']; ?>

					<?php echo apply_filters( 'widget_title', $instance['title'] ); ?>

				<?php echo $args['after_title']; ?>

			<?php endif; ?>

			<!-- widget content -->

			<?php if( isset( $instance['free_text'] ) && $instance['free_text'] <> '' ): ?>
			<div class="content-row free_text">
				<?php echo nl2br( wp_kses( $instance['free_text'], wp_kses_allowed_html( 'post') ) ); ?>
			</div>
			<?php endif; ?>

			<?php if( isset( $instance['address'] ) && $instance['address'] <> '' ): ?>

				<div class="content-row address">
					<?php echo '<span class="row-title">' . wp_kses_post( $instance['address_title'] ) . '</span> <span class="row-text">'; echo nl2br( $instance['address'] ); echo '</span>'; ?>
				</div>

			<?php endif; ?>

			<?php if( isset( $instance['phones'] ) && $instance['phones'] <> '' ): ?>

				<div class="content-row phones">
					<?php echo '<span class="row-title">' . wp_kses_post( $instance['phones_title'] ) . '</span> <span class="row-text">'; echo nl2br( $instance['phones'] ); echo '</span>'; ?>
				</div>

			<?php endif; ?>

			<?php if( isset( $instance['emails'] ) && $instance['emails'] <> '' ): ?>

				<div class="content-row emails">
					<?php echo '<span class="row-title">' . wp_kses_post( $instance['emails_title'] ) . '</span> <span class="row-text">'; echo nl2br( wplab_albedo_utils::emailize( $instance['emails'] ) ); echo '</span>'; ?>
				</div>

			<?php endif; ?>

			<?php if( isset( $instance['display_social_icons'] ) && $instance['display_social_icons'] ): ?>

			<div class="share-links">

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

			<?php echo $args['after_widget'];
		}

		/**
		 * Admin: save widget settings
		 **/
		function update( $new_instance, $old_instance ) {
			global $wplab_albedo_core;
			$instance = $old_instance;

			//Strip tags from title and name to remove HTML
			$instance['title'] = strip_tags( str_replace( '\'', "&#39;", $new_instance['title'] ) );
			$instance['free_text'] = $new_instance['free_text'];
			$instance['phones'] = $new_instance['phones'];
			$instance['phones_title'] = isset( $new_instance['phones_title'] ) ? strip_tags( $new_instance['phones_title'] ) : '';
			$instance['address'] = $new_instance['address'];
			$instance['address_title'] = isset( $new_instance['address_title'] ) ? strip_tags( $new_instance['address_title'] ) : '';
			$instance['emails'] = $new_instance['emails'];
			$instance['emails_title'] = isset( $new_instance['emails_title'] ) ? strip_tags( $new_instance['emails_title'] ) : '';
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
				'title' => esc_html__( 'Contact Us', 'albedo' ),
				'free_text' => '',
				'phones' => '',
				'phones_title' => esc_html__( 'Phone:', 'albedo' ),
				'address' => '',
				'address_title' => esc_html__( 'Address:', 'albedo' ),
				'emails' => '',
				'emails_title' => esc_html__( 'Email:', 'albedo' ),
				'display_social_icons' => 0,
			);

			foreach( $wplab_albedo_core->cfg['social_profiles'] as $k=>$v ) {
				$defaults[ $k ] = '';
			}

			$instance = wp_parse_args( (array) $instance, $defaults );

			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Widget title:', 'albedo'); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'address_title' ) ); ?>"><?php esc_html_e('Address title:', 'albedo'); ?></label>
				<input value="<?php echo esc_textarea( $instance['address_title'] ); ?>" type="text" id="<?php echo esc_attr( $this->get_field_id( 'address_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'address_title' ) ); ?>" class="widefat" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>"><?php esc_html_e('Address:', 'albedo'); ?></label>
				<textarea style="width: 97%;" id="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>"><?php echo esc_textarea( $instance['address'] ); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'phones_title' ) ); ?>"><?php esc_html_e('Phones title:', 'albedo'); ?></label>
				<input value="<?php echo esc_textarea( $instance['phones_title'] ); ?>" type="text" id="<?php echo esc_attr( $this->get_field_id( 'phones_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'phones_title' ) ); ?>" class="widefat" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'phones' ) ); ?>"><?php esc_html_e('Phone:', 'albedo'); ?></label>
				<textarea style="width: 97%;" id="<?php echo esc_attr( $this->get_field_id( 'phones' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'phones' ) ); ?>"><?php echo esc_textarea( $instance['phones'] ); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'emails_title' ) ); ?>"><?php esc_html_e('Email title:', 'albedo'); ?></label>
				<input value="<?php echo esc_textarea( $instance['emails_title'] ); ?>" type="text" id="<?php echo esc_attr( $this->get_field_id( 'emails_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'emails_title' ) ); ?>" class="widefat" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'emails' ) ); ?>"><?php esc_html_e('Email:', 'albedo'); ?></label>
				<textarea style="width: 97%;" id="<?php echo esc_attr( $this->get_field_id( 'emails' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'emails' ) ); ?>"><?php echo esc_textarea( $instance['emails'] ); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'free_text' ) ); ?>"><?php esc_html_e('Free text:', 'albedo'); ?></label>
				<textarea style="width: 97%;" id="<?php echo esc_attr( $this->get_field_id( 'free_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'free_text' ) ); ?>"><?php echo esc_textarea( $instance['free_text'] ); ?></textarea>
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
