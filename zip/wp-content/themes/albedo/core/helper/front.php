<?php
	/**
	 * Front helper
	 **/
	class wplab_albedo_front {

		/**
		 * Page preloader
		 **/
		public static function preloader() {
			if( ! wplab_albedo_utils::is_unyson() ) {
				return false;
			}

			$preloader_style = 'hidden';

			// If Unyson Framework is enabled
			$preloader_style = fw_get_db_customizer_option( 'page_preloader/style' );

			if( $preloader_style == 'css' ):
			?>
			<div id="preloader">
				<div id="preloader-inner" class="loader-inner line-spin-fade-loader"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
			</div>
			<?php
			elseif( $preloader_style == 'custom' ):

				$preloader_img 				= esc_attr( fw_get_db_customizer_option( 'page_preloader/custom/custom_preloader_image/url' ) );
				$preloader_img_retina = esc_attr( fw_get_db_customizer_option( 'page_preloader/custom/custom_preloader_image_2x/url' ) );
				$preloader_img_retina = $preloader_img_retina == '' ? 'data-no-retina' : 'data-at2x="' . $preloader_img_retina . '"';

				$preloader_width = fw_get_db_customizer_option( 'page_preloader/custom/custom_preloader_image_width' );
				$preloader_height = fw_get_db_customizer_option( 'page_preloader/custom/custom_preloader_image_height' );

				$preloader_style = wplab_albedo_utils::get_styles( array(
					'width'				=> esc_attr( $preloader_width ),
					'height'			=> esc_attr( $preloader_height ),
					'top_margin' 	=> '-' . $preloader_height / 2,
					'left_margin' => '-' . $preloader_width / 2,
				));

			?>
			<div id="preloader" class="custom">
				<img src="<?php echo $preloader_img; ?>" <?php echo $preloader_img_retina; ?> style="<?php echo esc_attr( $preloader_style ); ?>" alt="" />
			</div>
			<?php
			endif;
		}

		/**
		 * Display share / like links
		 **/
		public static function share_links( $simple = false ) {
			$title = urlencode( get_the_title( get_the_ID() ) );
			$permalink = urlencode( get_permalink( get_the_ID() ) );
			$post_thumb = has_post_thumbnail() ? urlencode( wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) ) : '';
			?>

			<?php if( !$simple ): ?>
			<div class="share-links">
				<strong><?php esc_html_e('Share', 'albedo'); ?>:</strong>
			<?php endif; ?>
				<a rel="nofollow" class="facebook" title="<?php esc_html_e('Share on Facebook', 'albedo'); ?>" target="_blank" href="https://www.facebook.com/sharer/sharer.php?display=popup&amp;u=<?php echo $permalink; ?>"><i class="fa fa-facebook"></i></a>
				<a rel="nofollow" class="twitter" title="<?php esc_html_e('Share on Twitter', 'albedo'); ?>" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo $title; ?>&amp;url=<?php echo $permalink; ?>"><i class="fa fa-twitter"></i></a>
				<a rel="nofollow" class="linkedin" title="<?php esc_html_e('Share on LinkedIn', 'albedo'); ?>" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $permalink; ?>&title=<?php echo $title; ?>&summary=&source="><i class="fa fa-linkedin"></i></a>
				<a rel="nofollow" class="google-plus" title="<?php esc_html_e('Share on Google Plus', 'albedo'); ?>" target="_blank" href="https://plus.google.com/share?url=<?php echo $permalink; ?>"><i class="fa fa-google-plus"></i></a>
				<?php if( !$simple ): ?>
			</div>
			<?php endif; ?>
			<?php
		}

		/**
		 * Demo panel
		 **/
		public static function demo_panel() {
			if( defined( 'WPROTO_DEMO_STAND' ) && WPROTO_DEMO_STAND ):
			?>
			<div id="demo-overlay"></div>
			<div id="demo-panel">
				<div class="buttons">
					<a href="javascript:;" class="open-close" title="<?php esc_html_e('See more demos', 'albedo'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/cogwheel.svg" class="image-svg" alt="" /></a>
					<a rel="nofollow" href="https://themeforest.net/item/albedo-highly-customizable-multipurpose-wordpress-theme/20386924?ref=wplab&license=regular&open_purchase_for_item_id=20386924" target="_blank" class="buy" title="<?php esc_html_e('Buy this awesome theme via ThemeForest', 'albedo'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/commerce.svg" class="image-svg" alt="" /></a>
					<a href="https://wplab.ticksy.com/submit/#100011316" rel="nofollow" target="_blank" class="get-support" title="<?php esc_html_e('Get Support', 'albedo'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/help.svg" class="image-svg" alt="" /></a>
				</div>
				<div class="demos">
					<a href="//www.albedo-theme.com/modern/"><img src="<?php echo get_template_directory_uri(); ?>/images/screen1.png" width="250" title="Albedo Modern Demo" alt="Albedo Modern Demo" /></a>
					<a href="//www.albedo-theme.com/creative/"><img src="<?php echo get_template_directory_uri(); ?>/images/screen2.png" width="250" title="Albedo Creative Agency Demo" alt="Albedo Creative Agency Demo" /></a>
					<a href="//www.albedo-theme.com/one-page/"><img src="<?php echo get_template_directory_uri(); ?>/images/screen3.png" width="250" title="Albedo Personal / One Page Demo" alt="Albedo Personal / One Page Demo" /></a>
					<a href="//www.albedo-theme.com/minimal/"><img src="<?php echo get_template_directory_uri(); ?>/images/screen4.png" width="250" title="Albedo Minimal Demo" alt="Albedo Minimal Demo" /></a>
					<a href="//www.albedo-theme.com/classic/"><img src="<?php echo get_template_directory_uri(); ?>/images/screen5.png" width="250" title="Albedo Classic Demo" alt="Albedo Classic Demo" /></a>
					<a href="//www.albedo-theme.com/business/"><img src="<?php echo get_template_directory_uri(); ?>/images/screen6.png" width="250" title="Albedo Business Demo" alt="Albedo Business Demo" /></a>
					<a href="//www.albedo-theme.com/photography/"><img src="<?php echo get_template_directory_uri(); ?>/images/screen7.png" width="250" title="Albedo Photography Demo" alt="Albedo Photography Demo" /></a>
					<a href="//www.albedo-theme.com/"><img src="<?php echo get_template_directory_uri(); ?>/images/screen8.png" width="250" title="Albedo Landing Demo" alt="Albedo Landing Demo" /></a>
				</div>
			</div>
			<?php
			endif;
		}

		/**
		 * Information for developers
		 **/
		public static function dev_info() {

			//echo '<!--' . strtotime('now') . ' ' . $dev_status . ' Development mode enabled -->';

			if( wplab_albedo_utils::is_unyson() && filter_var( fw_get_db_settings_option( 'dev_info' ), FILTER_VALIDATE_BOOLEAN ) ):
			?>
<!--
===============================================================================================
Generated with <?php echo get_num_queries(); ?> SQL queries in <?php timer_stop(1); ?> seconds.
===============================================================================================
-->
			<?php
			endif;
		}

		/**
		 * Print FontAwesome social icons
		 **/
		public static function print_fa_icons( $links ) {
			global $wplab_albedo_core;

			$atts = 'target="_blank" rel="nofollow"';

			foreach( $wplab_albedo_core->cfg['social_profiles'] as $k=>$v ) {
				if( isset( $links[ $k ] ) && $links[ $k ] <> '' ) {
					echo '<a href="' . esc_attr( $links[ $k ] ) . '" ' . $atts . '><i class="' . $wplab_albedo_core->cfg['social_icons'][ $k ] . '"></i></a>';
				}
			}

		}


		/**
		 * Get post / page content classes
		 **/
		public static function get_content_classes() {

			$classes_string = '';

			// If Unyson Framework plugin is active
			if( wplab_albedo_utils::is_unyson() && function_exists('fw_ext_sidebars_get_current_position') ) {

				$current_sidebar_position = fw_ext_sidebars_get_current_position();

				$sidebar_size = fw_get_db_customizer_option( 'sidebar_size' );
				$sidebar_size = absint( $sidebar_size );

				$side_gap = filter_var( fw_get_db_customizer_option( 'sidebar_gap' ), FILTER_VALIDATE_BOOLEAN );

				if( $sidebar_size <=0 || $sidebar_size > 5 ) {
					$sidebar_size = 3;
				}

				$content_size = 12 - $sidebar_size;

				if( $side_gap ) {
					$content_size = $content_size - 1;
				}

				if( $current_sidebar_position == 'full' ) {
					$classes_string = 'col-md-12';
				} elseif( $current_sidebar_position == 'left' ) {
					$classes_string = 'col-md-' . $content_size;
				} elseif( $current_sidebar_position === 'left_left' || $current_sidebar_position === 'right_right' || $current_sidebar_position === 'left_right' ) {
					$content_size = 12 - $sidebar_size * 2;
					$classes_string = 'col-md-' . $content_size;
				} else {
					$classes_string = 'col-md-' . $content_size;
				}

			} else {
				$classes_string = 'col-md-9';
			}

			return $classes_string;

		}

		/**
		 * Print page title
		 **/
		public static function print_page_title( $args = array() ) {

			$classes = '';
			$atts = array();

			if( isset( $args['effect'] ) && $args['effect'] == 'typed' ) {
				wp_enqueue_script( 'typed' );
				$classes = 'wow typed';
				$atts[] = 'data-typed-speed="50"';
				$atts[] = 'data-typed-delay="50"';
			}

			?>

			<?php if( is_post_type_archive( 'fw-portfolio') || is_tax('fw-portfolio-category') ): ?>

				<?php echo '<h1 ' . implode(' ', $atts ) . ' class="' . esc_attr( $classes ) . '">' . esc_html__( 'Our Projects', 'albedo' ) . '</h1>'; ?>

			<?php elseif( wplab_albedo_utils::is_woocommerce() && ( is_shop() || is_product_category() || is_product_tag() || is_singular('product') ) ): ?>

				<?php echo '<h1 ' . implode(' ', $atts ) . ' class="' . esc_attr( $classes ) . '">' . esc_html__( 'Shop', 'albedo' ) . '</h1>'; ?>

			<?php elseif( is_post_type_archive( 'docs') || is_singular( 'docs') ): ?>

				<?php echo '<h1 ' . implode(' ', $atts ) . ' class="' . esc_attr( $classes ) . '">' . esc_html__( 'Documentation', 'albedo' ) . '</h1>'; ?>

			<?php elseif( is_post_type_archive() ): ?>

				<?php echo '<h1 ' . implode(' ', $atts ) . ' class="' . esc_attr( $classes ) . '">';
				post_type_archive_title();
				echo '</h1>'; ?>

			<?php elseif( (is_front_page() && is_home()) || is_home() || is_category() || is_tag() || is_archive() || is_author() ): ?>

				<?php echo '<h1 ' . implode(' ', $atts ) . ' class="' . esc_attr( $classes ) . '">' . esc_html__( 'Blog', 'albedo' ) . '</h1>'; ?>

			<?php elseif( is_singular() || is_single() ): ?>

				<?php echo '<h1 ' . implode(' ', $atts ) . ' class="' . esc_attr( $classes ) . '">' . get_the_title() . '</h1>'; ?>

			<?php elseif( is_404() ): ?>
				<h1 <?php echo implode( '', $atts ); ?> class="<?php echo esc_attr( $classes ); ?>">
					<?php esc_html_e( 'Page not found', 'albedo' ); ?>
				</h1>
			<?php elseif( is_search() ): ?>
				<h1 <?php echo implode( '', $atts ); ?> class="<?php echo esc_attr( $classes ); ?>">
					<?php esc_html_e( 'Search results', 'albedo' ); ?>
				</h1>
			<?php endif; ?>

			<?php
		}

		/**
		 * Print page description
		 **/
		public static function get_page_desc() {
			$page_description = fw_get_db_post_option( get_the_ID(), 'page_header_description' );
			if( is_home() ) {
				$page_description = fw_get_db_post_option( get_option( 'page_for_posts' ), 'page_header_description' );
			} elseif( function_exists('is_shop') && (is_shop() || is_product() || is_cart() || is_checkout()) ) {
				$page_description = fw_get_db_post_option( get_option( 'woocommerce_shop_page_id' ), 'page_header_description' );
			}
			return $page_description;
		}

		/**
		 * Generate header particles effect script
		 **/
		public static function generate_header_particles_script() {
			global $wplab_albedo_core;
			$script = "
			(function($){

				if( $('#particles-main-header .particles-element').length ) {

					setTimeout( function() {

						$('#particles-main-header .particles-element').height( $('#particles-main-header').outerHeight() ).width( $('body').width() );

					}, 700 );

					$(window).on('resize', function() {

						$('#particles-main-header .particles-element').height( $('#particles-main-header').outerHeight() ).width( $('body').width() );

					});


				}

			})( window.jQuery );";

			$script .= '
setTimeout( function() { particlesJS( "particles-main-header", {
	"particles": {
		"number": {
			"value": ' . fw_get_db_customizer_option( 'header_media_effect/particles/number', $wplab_albedo_core->default_options['header_particles_number']) . ',
				"density": {
					"enable": window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'header_media_effect/particles/density/enabled', $wplab_albedo_core->default_options['header_particles_density']) . '"),
					"value_area": ' . fw_get_db_customizer_option( 'header_media_effect/particles/density/yes/density_value', $wplab_albedo_core->default_options['header_particles_density_value']) . '
			}
		},
		"color": {
			"value": "' . fw_get_db_customizer_option( 'header_media_effect/particles/color', $wplab_albedo_core->default_options['header_particles_color']) . '"
		},
		"shape": {
			"type":"' . fw_get_db_customizer_option( 'header_media_effect/particles/shape_type', $wplab_albedo_core->default_options['header_particles_shape_type']) . '",
			"stroke": {
				"width": ' . fw_get_db_customizer_option( 'header_media_effect/particles/stroke_width', $wplab_albedo_core->default_options['header_particles_stroke_width']) . ',
				"color": "' . fw_get_db_customizer_option( 'header_media_effect/particles/stroke_color', $wplab_albedo_core->default_options['header_particles_stroke_color']) . '"
			},
			"polygon": {
				"nb_sides": ' . fw_get_db_customizer_option( 'header_media_effect/particles/polygon_sides', $wplab_albedo_core->default_options['header_particles_polygon_sides']) . '
			}
		},
		"opacity": {
			"value": ' . fw_get_db_customizer_option( 'header_media_effect/particles/opacity', $wplab_albedo_core->default_options['header_particles_opacity']) . ',
			"random":window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'header_media_effect/particles/opacity_rand', $wplab_albedo_core->default_options['header_particles_opacity_rand']) . '"),
			"anim": {
				"enable": window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'header_media_effect/particles/animate_opacity/enabled', $wplab_albedo_core->default_options['header_particles_animate_opacity']) . '"),
				"speed": ' . fw_get_db_customizer_option( 'header_media_effect/particles/animate_opacity/yes/speed', $wplab_albedo_core->default_options['header_particles_animate_opacity_speed']) . ',
				"opacity_min": ' . fw_get_db_customizer_option( 'header_media_effect/particles/animate_opacity/yes/size_min', $wplab_albedo_core->default_options['header_particles_animate_opacity_size_min']) . ',
				"sync": window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'header_media_effect/particles/animate_opacity/yes/sync', $wplab_albedo_core->default_options['header_particles_animate_opacity_sync']) . '")
			}
		},
		"size": {
			"value": ' . fw_get_db_customizer_option( 'header_media_effect/particles/size', $wplab_albedo_core->default_options['header_particles_size']) . ',
			"random":window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'header_media_effect/particles/size_rand', $wplab_albedo_core->default_options['header_particles_size_rand']) . '"),
			"anim": {
				"enable": window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'header_media_effect/particles/animate_size/enabled', $wplab_albedo_core->default_options['header_particles_animate_size']) . '"),
				"speed": ' . fw_get_db_customizer_option( 'header_media_effect/particles/animate_size/yes/speed', $wplab_albedo_core->default_options['header_particles_animate_size_speed']) . ',
				"size_min": ' . fw_get_db_customizer_option( 'header_media_effect/particles/animate_size/yes/size_min', $wplab_albedo_core->default_options['header_particles_animate_size_min']) . ',
				"sync": window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'header_media_effect/particles/animate_size/yes/sync', $wplab_albedo_core->default_options['header_particles_animate_sync']) . '")
			}
		},
		"line_linked": {
			"enable": window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'header_media_effect/particles/lines/enabled', $wplab_albedo_core->default_options['header_particles_lines']) . '"),
			"distance": ' . fw_get_db_customizer_option( 'header_media_effect/particles/lines/yes/distance', $wplab_albedo_core->default_options['header_particles_lines_distance']) . ',
			"color": "' . fw_get_db_customizer_option( 'header_media_effect/particles/lines/yes/color', $wplab_albedo_core->default_options['header_particles_lines_color']) . '",
			"opacity": ' . fw_get_db_customizer_option( 'header_media_effect/particles/lines/yes/opacity', $wplab_albedo_core->default_options['header_particles_lines_opacity']) . ',
			"width": ' . fw_get_db_customizer_option( 'header_media_effect/particles/lines/yes/width', $wplab_albedo_core->default_options['header_particles_lines_width']) . '
		},
		"move": {
			"enable":window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'header_media_effect/particles/move/enabled', $wplab_albedo_core->default_options['header_particles_move']) . '"),
			"speed": ' . fw_get_db_customizer_option( 'header_media_effect/particles/move/yes/speed', $wplab_albedo_core->default_options['header_particles_move_speed']) . ',
			"direction":"' . fw_get_db_customizer_option( 'header_media_effect/particles/move/yes/direction', $wplab_albedo_core->default_options['header_particles_move_direction']) . '",
			"random":window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'header_media_effect/particles/move/yes/rand', $wplab_albedo_core->default_options['header_particles_move_rand']) . '"),
			"straight":window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'header_media_effect/particles/move/yes/straight', $wplab_albedo_core->default_options['header_particles_move_straight']) . '"),
			"out_mode":"' . fw_get_db_customizer_option( 'header_media_effect/particles/move/yes/out_mode', $wplab_albedo_core->default_options['header_particles_move_out_mode']) . '",
			"bounce":false,
			"attract": {
				"enable": false
			}
		}
	},
	"interactivity": {
		"detect_on":"canvas",
		"events": {
			"onhover": {
				"enable": window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'header_media_effect/particles/onhover/enabled', $wplab_albedo_core->default_options['header_particles_onhover']) . '"),
				"mode": "' . fw_get_db_customizer_option( 'header_media_effect/particles/onhover/yes/mode', $wplab_albedo_core->default_options['header_particles_onhover_mode']) . '"
			},
			"onclick": {
				"enable": window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'header_media_effect/particles/onclick/enabled', $wplab_albedo_core->default_options['header_particles_onclick']) . '"),
				"mode": "' . fw_get_db_customizer_option( 'header_media_effect/particles/onclick/yes/mode', $wplab_albedo_core->default_options['header_particles_onclick_mode']) . '"
			},
			"resize":true
		},
		"modes": {
			"grab": {
				"distance":' . fw_get_db_customizer_option( 'header_media_effect/particles/grab_distance', $wplab_albedo_core->default_options['header_particles_grab_distance']) . ',
				"line_linked": {
					"opacity": ' . fw_get_db_customizer_option( 'header_media_effect/particles/grab_opacity', $wplab_albedo_core->default_options['header_particles_grab_opacity']) . '
				}
			},
			"bubble": {
				"distance": ' . fw_get_db_customizer_option( 'header_media_effect/particles/bubble_distance', $wplab_albedo_core->default_options['header_particles_bubble_distance']) . ',
				"size": ' . fw_get_db_customizer_option( 'header_media_effect/particles/bubble_size', $wplab_albedo_core->default_options['header_particles_bubble_size']) . ',
				"duration": ' . fw_get_db_customizer_option( 'header_media_effect/particles/bubble_duration', $wplab_albedo_core->default_options['header_particles_bubble_duration']) . ',
				"opacity": ' . fw_get_db_customizer_option( 'header_media_effect/particles/bubble_opacity', $wplab_albedo_core->default_options['header_particles_bubble_opacity']) . ',
				"speed": ' . fw_get_db_customizer_option( 'header_media_effect/particles/bubble_speed', $wplab_albedo_core->default_options['header_particles_bubble_speed']) . '
			},
			"repulse": {
				"distance": ' . fw_get_db_customizer_option( 'header_media_effect/particles/repulse_distance', $wplab_albedo_core->default_options['header_particles_repulse_distance']) . ',
				"duration": ' . fw_get_db_customizer_option( 'header_media_effect/particles/repulse_duration', $wplab_albedo_core->default_options['header_particles_repulse_duration']) . '
			},
			"push": {
				"particles_nb": 4
			},
			"remove": {
				"particles_nb": 2
			}
		}
	}
	,
	"retina_detect":true
}); }, 800);
			';

			wp_add_inline_script( 'particles', $script );

		}

		/**
			Generate Footer particles script
		**/
		public static function generate_footer_particles_script() {
			$script = "
			(function($){

				if( $('#particles-main-footer .particles-element').length ) {

					setTimeout( function() {

						$('#particles-main-footer .particles-element').height( $('#particles-main-footer').outerHeight() ).width( $('body').width() );

					}, 700 );

					$(window).on('resize', function() {

						$('#particles-main-footer .particles-element').height( $('#particles-main-footer').outerHeight() ).width( $('body').width() );

					});


				}

			})( window.jQuery );";

			$script .= '
			setTimeout( function() { particlesJS( "particles-main-footer", {
			"particles": {
			"number": {
			"value": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/number', $wplab_albedo_core->default_options['footer_particles_number']) . ',
				"density": {
					"enable": window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'footer_media_effect/particles/density/enabled', $wplab_albedo_core->default_options['footer_particles_density']) . '"),
					"value_area": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/density/yes/density_value', $wplab_albedo_core->default_options['footer_particles_density_value']) . '
			}
			},
			"color": {
			"value": "' . fw_get_db_customizer_option( 'footer_media_effect/particles/color', $wplab_albedo_core->default_options['footer_particles_color']) . '"
			},
			"shape": {
			"type":"' . fw_get_db_customizer_option( 'footer_media_effect/particles/shape_type', $wplab_albedo_core->default_options['footer_particles_shape_type']) . '",
			"stroke": {
				"width": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/stroke_width', $wplab_albedo_core->default_options['footer_particles_stroke_width']) . ',
				"color": "' . fw_get_db_customizer_option( 'footer_media_effect/particles/stroke_color', $wplab_albedo_core->default_options['footer_particles_stroke_color']) . '"
			},
			"polygon": {
				"nb_sides": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/polygon_sides', $wplab_albedo_core->default_options['footer_particles_polygon_sides']) . '
			}
			},
			"opacity": {
			"value": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/opacity', $wplab_albedo_core->default_options['footer_particles_opacity']) . ',
			"random":window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'footer_media_effect/particles/opacity_rand', $wplab_albedo_core->default_options['footer_particles_opacity_rand']) . '"),
			"anim": {
				"enable": window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'footer_media_effect/particles/animate_opacity/enabled', $wplab_albedo_core->default_options['footer_particles_animate_opacity']) . '"),
				"speed": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/animate_opacity/yes/speed', $wplab_albedo_core->default_options['footer_particles_animate_opacity_speed']) . ',
				"opacity_min": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/animate_opacity/yes/size_min', $wplab_albedo_core->default_options['footer_particles_animate_opacity_size_min']) . ',
				"sync": window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'footer_media_effect/particles/animate_opacity/yes/sync', $wplab_albedo_core->default_options['footer_particles_animate_opacity_sync']) . '")
			}
			},
			"size": {
			"value": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/size', $wplab_albedo_core->default_options['footer_particles_size']) . ',
			"random":window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'footer_media_effect/particles/size_rand', $wplab_albedo_core->default_options['footer_particles_size_rand']) . '"),
			"anim": {
				"enable": window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'footer_media_effect/particles/animate_size/enabled', $wplab_albedo_core->default_options['footer_particles_animate_size']) . '"),
				"speed": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/animate_size/yes/speed', $wplab_albedo_core->default_options['footer_particles_animate_size_speed']) . ',
				"size_min": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/animate_size/yes/size_min', $wplab_albedo_core->default_options['footer_particles_animate_size_min']) . ',
				"sync": window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'footer_media_effect/particles/animate_size/yes/sync', $wplab_albedo_core->default_options['footer_particles_animate_sync']) . '")
			}
			},
			"line_linked": {
			"enable": window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'footer_media_effect/particles/lines/enabled', $wplab_albedo_core->default_options['footer_particles_lines']) . '"),
			"distance": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/lines/yes/distance', $wplab_albedo_core->default_options['footer_particles_lines_distance']) . ',
			"color": "' . fw_get_db_customizer_option( 'footer_media_effect/particles/lines/yes/color', $wplab_albedo_core->default_options['footer_particles_lines_color']) . '",
			"opacity": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/lines/yes/opacity', $wplab_albedo_core->default_options['footer_particles_lines_opacity']) . ',
			"width": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/lines/yes/width', $wplab_albedo_core->default_options['footer_particles_lines_width']) . '
			},
			"move": {
			"enable":window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'footer_media_effect/particles/move/enabled', $wplab_albedo_core->default_options['footer_particles_move']) . '"),
			"speed": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/move/yes/speed', $wplab_albedo_core->default_options['footer_particles_move_speed']) . ',
			"direction":"' . fw_get_db_customizer_option( 'footer_media_effect/particles/move/yes/direction', $wplab_albedo_core->default_options['footer_particles_move_direction']) . '",
			"random":window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'footer_media_effect/particles/move/yes/rand', $wplab_albedo_core->default_options['footer_particles_move_rand']) . '"),
			"straight":window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'footer_media_effect/particles/move/yes/straight', $wplab_albedo_core->default_options['footer_particles_move_straight']) . '"),
			"out_mode":"' . fw_get_db_customizer_option( 'footer_media_effect/particles/move/yes/out_mode', $wplab_albedo_core->default_options['footer_particles_move_out_mode']) . '",
			"bounce":false,
			"attract": {
				"enable": false
			}
			}
			},
			"interactivity": {
			"detect_on":"canvas",
			"events": {
			"onhover": {
				"enable": window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'footer_media_effect/particles/onhover/enabled', $wplab_albedo_core->default_options['footer_particles_onhover']) . '"),
				"mode": "' . fw_get_db_customizer_option( 'footer_media_effect/particles/onhover/yes/mode', $wplab_albedo_core->default_options['footer_particles_onhover_mode']) . '"
			},
			"onclick": {
				"enable": window.themeFrontCore.stringToBoolean("' . fw_get_db_customizer_option( 'footer_media_effect/particles/onclick/enabled', $wplab_albedo_core->default_options['footer_particles_onclick']) . '"),
				"mode": "' . fw_get_db_customizer_option( 'footer_media_effect/particles/onclick/yes/mode', $wplab_albedo_core->default_options['footer_particles_onclick_mode']) . '"
			},
			"resize":true
			},
			"modes": {
			"grab": {
				"distance":' . fw_get_db_customizer_option( 'footer_media_effect/particles/grab_distance', $wplab_albedo_core->default_options['footer_particles_grab_distance']) . ',
				"line_linked": {
					"opacity": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/grab_opacity', $wplab_albedo_core->default_options['footer_particles_grab_opacity']) . '
				}
			},
			"bubble": {
				"distance": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/bubble_distance', $wplab_albedo_core->default_options['footer_particles_bubble_distance']) . ',
				"size": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/bubble_size', $wplab_albedo_core->default_options['footer_particles_bubble_size']) . ',
				"duration": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/bubble_duration', $wplab_albedo_core->default_options['footer_particles_bubble_duration']) . ',
				"opacity": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/bubble_opacity', $wplab_albedo_core->default_options['footer_particles_bubble_opacity']) . ',
				"speed": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/bubble_speed', $wplab_albedo_core->default_options['footer_particles_bubble_speed']) . '
			},
			"repulse": {
				"distance": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/repulse_distance', $wplab_albedo_core->default_options['footer_particles_repulse_distance']) . ',
				"duration": ' . fw_get_db_customizer_option( 'footer_media_effect/particles/repulse_duration', $wplab_albedo_core->default_options['footer_particles_repulse_duration']) . '
			},
			"push": {
				"particles_nb": 4
			},
			"remove": {
				"particles_nb": 2
			}
			}
			}
			,
			"retina_detect":true
			}); }, 800);
			';

			wp_add_inline_script( 'particles', $script );
		}

		public static function get_avatar_url( $get_avatar ){
			preg_match("/src='(.*?)'/i", $get_avatar, $matches);
			return $matches[1];
		}

		/**
		 * Display tags list
		 **/
		public static function tags_links() {
			$tags_list = self::get_valid_tags_list();
			if( $tags_list <> '' ):
			?>
			<div class="tags-list">
				<?php
					echo '<strong>' . esc_html__('Tags', 'albedo') . ':</strong> ';
					echo $tags_list;
				?>
			</div>
			<?php
			endif;
		}

		public static function get_valid_tags_list( $separator = ', ' ) {
			$s = str_replace( ' rel="tag"', '', get_the_tag_list( '', $separator, '' ) );
			return $s;
		}

		/**
		 * Display categories
		 **/
		public static function get_categories( $separator = ', ' ) {
			$post_type = get_post_type();

			switch( $post_type ) {
				default:
				case 'post':
					return self::get_valid_category_list( $separator );
				break;
				case 'fw-portfolio':
					return get_the_term_list( get_the_ID(), 'fw-portfolio-category', '', $separator, '' );
				break;
			}
		}

		public static function get_valid_category_list( $separator = ', ' ) {
			$s = str_replace( ' rel="category"', '', get_the_category_list( $separator ) );
			$s = str_replace( ' rel="category tag"', '', $s );
			return $s;
		}

	}
