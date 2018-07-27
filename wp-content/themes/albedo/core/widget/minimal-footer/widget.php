<?php

	// Init the widget
	add_action( 'widgets_init', 'wplab_albedo_minimal_footer_widget_register' );

	function wplab_albedo_minimal_footer_widget_register() {
		register_widget( 'wplab_albedo_minimal_footer_widget' );
	}

	class wplab_albedo_minimal_footer_widget extends WP_Widget {

		/**
		 * Widget constructor
		 **/
		function __construct() {
			$widget_ops = array( 'classname' => 'wproto_minimal_footer_widget', 'description' => esc_html__('A widget to display minimal footer with logo, short description and GoTop link', 'albedo') );

			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'wproto_minimal_footer_widget' );

			parent::__construct( 'wproto_minimal_footer_widget', esc_html__( '[ALBEDO FOOTER] Minimal: Logo, Short description and Go Top link', 'albedo' ), $widget_ops, $control_ops );

			add_action( 'wp_enqueue_scripts', array( $this, 'add_styles' ) );
		}

		/**
		 * Add shortcode styles
		**/
		function add_styles() {
			if( is_active_widget( false, false, $this->id_base, true ) ) {
				wp_enqueue_style( 'wplab-albedo-widget-minimal-footer-variable', wplab_albedo_utils::locate_uri( '/core/widget/minimal-footer/style_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
			}
		}

		/**
		 * Front-end output
		 **/
		function widget( $args, $instance ) {
			global $wplab_albedo_core;

			echo $args['before_widget'];
		?>

			<div class="widget-elements">

				<div class="elem logo">
					<?php if( isset( $instance['logo_image_id'] ) && $instance['logo_image_id'] > 0 ): ?>
					<img <?php if( isset( $instance['logo_image_width'] ) && $instance['logo_image_width'] > 0 ):?>width="<?php echo esc_attr( $instance['logo_image_width'] ); ?>"<?php endif; ?> alt="" class="b-lazy" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-lazy-src="<?php echo wp_get_attachment_url( $instance['logo_image_id'] ); ?>" <?php echo isset( $instance['logo_2x_image_id'] ) && $instance['logo_2x_image_id'] > 0 ? 'data-at2x="' . wp_get_attachment_url( $instance['logo_2x_image_id'] ) . '"' : 'data-no-retina'; ?> />
					<?php endif; ?>
				</div>

				<?php if ( isset( $instance['description'] ) && $instance['description'] <> '' ) : ?>
				<div class="elem desc">
					<?php echo wpautop( $instance['description'] ); ?>
				</div>
				<?php endif; ?>

				<?php if( isset( $instance['display_gotop'] ) && filter_var( $instance['display_gotop'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<div class="elem totop">
					<a href="javascript:;" class="gotop-link"><?php esc_html_e( 'Back to top', 'albedo'); ?></a>
				</div>
				<?php endif; ?>

			</div>

			<?php echo $args['after_widget'];
		}

		/**
		 * Admin: save widget settings
		 **/
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			//Strip tags from title and name to remove HTML
			$instance['logo_image_id'] = isset( $new_instance['logo_image_id'] ) ? absint( $new_instance['logo_image_id'] ) : '';
			$instance['logo_2x_image_id'] = isset( $new_instance['logo_2x_image_id'] ) ? absint( $new_instance['logo_2x_image_id'] ) : '';
			$instance['logo_image_width'] = isset( $new_instance['logo_image_width'] ) ? absint( $new_instance['logo_image_width'] ) : '';
			$instance['description'] = isset( $new_instance['description'] ) ? $new_instance['description'] : '';
			$instance['display_gotop'] = isset( $new_instance['display_gotop'] ) ? absint( $new_instance['display_gotop'] ) : 0;

			return $instance;
		}

		/**
		 * Admin: widget settings form
		 **/
		function form( $instance ) {

			//Set up some default widget settings.
			$defaults = array(
				'logo_image_id' => '',
				'logo_2x_image_id' => '',
				'logo_image_width' => '',
				'description' => '',
				'display_gotop' => 0,
			);

			$instance = wp_parse_args( (array) $instance, $defaults );
			?>

			<?php
				$field_id = 'logo';
			?>
			<p>
				<label><?php esc_html_e('Logo image', 'albedo'); ?>:</label><br />

				<table class="wproto-media-uploader-table">
					<tr>
						<td>
							<a href="javascript:;" class="button button-primary wplab_albedo_media_upload"><?php esc_html_e('Upload', 'albedo'); ?></a>
						</td>
						<td>
							<a href="javascript:;" class="button wplab_albedo_media_remove"><?php esc_html_e('Remove', 'albedo'); ?></a>
						</td>
						<td class="img">
							<img class="wplab_albedo_media_image" src="<?php echo isset( $instance[ $field_id . '_image_id'] ) ? wp_get_attachment_thumb_url( $instance[ $field_id . '_image_id'] ) : ''; ?>" />
							<input type="hidden" class="wplab_albedo_media_id" name="<?php echo esc_attr( $this->get_field_name( $field_id . '_image_id' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( $field_id . '_image_id' ) ); ?>" value="<?php echo isset( $instance[ $field_id . '_image_id' ] ) ? esc_attr( $instance[ $field_id . '_image_id' ] ) : ''; ?>" />
						</td>
					</tr>
				</table>

			</p>
			<?php
				$field_id = 'logo_2x';
			?>
			<p>
				<label><?php esc_html_e('Logo image for Retina displays', 'albedo'); ?>:</label><br />

				<table class="wproto-media-uploader-table">
					<tr>
						<td>
							<a href="javascript:;" class="button button-primary wplab_albedo_media_upload"><?php esc_html_e('Upload', 'albedo'); ?></a>
						</td>
						<td>
							<a href="javascript:;" class="button wplab_albedo_media_remove"><?php esc_html_e('Remove', 'albedo'); ?></a>
						</td>
						<td class="img">
							<img class="wplab_albedo_media_image" src="<?php echo isset( $instance[ $field_id . '_image_id'] ) ? wp_get_attachment_thumb_url( $instance[ $field_id . '_image_id'] ) : ''; ?>" />
							<input type="hidden" class="wplab_albedo_media_id" name="<?php echo esc_attr( $this->get_field_name( $field_id . '_image_id' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( $field_id . '_image_id' ) ); ?>" value="<?php echo isset( $instance[ $field_id . '_image_id' ] ) ? esc_attr( $instance[ $field_id . '_image_id' ] ) : ''; ?>" />
						</td>
					</tr>
				</table>

			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'logo_image_width' ) ); ?>"><?php esc_html_e('Logo width:', 'albedo'); ?></label>
				<input type="text" class="widefat" value="<?php echo esc_textarea( $instance['logo_image_width'] ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'logo_image_width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'logo_image_width' ) ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e('Free text:', 'albedo'); ?></label>
				<textarea class="widefat" style="width: 97%; min-height: 200px;" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_textarea( $instance['description'] ); ?></textarea>
			</p>
			<p>
				<input type="checkbox" <?php checked( $instance['display_gotop'], 1 ); ?> name="<?php echo esc_attr( $this->get_field_name( 'display_gotop' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'display_gotop' ) ); ?>" value="1" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'display_gotop' ) ); ?>"><?php esc_html_e('Display Go Top link', 'albedo'); ?></label>
			</p>
			<?php
		}

	}
