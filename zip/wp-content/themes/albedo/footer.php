<?php
/**
 * Footer template
 **/
global $wplab_albedo_core;

/** check if footer widgets & bottom bar are enabled **/
$footer_widgets = false;
$bottom_bar = true;

/** define variables for footer effects **/
$footer_parallax = $footer_media_effect = $footer_css_classes = $footer_attributes = array();
$video_parallax = $particles = false;

if( wplab_albedo_utils::is_unyson() ) {
	$footer_widgets = filter_var( fw_get_db_customizer_option( 'footer_widgets/enabled', $wplab_albedo_core->default_options['footer_widgets']), FILTER_VALIDATE_BOOLEAN );
	$bottom_bar = filter_var( fw_get_db_customizer_option( 'footer_bar/enabled', $wplab_albedo_core->default_options['footer_bar']), FILTER_VALIDATE_BOOLEAN );

	/** get footer effects from options **/
	$footer_parallax = fw_get_db_customizer_option( 'footer_parallax_effect', $wplab_albedo_core->default_options['footer_parallax_effect']);

	/** standard parallax effect **/
	if( $footer_parallax['effect'] == 'parallax' ) {
		$parallax_speed = fw_get_db_customizer_option( 'footer_parallax_effect/parallax/parallax_speed', $wplab_albedo_core->default_options['footer_parallax_effect_parallax_speed']);
		$footer_css_classes[] = 'parallax-section';
		$footer_attributes[] = 'data-stellar-background-ratio="' . esc_attr( $parallax_speed ) . '"';
	}

	/** mouse parallax effect **/
	elseif( $footer_parallax['effect'] == 'mouse_parallax' ) {
		$footer_css_classes[] = 'parallax-js-section';
		$footer_css_classes[] = 'no-bg-image';
	}

	/** media effects **/
	$footer_media_effect = fw_get_db_customizer_option( 'footer_media_effect', $wplab_albedo_core->default_options['footer_media_effect']);

	/** video background **/
	if( $footer_media_effect['effect'] == 'video' ) {
		$footer_css_classes[] = 'video-bg-section';
		$_video_parallax_speed = fw_get_db_customizer_option( 'footer_media_effect/video/video_parallax_speed', $wplab_albedo_core->default_options['footer_videobg_parallax_speed']);
		if( $_video_parallax_speed <> '' ) {
			$footer_css_classes[] = 'video-parallax';
			$video_parallax = true;
		}
	}

	/** particle groud effect **/
	elseif( $footer_media_effect['effect'] == 'particleground' ) {
		$footer_css_classes[] = 'particle-ground-section';
		$footer_attributes[] = 'data-dot-color="' . esc_attr( fw_get_db_customizer_option( 'footer_media_effect/particleground/dot_color', $wplab_albedo_core->default_options['footer_particleground_dot_color']) ) . '"';
		$footer_attributes[] = 'data-line-color="' . esc_attr( fw_get_db_customizer_option( 'footer_media_effect/particleground/line_color', $wplab_albedo_core->default_options['footer_particleground_line_color']) ) . '"';
		$footer_attributes[] = 'data-particle-radius="' . esc_attr( fw_get_db_customizer_option( 'footer_media_effect/particleground/particle_radius', $wplab_albedo_core->default_options['footer_particleground_particle_radius']) ) . '"';
		$footer_attributes[] = 'data-line-width="' . esc_attr( fw_get_db_customizer_option( 'footer_media_effect/particleground/line_width', $wplab_albedo_core->default_options['footer_particleground_line_width']) ) . '"';
		$footer_attributes[] = 'data-curved-lines="' . esc_attr( fw_get_db_customizer_option( 'footer_media_effect/particleground/curved_lines', $wplab_albedo_core->default_options['footer_particleground_curved_lines']) ) . '"';
		$footer_attributes[] = 'data-parallax="' . esc_attr( fw_get_db_customizer_option( 'footer_media_effect/particleground/parallax', $wplab_albedo_core->default_options['footer_particleground_parallax']) ) . '"';
		$footer_attributes[] = 'data-parallax-multiplier="' . esc_attr( fw_get_db_customizer_option( 'footer_media_effect/particleground/parallax_multiplier', $wplab_albedo_core->default_options['footer_particleground_parallax_multiplier']) ) . '"';
		$footer_attributes[] = 'data-proximity="' . esc_attr( fw_get_db_customizer_option( 'footer_media_effect/particleground/proximity', $wplab_albedo_core->default_options['footer_particleground_proximity']) ) . '"';
		$footer_attributes[] = 'data-min-speed-x="' . esc_attr( fw_get_db_customizer_option( 'footer_media_effect/particleground/min_speed_x', $wplab_albedo_core->default_options['footer_particleground_min_speed_x']) ) . '"';
		$footer_attributes[] = 'data-max-speed-x="' . esc_attr( fw_get_db_customizer_option( 'footer_media_effect/particleground/max_speed_x', $wplab_albedo_core->default_options['footer_particleground_max_speed_x']) ) . '"';
		$footer_attributes[] = 'data-min-speed-y="' . esc_attr( fw_get_db_customizer_option( 'footer_media_effect/particleground/min_speed_x', $wplab_albedo_core->default_options['footer_particleground_min_speed_y']) ) . '"';
		$footer_attributes[] = 'data-max-speed-y="' . esc_attr( fw_get_db_customizer_option( 'footer_media_effect/particleground/max_speed_x', $wplab_albedo_core->default_options['footer_particleground_max_speed_y']) ) . '"';
		$footer_attributes[] = 'data-direction-x="' . esc_attr( fw_get_db_customizer_option( 'footer_media_effect/particleground/direction_x', $wplab_albedo_core->default_options['footer_particleground_direction_x']) ) . '"';
		$footer_attributes[] = 'data-direction-y="' . esc_attr( fw_get_db_customizer_option( 'footer_media_effect/particleground/direction_y', $wplab_albedo_core->default_options['footer_particleground_direction_y']) ) . '"';
		$footer_attributes[] = 'data-destiny="' . esc_attr( fw_get_db_customizer_option( 'footer_media_effect/particleground/destiny', $wplab_albedo_core->default_options['footer_particleground_destiny']) ) . '"';
	}

	/** particles effect **/
	elseif( $footer_media_effect['effect'] == 'particles' ) {
		wplab_albedo_front::generate_footer_particles_script();
		$particles = true;
	}

}
?>

