<?php

	// Init the widget
	add_action( 'widgets_init', 'wplab_albedo_cta_widget_register' );

	function wplab_albedo_cta_widget_register() {
		register_widget( 'wplab_albedo_cta_widget' );
	}

	class wplab_albedo_cta_widget extends WP_Widget {

		/**
		 * Widget constructor
		 **/
		function __construct() {
			$widget_ops = array( 'classname' => 'wproto_cta_widget', 'description' => esc_html__('A widget that displays a Call To Action', 'albedo') );

			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'wproto_cta_widget' );

			parent::__construct( 'wproto_cta_widget', esc_html__( '[ALBEDO FOOTER] Call To Action', 'albedo' ), $widget_ops, $control_ops );

			add_action( 'wp_enqueue_scripts', array( $this, 'add_styles' ) );

		}

		/**
		 * Add shortcode styles
		**/
		function add_styles() {
			if( is_active_widget( false, false, $this->id_base, true ) ) {
				wp_enqueue_style( 'fw-font-awesome');
				wp_enqueue_style( 'wplab-albedo-widget-cta-variable', wplab_albedo_utils::locate_uri( '/core/widget/cta/style_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
			}
		}

		/**
		 * Front-end output
		 **/
		function widget( $args, $instance ) {
			global $wplab_albedo_core;
			echo $args['before_widget']; ?>

			<?php if ( isset( $instance['widget_style'] ) && $instance['widget_style'] == 'centered' ) : ?>
				<div class="centered">
			<?php endif; ?>

			<!-- widget title -->
			<?php if ( isset( $instance['title'] ) && $instance['title'] <> '' ) : ?>

				<?php echo $args['before_title']; ?>

					<?php echo nl2br( $instance['title'] ); ?>

				<?php echo $args['after_title']; ?>

			<?php endif; ?>

			<!-- widget content -->
			<?php if( isset( $instance['button_text'] ) && $instance['button_text'] <> '' ): ?>
				<a target="_blank" href="<?php echo isset( $instance['button_url'] ) ? esc_attr( $instance['button_url'] ) : ''; ?>" class="button style-<?php echo esc_attr( $instance['button_style'] ); ?>"><?php echo wp_kses_post( $instance['button_text'] ); ?></a>
			<?php endif; ?>

			<?php if( isset( $instance['free_text'] ) && $instance['free_text'] <> '' ): ?>
			<div class="content-row free_text">
				<?php echo nl2br( wp_kses( $instance['free_text'], wp_kses_allowed_html( 'post') ) ); ?>
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

			<?php if ( isset( $instance['widget_style'] ) && $instance['widget_style'] == 'centered' ) : ?>
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
			$instance['button_url'] = $new_instance['button_url'];
			$instance['button_text'] = $new_instance['button_text'];
			$instance['button_style'] = $new_instance['button_style'];
			$instance['free_text'] = $new_instance['free_text'];
			$instance['widget_style'] = $new_instance['widget_style'];
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
				'title' => esc_html__( 'Call To Action', 'albedo' ),
				'button_url' => '',
				'button_text' => '',
				'button_style' => 'green',
				'free_text' => '',
				'widget_style' => 'centered',
				'display_social_icons' => 0,
			);

			foreach( $wplab_albedo_core->cfg['social_profiles'] as $k=>$v ) {
				$defaults[ $k ] = '';
			}

			$instance = wp_parse_args( (array) $instance, $defaults );

			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Call to action text:', 'albedo'); ?></label>
				<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"><?php echo wp_kses_post( $instance['title'] ); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>"><?php esc_html_e('Button URL:', 'albedo'); ?></label>
				<input value="<?php echo esc_textarea( $instance['button_url'] ); ?>" type="text" id="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_url' ) ); ?>" class="widefat" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><?php esc_html_e('Button text:', 'albedo'); ?></label>
				<input value="<?php echo esc_textarea( $instance['button_text'] ); ?>" type="text" id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" class="widefat" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'button_style' ) ); ?>"><?php esc_html_e('Button style:', 'albedo'); ?></label>
				<select name="<?php echo esc_attr( $this->get_field_name( 'button_style' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'button_style' ) ); ?>" class="widefat">

					<?php foreach( $wplab_albedo_core->cfg['button_styles'] as $_kev => $_value ): ?>
						<optgroup label="<?php echo esc_attr( $_value['attr']['label'] ); ?>">
							<?php if( isset( $_value['choices'] ) && is_array( $_value['choices'] ) ): foreach( $_value['choices'] as $_k=>$_v ): ?>
								<option <?php selected( $instance['button_style'], $_k ); ?> value="<?php echo esc_attr( $_k ); ?>"><?php echo wp_kses_post( $_v ); ?></option>
							<?php endforeach; endif; ?>
						</optgroup>
					<?php endforeach; ?>

				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'free_text' ) ); ?>"><?php esc_html_e('Free text:', 'albedo'); ?></label>
				<textarea style="width: 97%;" id="<?php echo esc_attr( $this->get_field_id( 'free_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'free_text' ) ); ?>"><?php echo esc_textarea( $instance['free_text'] ); ?></textarea>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'widget_style' ) ); ?>"><?php esc_html_e('Widget style:', 'albedo'); ?></label>
				<select name="<?php echo esc_attr( $this->get_field_name( 'widget_style' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'widget_style' ) ); ?>" class="widefat">
					<option <?php selected( $instance['widget_style'], 'default' ); ?> value="default"><?php esc_html_e( 'Default', 'albedo' ); ?></option>
					<option <?php selected( $instance['widget_style'], 'centered' ); ?> value="centered"><?php esc_html_e( 'Centered', 'albedo' ); ?></option>
				</select>
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
