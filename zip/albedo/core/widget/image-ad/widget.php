<?php

	// Init the widget
	add_action( 'widgets_init', 'wplab_albedo_image_ad_widget_register' );

	function wplab_albedo_image_ad_widget_register() {
		register_widget( 'wplab_albedo_image_ad_widget' );
	}

	class wplab_albedo_image_ad_widget extends WP_Widget {

		/**
		 * Widget constructor
		 **/
		function __construct() {
			$widget_ops = array( 'classname' => 'wproto_image_ad_widget', 'description' => esc_html__('A widget that displays a banner', 'albedo') );

			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'wproto_image_ad_widget' );

			parent::__construct( 'wproto_image_ad_widget', esc_html__( '[ALBEDO] Ads', 'albedo' ), $widget_ops, $control_ops );
		}

		/**
		 * Front-end output
		 **/
		function widget( $args, $instance ) {
			global $wplab_albedo_core;

			echo $args['before_widget'];
		?>

			<?php if ( isset( $instance['link_url'] ) && $instance['link_url'] <> '' ) : ?>
			<a href="<?php echo esc_attr( $instance['link_url'] ); ?>">
			<?php endif; ?>

			<?php if( isset( $instance['banner_image_id'] ) && $instance['banner_image_id'] > 0 ): ?>
			<img alt="" class="b-lazy" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-lazy-src="<?php echo wp_get_attachment_url( $instance['banner_image_id'] ); ?>" />
			<?php endif; ?>

			<?php if ( isset( $instance['link_url'] ) && $instance['link_url'] <> '' ) : ?>
			</a>
			<?php endif; ?>

			<?php echo $args['after_widget'];
		}

		/**
		 * Admin: save widget settings
		 **/
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			//Strip tags from title and name to remove HTML
			$instance['banner_image_id'] = isset( $new_instance['banner_image_id'] ) ? absint( $new_instance['banner_image_id'] ) : '';
			$instance['link_url'] = isset( $new_instance['link_url'] ) ? $new_instance['link_url'] : '';

			return $instance;
		}

		/**
		 * Admin: widget settings form
		 **/
		function form( $instance ) {

			//Set up some default widget settings.
			$defaults = array(
				'banner_image_id' => '',
				'link_url' => '',
			);

			$instance = wp_parse_args( (array) $instance, $defaults );
			?>

			<?php
				$field_id = 'banner';
			?>
			<p>
				<label><?php esc_html_e('Banner image', 'albedo'); ?>:</label><br />

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
				<label for="<?php echo esc_attr( $this->get_field_id( 'link_url' ) ); ?>"><?php esc_html_e('Link URL:', 'albedo'); ?></label>
				<input type="text" class="widefat" value="<?php echo esc_textarea( $instance['link_url'] ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'link_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link_url' ) ); ?>" />
			</p>

			<?php
		}

	}
