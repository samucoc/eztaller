<?php

	// Init the widget
	add_action( 'widgets_init', 'wplab_albedo_minimal_logo_menu_widget_register' );

	function wplab_albedo_minimal_logo_menu_widget_register() {
		register_widget( 'wplab_albedo_minimal_logo_menu_widget' );
	}

	class wplab_albedo_minimal_logo_menu_widget extends WP_Widget {

		/**
		 * Widget constructor
		 **/
		function __construct() {
			$widget_ops = array( 'classname' => 'wproto_minimal_logo_menu_widget', 'description' => esc_html__('A widget to display minimal footer with logo, menu, short description and GoTop link', 'albedo') );

			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'wproto_minimal_logo_menu_widget' );

			parent::__construct( 'wproto_minimal_logo_menu_widget', esc_html__( '[ALBEDO FOOTER] Minimal: Logo, Menu, Short description and Go Top link', 'albedo' ), $widget_ops, $control_ops );

			add_action( 'wp_enqueue_scripts', array( $this, 'add_styles' ) );
		}

		/**
		 * Add shortcode styles
		**/
		function add_styles() {
			if( is_active_widget( false, false, $this->id_base, true ) ) {
				wp_enqueue_style( 'wplab-albedo-widget-minimal-logo-menu-variable', wplab_albedo_utils::locate_uri( '/core/widget/minimal-logo-menu/style_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
			}
		}

		/**
		 * Front-end output
		 **/
		function widget( $args, $instance ) {
			global $wplab_albedo_core;

			echo $args['before_widget'];
		?>

			<div class="top-widget-elements">

				<?php if( isset( $instance['logo_image_id'] ) && $instance['logo_image_id'] > 0 ): ?>
				<!-- logo -->
				<div class="item item-logo">
					<a href="<?php echo esc_attr( home_url( '/' ) ); ?>">
						<img <?php if( isset( $instance['logo_image_width'] ) && $instance['logo_image_width'] > 0 ):?>width="<?php echo esc_attr( $instance['logo_image_width'] ); ?>"<?php endif; ?> alt="" class="b-lazy" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-lazy-src="<?php echo wp_get_attachment_url( $instance['logo_image_id'] ); ?>" <?php echo isset( $instance['logo_2x_image_id'] ) && $instance['logo_2x_image_id'] > 0 ? 'data-at2x="' . wp_get_attachment_url( $instance['logo_2x_image_id'] ) . '"' : 'data-no-retina'; ?> />
					</a>
				</div>
				<?php endif; ?>

				<?php if( isset( $instance['menu_id'] ) && $instance['menu_id'] <> '' ): ?>
				<!-- Menu -->
				<div class="item item-menu">
					<?php
						wp_nav_menu( array(
							'menu' => $instance['menu_id'],
							'menu_id' => 'footer-minimal-menu',
							'fallback_cb' => false,
							'container' => false
						));
					?>
				</div>
				<?php endif; ?>

				<?php if ( isset( $instance['display_social_icons'] ) && $instance['display_social_icons'] ) : ?>
				<!-- Social Icons -->
				<div class="item social-links">

					<?php foreach( $wplab_albedo_core->cfg['social_profiles'] as $k=>$v ):
						$link_url = isset( $instance[ $k ] ) ? $instance[ $k ] : '';
						$class_name = str_replace( '_', '-', str_replace( '_url', '', $k ) );
						if( $link_url <> '' ):
					?>
					<a rel="nofollow" class="<?php echo esc_attr( $class_name ); ?>" target="_blank" href="<?php echo esc_attr( $link_url ); ?>"><i class="<?php echo esc_attr( $wplab_albedo_core->cfg['social_icons'][ $k ] ); ?>"></i></a>
					<?php endif; endforeach; ?>

				</div>
				<?php endif; ?>

			</div>

			<div class="bottom-widget-elements">

				<?php if ( isset( $instance['description'] ) && $instance['description'] <> '' ) : ?>
				<!-- Description text -->
				<div class="item desc">
					<?php echo wpautop( $instance['description'] ); ?>
				</div>
				<?php endif; ?>

				<?php if( isset( $instance['display_gotop'] ) && filter_var( $instance['display_gotop'], FILTER_VALIDATE_BOOLEAN ) ): ?>
				<!-- Go Top link -->
				<div class="item totop">
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
			global $wplab_albedo_core;
			$instance = $old_instance;

			//Strip tags from title and name to remove HTML
			$instance['logo_image_id'] = isset( $new_instance['logo_image_id'] ) ? absint( $new_instance['logo_image_id'] ) : '';
			$instance['logo_2x_image_id'] = isset( $new_instance['logo_2x_image_id'] ) ? absint( $new_instance['logo_2x_image_id'] ) : '';
			$instance['logo_image_width'] = isset( $new_instance['logo_image_width'] ) ? absint( $new_instance['logo_image_width'] ) : '';
			$instance['description'] = isset( $new_instance['description'] ) ? $new_instance['description'] : '';
			$instance['menu_id'] = isset( $new_instance['menu_id'] ) ? $new_instance['menu_id'] : '';
			$instance['display_gotop'] = isset( $new_instance['display_gotop'] ) ? absint( $new_instance['display_gotop'] ) : 0;
			$instance['display_social_icons'] = isset( $new_instance['display_social_icons'] ) ? absint( $new_instance['display_social_icons'] ) : 0;

			foreach( $wplab_albedo_core->cfg['social_profiles'] as $k=>$v ) {
				$instance[ $k ] = isset( $new_instance[ $k ] ) ? $new_instance[ $k ] : '';
			}

			return $instance;
		}

		/**
		 * Admin: widget settings form
		 **/
		function form( $instance ) {
			global $wplab_albedo_core;

			//Set up some default widget settings.
			$defaults = array(
				'logo_image_id' => '',
				'logo_2x_image_id' => '',
				'logo_image_width' => '',
				'description' => '',
				'menu_id' => '',
				'display_gotop' => 0,
				'display_social_icons' => 0,
			);

			foreach( $wplab_albedo_core->cfg['social_profiles'] as $k=>$v ) {
				$defaults[ $k ] = '';
			}

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
				<?php
					$menus = wp_get_nav_menus();
				?>
				<label for="<?php echo esc_attr( $this->get_field_id( 'menu_id' ) ); ?>"><?php esc_html_e('Display menu:', 'albedo'); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'menu_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'menu_id' ) ); ?>">
					<option><?php esc_html_e( '- Choose -', 'albedo'); ?></option>
					<?php foreach( $menus as $menu ): ?>
					<option <?php selected( $instance['menu_id'], $menu->term_id ); ?> value="<?php echo esc_attr( $menu->slug ); ?>"><?php echo wp_kses_post( $menu->name ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e('Free text:', 'albedo'); ?></label>
				<textarea class="widefat" style="width: 97%; min-height: 200px;" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_textarea( $instance['description'] ); ?></textarea>
			</p>
			<p>
				<input type="checkbox" <?php checked( $instance['display_gotop'], 1 ); ?> name="<?php echo esc_attr( $this->get_field_name( 'display_gotop' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'display_gotop' ) ); ?>" value="1" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'display_gotop' ) ); ?>"><?php esc_html_e('Display Go Top link', 'albedo'); ?></label>
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
