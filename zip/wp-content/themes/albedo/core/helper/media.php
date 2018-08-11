<?php
	/**
	 * Media helper
	 **/
	class wplab_albedo_media {

		/**
		 * Generate an image
		 **/
		public static function img( $instance = array() ) {
			if( ! class_exists( 'Aq_Resize' )) {
				require_once get_template_directory() . '/core/vendor/aq_resizer/aq_resizer.php';
			}

			$src = $src2x = $hd_str = $prefix = $suffix = '';

			$instance = wp_parse_args( (array) $instance, array(
				'url' => '',
				'url_hd' => '',
				'id' => null,
				'width' => null,
				'height' => null,
				'crop' => true,
				'hd' => true,
				'lazy' => false,
				'classes' => array(),
				'atts' => array()
			));

			if( empty( $instance['atts'] ) ) {
				$instance['atts'][] = 'alt=""';
			}

			if ( filter_var( $instance['url'], FILTER_VALIDATE_URL ) === FALSE ) {
				$protocol = is_ssl() ? 'https:' : 'http:';
				if( $instance['url'] <> '' ) {
					$instance['url'] = $protocol . $instance['url'];
				}
			}

			if ( filter_var( $instance['hd'], FILTER_VALIDATE_BOOLEAN ) && filter_var( $instance['url_hd'], FILTER_VALIDATE_URL ) === FALSE ) {
				$protocol = is_ssl() ? 'https:' : 'http:';
				if( $instance['url_hd'] <> '' ) {
					$instance['url_hd'] = $protocol . $instance['url_hd'];
				}
			}

			if( !is_null( $instance['width'] ) || !is_null( $instance['height'] ) ) {

				$instance['atts'][] = 'width="' . $instance['width'] . '"';
				if( $instance['height'] <> '' ) {
					$instance['atts'][] = 'height="' . $instance['height'] . '"';
				}

				$src = aq_resize( $instance['url'], $instance['width'], $instance['height'], $instance['crop'] );

				if( !$src ) {
					$src = $instance['url'];
				}

				if( $instance['hd'] ) {
					$hd_width = $instance['width'] * 2;
					$hd_height = $instance['height'] != null ? $instance['height'] * 2 : null;
					$src2x = aq_resize( $instance['url_hd'], $hd_width, $hd_height, $instance['crop'] );
					if( !$src2x ) {
						$src2x = $instance['url_hd'];
					} else {
						$hd_str = $instance['url_hd'];
					}
				}

			} else {

				$src = $instance['url'];
				$src2x = '';
				if( $src != $instance['url_hd'] ) {
					$src2x = $instance['url_hd'];
				}

			}

			$src = str_replace( 'https://', '//', str_replace( 'http://', '//', $src ) );
			$src2x = str_replace( 'https://', '//', str_replace( 'http://', '//', $src2x ) );

			$instance['atts'][] = 'data-src="' . esc_attr( $instance['url'] ) . '"';

			if( $instance['lazy'] && (wplab_albedo_utils::is_unyson() && filter_var( fw_get_db_customizer_option( 'lazy_loading' ), FILTER_VALIDATE_BOOLEAN ) === true ) ) {

				$prefix = '<span class="img-preloader">';
				$suffix = '</span>';

				$instance['classes'][] = 'b-lazy';
				$src = $instance['hd'] && $hd_str <> '' ? $src . '|' . $src2x : $src;
				$instance['atts'][] = 'src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="';
				$instance['atts'][] = 'data-lazy-src="' . esc_attr( $src ) . '"';

			} else {
				$instance['atts'][] = 'src="' . esc_attr( $src ) . '"';
				if( $instance['hd'] && $src2x <> '' ) {
					$instance['atts'][] = 'data-at2x="' . esc_attr( $src2x ) . '"';
				} else {
					$instance['atts'][] = 'data-no-retina';
				}

			}

			return $prefix . '<img class="' . implode( ' ', $instance['classes'] ) . '" ' . implode( ' ', $instance['atts'] ) . ' />' . $suffix;

		}

		/**
		 * Resize image
		 **/
		public static function img_resize( $url, $width, $height ) {
			if( ! class_exists( 'Aq_Resize' )) {
				require_once get_template_directory() . '/core/vendor/aq_resizer/aq_resizer.php';
			}

			$src = '';

			if ( filter_var( $url, FILTER_VALIDATE_URL ) === FALSE ) {
				$protocol = is_ssl() ? 'https:' : 'http:';
				if( $url <> '' ) {
					$url = $protocol . $url;
				}
			}

			$src = aq_resize( $url, $width, $height, true );

			if( !$src ) {
				$src = $url;
			}

			return $src;

		}

		/**
		 * Old function:
		 * Generate an image with necessary width, height and retina copy
		 * @param Image URL
		 * @param Image Width
		 * @param Image Height
		 * @param Image Crop
		 * @param Add HD image for retina.js
		 * @param Fallback thumbnail name
		 * @param Thumb id
		 **/
		public static function image( $url, $width = null, $height = null, $crop = true, $hd = true, $hd_url = '', $lazy = false, $classes = array(), $atts = array() ) {
			if( ! class_exists( 'Aq_Resize' )) {
				require_once get_template_directory() . '/core/vendor/aq_resizer/aq_resizer.php';
			}

			$src = $src2x = $hd_str = $prefix = $suffix = '';

			$atts = is_array( $atts ) && empty( $atts ) ? array( 'alt=""' ) : $atts;

			if ( filter_var( $url, FILTER_VALIDATE_URL ) === FALSE ) {
				$protocol = is_ssl() ? 'https:' : 'http:';
				if( $url <> '' ) {
					$url = $protocol . $url;
				}
			}

			if ( $hd && filter_var( $hd_url, FILTER_VALIDATE_URL ) === FALSE ) {
				$protocol = is_ssl() ? 'https:' : 'http:';
				if( $hd_url <> '' ) {
					$hd_url = $protocol . $hd_url;
				}
			}

			if( !is_null( $width ) || !is_null( $height ) ) {

				if( is_numeric( $width ) ) {
					$atts[] = 'width="' . $width . '"';
				}
				if( is_numeric( $height ) ) {
					$atts[] = 'height="' . $height . '"';
				}

				$src = aq_resize( $url, $width, $height, $crop );

				if( !$src ) {
					$src = $url;
				}

				if( $hd ) {
					$hd_width = $width * 2;
					$hd_height = $height != null ? $height * 2 : null;
					$src2x = aq_resize( $hd_url, $hd_width, $hd_height, $crop );
					if( !$src2x ) {
						$src2x = $hd_url;
					} else {
						$hd_str = $hd_url;
					}
				}

			} else {

				$src = $url;
				$src2x = '';
				if( $src != $hd_url ) {
					$src2x = $hd_url;
				}

			}

			$src = str_replace( 'https://', '//', str_replace( 'http://', '//', $src ) );
			$src2x = str_replace( 'https://', '//', str_replace( 'http://', '//', $src2x ) );

			$atts[] = 'data-src="' . esc_attr( $src ) . '"';

			if( $lazy && (wplab_albedo_utils::is_unyson() && filter_var( fw_get_db_customizer_option( 'lazy_loading' ), FILTER_VALIDATE_BOOLEAN ) === true ) ) {

				$prefix = '<span class="img-preloader">';
				$suffix = '</span>';

				$classes[] = 'b-lazy';
				$src = $hd && $hd_str <> '' ? $src . '|' . $src2x : $src;
				$atts[] = 'src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="';
				$atts[] = 'data-lazy-src="' . esc_attr( $src ) . '"';

			} else {
				$atts[] = 'src="' . esc_attr( $src ) . '"';
				if( $hd && $src2x <> '' ) {
					$atts[] = 'data-at2x="' . esc_attr( $src2x ) . '"';
				} else {
					$atts[] = 'data-no-retina';
				}
			}

			return $prefix . '<img class="' . implode( ' ', $classes ) . '" ' . implode( ' ', $atts ) . ' />' . $suffix;

		}

		/**
		 * Get YouTube Video ID From URL
		 * @param string
		 **/
		public static function getYouTubeVideoId( $url ) {
			$video_id = false;
			$url = parse_url($url);
			if ( isset( $url['host'] ) && strcasecmp($url['host'], 'youtu.be') === 0) {
				#### (dontcare)://youtu.be/<video id>
				$video_id = substr($url['path'], 1);
			} elseif ( isset( $url['host'] ) && strcasecmp($url['host'], 'www.youtube.com') === 0) {
				if (isset($url['query'])) {
					parse_str($url['query'], $url['query']);
					if (isset($url['query']['v'])) {
						#### (dontcare)://www.youtube.com/(dontcare)?v=<video id>
						$video_id = $url['query']['v'];
					}
				}
				if ($video_id == false) {
					$url['path'] = explode('/', substr($url['path'], 1));
					if (in_array($url['path'][0], array('e', 'embed', 'v'))) {
						#### (dontcare)://www.youtube.com/(whitelist)/<video id>
						$video_id = $url['path'][1];
					}
				}
			}
			return $video_id;
		}

		/**
		 * Get Vimeo Video ID From URL
		 * @param string
		 **/
		function getVimeoVideoId( $url ){
			return preg_replace("/[^\/]+[^0-9]|(\/)/", "", rtrim( $url, "/"));
		}

		/**
		 * Echo image SRC based on file type
		 * @param array
		 * @param string
		 **/
		public static function image_src( $image, $fallback = '' ) {

			if( is_array( $image ) && !empty( $image ) ) {

				$file = get_attached_file( $image['attachment_id'] );
				$info = pathinfo( $file );

				if( $info['extension'] == 'svg' ) {
					echo '<img src="' . esc_attr( $image['url'] ) . '" class="image-svg" alt="" />';
				} else {
					echo '<img src="' . esc_attr( $image['url'] ) . '" alt="" />';
				}

			} elseif( is_numeric( $image )) {

				$url = wp_get_attachment_url( $image );
				$file = get_attached_file( $image );
				$info = pathinfo( $file );

				if( $info['extension'] == 'svg' ) {
					echo '<img src="' . esc_attr( $url ) . '" class="image-svg" alt="" />';
				} else {
					echo '<img src="' . esc_attr( $url ) . '" alt="" />';
				}

			} elseif( $fallback <> '' ) {
				echo '<img src="' . esc_attr( $fallback ) . '" class="image-svg" alt="" />';
			}

		}

		/**
		 * Get post media from content
		 **/
		public static function get_media( $post_format ) {
			$header_media = '';
			if( in_array( $post_format, array( 'video', 'audio' ) )) {
				$post_content = get_post_field( 'post_content', get_the_ID() );

				$media = get_media_embedded_in_content( $post_content );
				if( isset( $media[0] ) && $media[0] <> '' ) {
					$header_media = $media[0];
				} else {
					$media_arr = preg_match('~\[vc_video\s+link\s*=\s*("|\')(?<url>.*?)\1\s*\]~i', $post_content, $matches );
					if( isset( $matches['url'] ) && $matches['url'] <> '' ) {
						$header_media = do_shortcode('[vc_video link="' . $matches['url'] . '"]');
					}
				}

			}
			return $header_media;
		}

		/**
		 * Get post gallery shortcode
		 **/
		public static function get_gallery() {
			$post_gallery = '';
			$content = get_post_field( 'post_content', get_the_ID() );

			if( has_shortcode( $content, 'gallery') ) {
				$post_gallery_arr = preg_match('/\[gallery.*ids=[^\]]+\]/', $content, $matches);
				$post_gallery = isset( $matches[0] ) ? $matches[0] : '';

			}
			return $post_gallery;
		}

		/**
		 * Do Gallery shortcode for AJAX requests
		 **/
		public static function gallery_shortcode( $params = array() ) {
			global $wplab_albedo_core;

			$post_id = get_the_ID();
			$is_single = is_single();
			preg_match('/\[gallery.*ids=.(.*).\]/', get_post_field( 'post_content', $post_id ), $ids );
			if( isset( $ids[1] ) && $ids[1] <> '' ) {

				$gallery_ids = explode( ',', $ids[1] );

				$args = array(
					'post_type' => 'attachment',
					'numberposts' => -1,
					'post_status' => null
				);

				if( is_array( $gallery_ids ) && count( $gallery_ids ) > 0 ) {
					$args['include'] = $gallery_ids;
				} else {
					$args['post_parent'] = get_the_ID();
				}

				$attachments = get_posts( $args );

				if( count( $attachments ) > 0 && is_array( $attachments ) ) {

					ob_start();

					?>
					<div id="<?php echo esc_attr( uniqid( 'post-gallery-carousel-id-') . $post_id ); ?>" class="post-gallery-carousel">
						<div class="swiper-container">
							<div class="swiper-wrapper">
								<?php foreach( $attachments as $item ): ?>
								<div class="swiper-slide">
									<?php if( !$is_single ): ?><a href="<?php echo get_permalink( $post_id ); ?>"><?php endif; ?>
									<div class="overlay"></div>
									<?php
										$image = wp_get_attachment_image_src( $item->ID, 'full' );

										if( isset( $params['thumbs_dimensions'] ) && $params['thumbs_dimensions'] == 'crop' ) {
											echo wplab_albedo_media::image( $image[0], $params['thumbs_width'], $params['thumbs_height'], true, true, $image[0], false, array(), array('alt="' . esc_attr( get_the_title( $item->ID ) ) . '"') );
										} else {
											echo '<img src="' . $image[0] . '" alt="" />';
										}

									?>
									<?php if( !$is_single ): ?></a><?php endif; ?>
								</div>
								<?php endforeach; ?>
							</div>

						</div>
						<div class="swiper-pagination"></div>
					</div>
					<?php

					return ob_get_clean();

				}

			}

		}

		/**
		 * Get first photo from content
		 **/
		public static function get_photo( $content ) {
			preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', $content, $matches );
			$image = false;
			if ( isset( $matches ) ) {
				$image = $matches[1][0];
			}
			return $image;
		}

	}
