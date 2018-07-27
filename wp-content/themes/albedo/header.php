<?php
/**
 * Header template
 **/
global $wplab_albedo_core;
?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php
	/**
	 * Display page preloader
	 * this function located at /wproto/helper/front.php
	 **/
	wplab_albedo_front::preloader();

	$header_css_classes = $header_attributes = array();
	$is_slider_mode = false;

	/**
	 * Base header CSS classes
	 **/

	// Get CSS class of header layout
	$header_layout = wplab_albedo_utils::get_theme_mod(
		'header_layout',
		$wplab_albedo_core->default_options['header_layout']
	);

	$header_css_classes[] = 'header-layout-' . esc_attr( $header_layout );

	// Is slider mode enabled?
	if( wplab_albedo_utils::is_unyson() && ((is_page() && filter_var( fw_get_db_post_option( get_the_ID(), 'slider_header_mode' ), FILTER_VALIDATE_BOOLEAN )) || ( is_404() && filter_var( fw_get_db_customizer_option( 'page_404_slider_header_mode' ), FILTER_VALIDATE_BOOLEAN ) )) ) {
		$header_css_classes[] = 'slider-mode';
		$is_slider_mode = true;
	}

	/**
	 * Header effects
	 **/
	$header_parallax = $header_media_effect = array();
	$video_parallax = $particles = $particlegroud = false;

	if( wplab_albedo_utils::is_unyson() && ! $is_slider_mode ) {

		$header_parallax = fw_get_db_customizer_option( 'header_parallax_effect', $wplab_albedo_core->default_options['header_parallax_effect']);

		/**
		 * Standard parallax
		 **/
		if( $header_parallax['effect'] == 'parallax' ) {
			$parallax_speed = fw_get_db_customizer_option( 'header_parallax_effect/parallax/parallax_speed', $wplab_albedo_core->default_options['header_parallax_effect_parallax_speed']);
			$header_css_classes[] = 'parallax-section';
			$header_attributes[] = 'data-stellar-background-ratio="' . esc_attr( $parallax_speed ) . '"';
		}

		/**
		 * Mouse parallax
		 **/
		elseif( $header_parallax['effect'] == 'mouse_parallax' ) {
			$header_css_classes[] = 'parallax-js-section';
			$header_css_classes[] = 'no-bg-image';
		}

		// Media effects

		$header_media_effect = fw_get_db_customizer_option( 'header_media_effect', $wplab_albedo_core->default_options['header_media_effect']);

		/**
		 * Video background
		 **/
		if( $header_media_effect['effect'] == 'video' ) {
			$header_css_classes[] = 'video-bg-section';
			$_video_parallax_speed = fw_get_db_customizer_option( 'header_media_effect/video/video_parallax_speed', $wplab_albedo_core->default_options['header_videobg_parallax_speed']);

			if( $_video_parallax_speed <> '' ) {
				$header_css_classes[] = 'video-parallax';
				$video_parallax = true;
			}
		}

		/**
		 * Particle Groud Effect
		 **/
		elseif( $header_media_effect['effect'] == 'particleground' ) {
			$particlegroud = true;
			if( is_page() && wplab_albedo_utils::is_unyson() && filter_var( fw_get_db_post_option( get_the_ID(), 'hide_header_title' ), FILTER_VALIDATE_BOOLEAN ) ) {
				$particlegroud = false;
			}
		}

		/**
		 * Particles Effect
		 **/
		elseif( $header_media_effect['effect'] == 'particles' ) {
			wplab_albedo_front::generate_header_particles_script();
			$particles = true;
		}

	}