<footer id="footer"<?php echo implode( ' ', $footer_attributes ); ?> class="<?php echo implode( ' ', $footer_css_classes ); ?>">

	<?php if( wplab_albedo_utils::is_unyson() && isset( $footer_parallax['effect'] ) && $footer_parallax['effect'] == 'mouse_parallax' ): ?>
	<!--
		Mouse Parallax Scene
	-->
	<?php
		$mouse_parallax_img_src = fw_get_db_customizer_option( 'footer_bg_image_src');
		if( isset( $mouse_parallax_img_src['data']['icon'] ) && $mouse_parallax_img_src['data']['icon'] <> '' ):
	?>
	<ul class="parallax-scene"
		data-invert-x="<?php echo filter_var( fw_get_db_customizer_option( 'footer_parallax_effect/mouse_parallax/invert_x', $wplab_albedo_core->default_options['footer_mouse_parallax_invert_x']), FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false'; ?>"
		data-invert-y="<?php echo filter_var( fw_get_db_customizer_option( 'footer_parallax_effect/mouse_parallax/invert_y', $wplab_albedo_core->default_options['footer_mouse_parallax_invert_y']), FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false'; ?>"
		data-limit-x="<?php echo esc_attr( fw_get_db_customizer_option( 'footer_parallax_effect/mouse_parallax/limit_x', $wplab_albedo_core->default_options['footer_mouse_parallax_limit_x']) ); ?>"
		data-limit-y="<?php echo esc_attr( fw_get_db_customizer_option( 'footer_parallax_effect/mouse_parallax/limit_y', $wplab_albedo_core->default_options['footer_mouse_parallax_limit_y']) ); ?>"
		data-scalar-x="<?php echo esc_attr( fw_get_db_customizer_option( 'footer_parallax_effect/mouse_parallax/scalar_x', $wplab_albedo_core->default_options['footer_mouse_parallax_scalar_x']) ); ?>"
		data-scalar-y="<?php echo esc_attr( fw_get_db_customizer_option( 'footer_parallax_effect/mouse_parallax/scalar_y', $wplab_albedo_core->default_options['footer_mouse_parallax_scalar_y']) ); ?>"
		data-friction-x="<?php echo esc_attr( fw_get_db_customizer_option( 'footer_parallax_effect/mouse_parallax/friction_x', $wplab_albedo_core->default_options['footer_mouse_parallax_friction_x']) ); ?>"
		data-friction-y="<?php echo esc_attr( fw_get_db_customizer_option( 'footer_parallax_effect/mouse_parallax/friction_y', $wplab_albedo_core->default_options['footer_mouse_parallax_friction_y']) ); ?>"
		data-origin-x="<?php echo esc_attr( fw_get_db_customizer_option( 'footer_parallax_effect/mouse_parallax/origin_x', $wplab_albedo_core->default_options['footer_mouse_parallax_origin_x']) ); ?>"
		data-origin-y="<?php echo esc_attr( fw_get_db_customizer_option( 'footer_parallax_effect/mouse_parallax/origin_y', $wplab_albedo_core->default_options['footer_mouse_parallax_origin_y']) ); ?>">
		<li style="background-image: url(<?php echo esc_attr( $mouse_parallax_img_src['data']['icon'] ); ?>);" class="layer layer-bg" data-depth="<?php echo esc_attr( fw_get_db_customizer_option( 'footer_parallax_effect/mouse_parallax/depth', $wplab_albedo_core->default_options['footer_mouse_parallax_depth']) ); ?>"><div></div></li>
	</ul>
	<?php endif; endif; ?>

	<?php if( wplab_albedo_utils::is_unyson() && isset( $footer_media_effect['effect'] ) && $footer_media_effect['effect'] == 'video' ): ?>
	<!--
		Footer Video BG Effect markup
	-->
	<?php
		$_video_params = array(
			'videoURL' => esc_attr( fw_get_db_customizer_option( 'footer_media_effect/video/video', $wplab_albedo_core->default_options['footer_videobg_url']) ),
			'containment' => '#footer-video',
			'autoPlay' => 'true',
			'mute' => esc_attr( fw_get_db_customizer_option( 'footer_media_effect/video/video_mute', $wplab_albedo_core->default_options['footer_videobg_video_mute']) ),
			'showControls' => 'false',
			'quality' => 'hd720',
			'loop' => 'true',
			'showYTLogo' => 'false'
		);

		$video_fallback_url = fw_get_db_customizer_option( 'footer_media_effect/video/video_fallback_image');
		if( isset( $video_fallback_url['url'] ) ) {
			$_video_params['mobileFallbackImage'] = $video_fallback_url['url'];
		}

	?>
	<div class="video-bg" id="footer-video" data-property='<?php echo json_encode( $_video_params ); ?>' <?php if( $video_parallax ): ?>data-stellar-ratio="<?php echo esc_attr( fw_get_db_customizer_option( 'footer_media_effect/video/video_parallax_speed', $wplab_albedo_core->default_options['footer_videobg_parallax_speed']) ); ?>"<?php endif; ?>></div>
	<?php endif; ?>

	<?php if( $particles ): ?>
	<!--
		Particles Footer Effect markup
	-->
	<div class="particles-section">
		<div class="particles-element" id="particles-main-footer"></div>
	</div>
	<?php endif; ?>

	<!--
		Particles Footer Effect markup
	-->
	<div id="footer-bg-overlay"></div>

	<?php if( $footer_widgets ): ?>
		<?php
			/** get footer additional settings **/
			$widgets_columns = absint( fw_get_db_customizer_option( 'footer_widgets/yes/footer_widgets_cols', $wplab_albedo_core->default_options['footer_widgets_cols']));
			$widget_area = fw_get_db_customizer_option( 'footer_widgets/yes/footer_widgets_area', $wplab_albedo_core->default_options['footer_widgets_area'] );
			$footer_forms_style = fw_get_db_customizer_option( 'footer_forms_style', $wplab_albedo_core->default_options['footer_forms_style'] );
		?>
		<div id="footer-widgets" class="container forms-style-<?php echo esc_attr( $footer_forms_style ); ?> cols-<?php echo esc_attr( $widgets_columns ); ?>">
			<div class="row">
				<div class="col-md-12">
					<div class="widgets">
						<?php dynamic_sidebar( $widget_area ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<?php if( $bottom_bar ): ?>
			<?php
				/** get bottom bar additionl settings **/
				$bottom_bar_style = wplab_albedo_utils::get_theme_mod(
					'footer_bar/yes/footer_bar_style',
					$wplab_albedo_core->default_options['footer_bar_style']
				);

				$bottom_bar_text = wplab_albedo_utils::get_theme_mod(
					'footer_bar/yes/footer_bar_text',
					$wplab_albedo_core->default_options['footer_bar_text']
				);

				$display_gotop = filter_var( wplab_albedo_utils::get_theme_mod(
					'footer_bar/yes/gotop_link/enabled',
					$wplab_albedo_core->default_options['gotop_link']
				), FILTER_VALIDATE_BOOLEAN);

				$gotop_text = wplab_albedo_utils::get_theme_mod(
					'footer_bar/yes/gotop_link/yes/gotop_link_text',
					$wplab_albedo_core->default_options['gotop_link_text']
				);

			?>

			<div id="bottom-bar" class="style-<?php echo esc_attr( $bottom_bar_style ); ?>">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="bottom-bar-content">
								<div class="bg-layer-1"></div>
								<div class="bg-layer-2"></div>
								<div class="bottom-bar-text">
									<?php echo wp_kses_post( $bottom_bar_text ); ?>
								</div>

								<?php if( $display_gotop ): ?>
									<a href="javascript:;" id="gotop"><?php echo wp_kses_post( $gotop_text ); ?></a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>

			</div>
		<?php endif; ?>

	</footer>

	</div><!-- / main wrapper -->
	<?php

		/**
		 * Side overlay menu for minimal headers
		 **/
		get_template_part( 'template-parts/header/overlay/overlay_menu');

		/**
		 * Side overlay menu sidebar area
		 **/
		get_template_part( 'template-parts/header/overlay/overlay_sidebar');

		/**
		 * Demo panel. It is active only for the demo installation
		 * can be removed
		 **/
		wplab_albedo_front::demo_panel();
		/**
		 * Information for developers, DB queries count, page loading speed
		 * this function located at /wproto/helper/front.php
		 **/
		wplab_albedo_front::dev_info();
	?>
	<?php wp_footer(); ?>
</body>
</html>