?>

	<!--
		Main wrapper
	-->
	<div id="wrap">

		<div id="header" <?php echo implode( ' ', $header_attributes ); ?> class="<?php echo implode( ' ', $header_css_classes ); ?>">

			<?php if( wplab_albedo_utils::is_unyson() && ! $is_slider_mode && isset( $header_parallax['effect'] ) && $header_parallax['effect'] == 'mouse_parallax' ): ?>
			<!--
				Mouse Parallax Scene
			-->
			<?php
				$mouse_parallax_img_src = fw_get_db_customizer_option( 'header_bg_image_src');
				$mouse_parallax_img = isset( $mouse_parallax_img_src['data']['icon'] ) && $mouse_parallax_img_src['data']['icon'] <> '' ? $mouse_parallax_img_src['data']['icon'] : '';
				if( is_page() || is_singular() || is_single() ) {
					$custom_page_header_bg = fw_get_db_post_option( get_the_ID(), 'page_header_bg' );
					if( isset( $custom_page_header_bg['url'] ) && $custom_page_header_bg['url']  <> '' ) {
						$mouse_parallax_img = $custom_page_header_bg['url'];
					}
				} elseif( is_home() ) {
					$custom_page_header_bg = fw_get_db_post_option( get_option('page_for_posts'), 'page_header_bg' );
					if( isset( $custom_page_header_bg['url'] ) && $custom_page_header_bg['url']  <> '' ) {
						$mouse_parallax_img = $custom_page_header_bg['url'];
					}
				} elseif( function_exists('is_woocommerce') && is_woocommerce() ) {
					$custom_page_header_bg = fw_get_db_post_option( get_option('woocommerce_shop_page_id'), 'page_header_bg' );
					if( isset( $custom_page_header_bg['url'] ) && $custom_page_header_bg['url']  <> '' ) {
						$mouse_parallax_img = $custom_page_header_bg['url'];
					}
				}
				if( $mouse_parallax_img <> '' ):
			?>
			<div class="header-mouseparallax-wrapper">
				<ul class="parallax-scene"
						data-invert-x="<?php echo filter_var( fw_get_db_customizer_option( 'header_parallax_effect/mouse_parallax/invert_x', $wplab_albedo_core->default_options['header_mouse_parallax_invert_x']), FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false'; ?>"
						data-invert-y="<?php echo filter_var( fw_get_db_customizer_option( 'header_parallax_effect/mouse_parallax/invert_y', $wplab_albedo_core->default_options['header_mouse_parallax_invert_y']), FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false'; ?>"
						data-limit-x="<?php echo esc_attr( fw_get_db_customizer_option( 'header_parallax_effect/mouse_parallax/limit_x', $wplab_albedo_core->default_options['header_mouse_parallax_limit_x']) ); ?>"
						data-limit-y="<?php echo esc_attr( fw_get_db_customizer_option( 'header_parallax_effect/mouse_parallax/limit_y', $wplab_albedo_core->default_options['header_mouse_parallax_limit_y']) ); ?>"
						data-scalar-x="<?php echo esc_attr( fw_get_db_customizer_option( 'header_parallax_effect/mouse_parallax/scalar_x', $wplab_albedo_core->default_options['header_mouse_parallax_scalar_x']) ); ?>"
						data-scalar-y="<?php echo esc_attr( fw_get_db_customizer_option( 'header_parallax_effect/mouse_parallax/scalar_y', $wplab_albedo_core->default_options['header_mouse_parallax_scalar_y']) ); ?>"
						data-friction-x="<?php echo esc_attr( fw_get_db_customizer_option( 'header_parallax_effect/mouse_parallax/friction_x', $wplab_albedo_core->default_options['header_mouse_parallax_friction_x']) ); ?>"
						data-friction-y="<?php echo esc_attr( fw_get_db_customizer_option( 'header_parallax_effect/mouse_parallax/friction_y', $wplab_albedo_core->default_options['header_mouse_parallax_friction_y']) ); ?>"
						data-origin-x="<?php echo esc_attr( fw_get_db_customizer_option( 'header_parallax_effect/mouse_parallax/origin_x', $wplab_albedo_core->default_options['header_mouse_parallax_origin_x']) ); ?>"
						data-origin-y="<?php echo esc_attr( fw_get_db_customizer_option( 'header_parallax_effect/mouse_parallax/origin_y', $wplab_albedo_core->default_options['header_mouse_parallax_origin_y']) ); ?>">
					<li style="background-image: url(<?php echo esc_attr( $mouse_parallax_img ); ?>);" class="layer layer-bg" data-depth="<?php echo esc_attr( fw_get_db_customizer_option( 'header_parallax_effect/mouse_parallax/depth', $wplab_albedo_core->default_options['header_mouse_parallax_depth']) ); ?>"><div></div></li>
				</ul>
			</div>
			<?php endif; endif; ?>

			<?php if( wplab_albedo_utils::is_unyson() && ! $is_slider_mode && isset( $header_media_effect['effect'] ) && $header_media_effect['effect'] == 'video' ): ?>
			<!--
				Header Video BG Effect markup
			-->
			<?php
				$_video_params = array(
					'videoURL' => esc_attr( fw_get_db_customizer_option( 'header_media_effect/video/video', $wplab_albedo_core->default_options['header_videobg_url']) ),
					'containment' => '#header-video',
					'autoPlay' => 'true',
					'mute' => esc_attr( fw_get_db_customizer_option( 'header_media_effect/video/video_mute', $wplab_albedo_core->default_options['header_videobg_video_mute']) ),
					'showControls' => 'false',
					'quality' => 'hd720',
					'loop' => 'true',
					'showYTLogo' => 'false'
				);

				$video_fallback_url = fw_get_db_customizer_option( 'header_media_effect/video/video_fallback_image');
				if( isset( $video_fallback_url['url'] ) ) {
					$_video_params['mobileFallbackImage'] = $video_fallback_url['url'];
				}

			?>
			<div class="video-bg" id="header-video" data-property='<?php echo json_encode( $_video_params ); ?>' <?php if( $video_parallax ): ?>data-stellar-ratio="<?php echo esc_attr( fw_get_db_customizer_option( 'header_media_effect/video/video_parallax_speed', $wplab_albedo_core->default_options['header_videobg_parallax_speed']) ); ?>"<?php endif; ?> style="position: absolute; top: 0; right: 0; bottom: 0; left: 0;"></div>
			<?php endif; ?>

			<?php if( $particles && ! $is_slider_mode ): ?>
			<!--
				Particles Header Effect markup
			-->
			<div class="particles-section">
				<div class="particles-element" id="particles-main-header"></div>
			</div>
			<?php endif; ?>

			<?php if( $particlegroud && !$is_slider_mode ): ?>

			<?php
				$_particles_attributes[] = 'data-dot-color="' . esc_attr( fw_get_db_customizer_option( 'header_media_effect/particleground/dot_color' ) ) . '"';
				$_particles_attributes[] = 'data-line-color="' . esc_attr( fw_get_db_customizer_option( 'header_media_effect/particleground/line_color' ) ) . '"';
				$_particles_attributes[] = 'data-particle-radius="' . esc_attr( fw_get_db_customizer_option( 'header_media_effect/particleground/particle_radius' ) ) . '"';
				$_particles_attributes[] = 'data-line-width="' . esc_attr( fw_get_db_customizer_option( 'header_media_effect/particleground/line_width' ) ) . '"';
				$_particles_attributes[] = 'data-curved-lines="' . esc_attr( fw_get_db_customizer_option( 'header_media_effect/particleground/curved_lines' ) ) . '"';
				$_particles_attributes[] = 'data-parallax="' . esc_attr( fw_get_db_customizer_option( 'header_media_effect/particleground/parallax' ) ) . '"';
				$_particles_attributes[] = 'data-parallax-multiplier="' . esc_attr( fw_get_db_customizer_option( 'header_media_effect/particleground/parallax_multiplier' ) ) . '"';
				$_particles_attributes[] = 'data-proximity="' . esc_attr( fw_get_db_customizer_option( 'header_media_effect/particleground/proximity' ) ) . '"';
				$_particles_attributes[] = 'data-min-speed-x="' . esc_attr( fw_get_db_customizer_option( 'header_media_effect/particleground/min_speed_x' ) ) . '"';
				$_particles_attributes[] = 'data-max-speed-x="' . esc_attr( fw_get_db_customizer_option( 'header_media_effect/particleground/max_speed_x' ) ) . '"';
				$_particles_attributes[] = 'data-min-speed-y="' . esc_attr( fw_get_db_customizer_option( 'header_media_effect/particleground/min_speed_x' ) ) . '"';
				$_particles_attributes[] = 'data-max-speed-y="' . esc_attr( fw_get_db_customizer_option( 'header_media_effect/particleground/max_speed_x' ) ) . '"';
				$_particles_attributes[] = 'data-direction-x="' . esc_attr( fw_get_db_customizer_option( 'header_media_effect/particleground/direction_x' ) ) . '"';
				$_particles_attributes[] = 'data-direction-y="' . esc_attr( fw_get_db_customizer_option( 'header_media_effect/particleground/direction_y' ) ) . '"';
				$_particles_attributes[] = 'data-destiny="' . esc_attr( fw_get_db_customizer_option( 'header_media_effect/particleground/destiny' ) ) . '"';
			?>
			<div id="header-particlegroud" class="particle-ground-section" <?php echo implode(' ', $_particles_attributes ); ?>></div>

			<?php endif; ?>

			<!--
				Particles Header Effect markup
			-->
			<div id="header-bg-overlay"></div>

			<!--
				Top Bar
			-->
			<?php get_template_part('template-parts/header/top-bar'); ?>

			<!--
				Menu
			-->
			<?php get_template_part('template-parts/header/menu'); ?>

			<!--
				Sub-header
			-->
			<?php get_template_part('template-parts/header/subheader'); ?>
		</div>
