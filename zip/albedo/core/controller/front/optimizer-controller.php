<?php

/**
 * Optimizer controller
 * based on https://github.com/kasparsd/minit
 **/
class wplab_albedo_optimizer_controller {

	protected $done = array();
	protected $async_queue = array();
	protected $exclude_css = array( 'wplab-albedo-style', 'albedo-ie-fix' );
	protected $exclude_js = array();

	function __construct() {

		add_action( 'init', array( $this, 'init_optimizer' ));

		// Purge the combined styles cache
		add_action( 'wp_ajax_wplab_albedo_purge_combined_assets', array( $this, 'purge_combined_assets' ) );

	}

	/**
	 * Init the optimizer
	 **/
	function init_optimizer() {

		// If Unyson Plugin active only
		if( wplab_albedo_utils::is_unyson() ) {

			// get excluded libraries
			$this->get_excluded();

			/*
			if( filter_var( fw_get_db_settings_option( 'combine_js/enabled' ), FILTER_VALIDATE_BOOLEAN ) ) {
				add_filter( 'print_scripts_array', array( $this, 'combine_js' ) );

				// Print external scripts asynchronously in the footer
				add_action( 'wp_print_footer_scripts', array( $this, 'async_init' ), 1 );
				add_action( 'wp_print_footer_scripts', array( $this, 'async_print' ), 2 );

				add_filter( 'script_loader_tag', array( $this, 'script_tag_async' ), 20, 3 );
			}
			*/

			if( filter_var( fw_get_db_settings_option( 'combine_css/enabled' ), FILTER_VALIDATE_BOOLEAN ) ) {
				add_filter( 'print_styles_array', array( $this, 'combine_css' ) );
			}

			// Prepend the filename of the file being included
			add_filter( 'theme-combine-item-css', array( $this, 'comment_combined' ), 15, 3 );
			add_filter( 'theme-combine-item-js', array( $this, 'comment_combined' ), 15, 3 );

			// Add table of contents at the top of the combined file
			add_filter( 'theme-combine-content-css', array( $this, 'add_toc' ), 100, 2 );
			add_filter( 'theme-combine-content-js', array( $this, 'add_toc' ), 100, 2 );

			// Turn all local asset URLs into absolute URLs
			add_filter( 'theme-combine-item-css', array( $this, 'resolve_css_urls' ), 10, 3 );

			// Add support for relative CSS imports
			add_filter( 'theme-combine-item-css', array( $this, 'resolve_css_imports' ), 10, 3 );

			// Exclude styles with media queries from being included
			add_filter( 'theme-combine-item-css', array( $this, 'exclude_css_with_media_query' ), 10, 3 );

			// Make sure that all combined files are served from the correct protocol
			add_filter( 'theme-combine-url-css', array( $this, 'maybe_ssl_url' ) );
			add_filter( 'theme-combine-url-js', array( $this, 'maybe_ssl_url' ) );

		}

	}

	/**
	 * Get excluded files
	 **/
	function get_excluded() {

		$excluded_css = fw_get_db_settings_option( 'combine_css/yes/combibe_css_exclude' );
		$excluded_js = fw_get_db_settings_option( 'combine_js/yes/combibe_js_exclude' );

		$this->exclude_css = $this->exclude_css + explode( "\r\n", $excluded_css );
		$this->exclude_js = $this->exclude_js + explode( "\r\n", $excluded_js );

	}

	/**
	 * Combine JavaScript files
	 **/
	function combine_js( $todo ) {
		global $wp_scripts;
		return $this->combine_objects( $wp_scripts, $todo, 'js' );

	}

	/**
	 * Combine CSS files
	 **/
	function combine_css( $todo ) {
		global $wp_styles;
		return $this->combine_objects( $wp_styles, $todo, 'css' );

	}

	function combine_objects( &$object, $todo, $extension ) {
		global $wplab_albedo_core;

		// Don't run if already processed
		if ( empty( $todo ) ) {
			return $todo;
		}

		// Allow files to be excluded
		if( $extension == 'css' ) {
			$exclude = $this->exclude_css;
		} elseif( $extension == 'js' ) {
			$exclude = $this->exclude_js;
		}

		if ( ! is_array( $exclude ) ) {
			$exclude = array();
		}

		// Exluce all combine items by default
		$exclude = array_merge( $exclude, $this->get_done() );

		$min_todo = array_diff( $todo, $exclude );

		$_albedo_only_todo = $_min_todo = array();

		foreach( $min_todo as $script ) {
			if( strpos( $script, 'wplab-albedo') !== false ) {
				$_albedo_only_todo[] = $script;
			}
		}

		foreach( $_albedo_only_todo as $script ) {
			if( strpos( $script, 'wplab-albedo-combined-') === false ) {
				$_min_todo[] = $script;
			}
		}

		$min_todo = $_min_todo;

		if ( empty( $min_todo ) ) {
			return $todo;
		}

		$done = array();
		$ver = array();

		// Bust cache on update
		$ver[] = 'min-ver-1.0';

		// Use different cache key for SSL and non-SSL
		$ver[] = 'is_ssl-' . is_ssl();

		// Use a global cache version key to purge cache
		$ver[] = 'wplab_albedo_min_cache_ver-' . get_option( 'wplab_albedo_min_cache_ver' );

		// Use script version to generate a cache key
		foreach ( $min_todo as $t => $script ) {
			if( isset( $object->registered[ $script ] ) ) {
				$ver[] = sprintf( '%s-%s', $script, $object->registered[ $script ]->ver );
			}
		}

		$cache_ver = md5( 'min-' . implode( '-', $ver ) . $extension );

		// Try to get queue from cache
		$cache = get_transient( 'wplab-albedo-min-' . $cache_ver );

		if ( isset( $cache['cache_ver'] ) && $cache['cache_ver'] == $cache_ver && file_exists( $cache['file'] ) ) {
			return $this->enqueue_files( $object, $cache );
		}

		foreach ( $min_todo as $script ) {

			// Get the relative URL of the asset
			$src = self::get_asset_relative_path(
				$object->base_url,
				$object->registered[ $script ]->src
			);

			// Add support for pseudo packages such as jquery which return src as empty string
			if ( empty( $object->registered[ $script ]->src ) || '' == $object->registered[ $script ]->src ) {
				$done[ $script ] = null;
			}

			// Skip if the file is not hosted locally
			if ( ! $src || ! file_exists( ABSPATH . $src ) ) {
				continue;
			}

			$script_content = apply_filters(
				'min-item-' . $extension,
				$wplab_albedo_core->controller->io->read( ABSPATH . $src ),
				$object,
				$script
			);

			if ( false !== $script_content ) {
				$done[ $script ] = $script_content;
			}

		}

		if ( empty( $done ) ) {
			return $todo;
		}

		$wp_upload_dir = wp_upload_dir();

		// Try to create the folder for cache
		$tpl_title = get_stylesheet();

		if ( ! is_dir( $wp_upload_dir['basedir'] . '/combined/' . $tpl_title ) ) {
			if ( ! @mkdir( $wp_upload_dir['basedir'] . '/combined/' . $tpl_title ) ) {
				return $todo;
			}
		}

		$combined_file_path = sprintf( '%s/combined/%s/%s.%s', $wp_upload_dir['basedir'], $tpl_title, $cache_ver, $extension );
		$combined_file_url = sprintf( '%s/combined/%s/%s.%s', $wp_upload_dir['baseurl'], $tpl_title, $cache_ver, $extension );

		// Allow other plugins to do something with the resulting URL
		$combined_file_url = apply_filters( 'wplab-albedo-combine-url-' . $extension, $combined_file_url, $done );

		// Allow other plugins to minify and obfuscate
		$done_imploded = apply_filters( 'wplab-albedo-combine-content-' . $extension, implode( "\n\n", $done ), $done );

		// Store the combined file on the filesystem
		if ( ! file_exists( $combined_file_path ) ) {
			$wplab_albedo_core->controller->io->write( $combined_file_path, $done_imploded );
		}

		$status = array(
			'cache_ver' => $cache_ver,
			'todo' => $todo,
			'done' => array_keys( $done ),
			'url' => $combined_file_url,
			'file' => $combined_file_path,
			'extension' => $extension
		);

		// Cache this set of scripts, by default for 24 hours
		$cache_expiration = absint( fw_get_db_settings_option( 'combined_cache_expire' ) );
		set_transient( 'wplab-albedo-min-' . $cache_ver, $status, $cache_expiration );

		$this->set_done( $cache_ver );

		return $this->enqueue_files( $object, $status );

	}

	function enqueue_files( &$object, $status ) {
		global $wplab_albedo_core;
		extract( $status );

		switch ( $extension ) {

			case 'css':

				wp_enqueue_style(
					'wplab-albedo-combined-' . $cache_ver,
					$url,
					null,
					null
				);

				// Add inline styles for all minited styles
				foreach ( $done as $script ) {

					$inline_style = $object->get_data( $script, 'after' );

					if ( empty( $inline_style ) ) {
						continue;
					}

					if ( is_string( $inline_style ) ) {
						$object->add_inline_style( 'wplab-albedo-combined-' . $cache_ver, $inline_style );
					} elseif ( is_array( $inline_style ) ) {
						$object->add_inline_style( 'wplab-albedo-combined-' . $cache_ver, implode( ' ', $inline_style ) );
					}

				}

				$latest_style = end( $done );

				wp_add_inline_style( $latest_style, $wplab_albedo_core->controller->front->inline_css );

				if( wplab_albedo_utils::is_unyson() ) {
					wp_add_inline_style( $latest_style, fw_get_db_customizer_option( 'custom_css_code', '') );
				}

				break;

			case 'js':

				wp_enqueue_script(
					'wplab-albedo-combined-' . $cache_ver,
					$url,
					null,
					null,
					apply_filters( 'wplab-albedo-combine-js-in-footer', true )
				);

				// Add to the correct
				$object->set_group(
					'albedo-combined-' . $cache_ver,
					false,
					apply_filters( 'wplab-albedo-combine-js-in-footer', true )
				);

				$inline_data = array();

				// Add inline scripts for all minited scripts
				foreach ( $done as $script ) {
					$inline_data[] = $object->get_data( $script, 'data' );
				}

				// Filter out empty elements
				$inline_data = array_filter( $inline_data );

				if ( ! empty( $inline_data ) ) {
					$object->add_data( 'wplab-albedo-combined-' . $cache_ver, 'data', implode( "\n", $inline_data ) );
				}

				break;

			default:

				return $todo;

		}

		// Remove scripts that were merged
		$todo = array_diff( $todo, $done );

		$todo[] = 'wplab-albedo-combined-' . $cache_ver;

		// Mark these items as done
		$object->done = array_merge( $object->done, $done );

		// Remove combined items from the queue
		$object->queue = array_diff( $object->queue, $done );

		return $todo;

	}


	function set_done( $handle ) {
		$this->done[] = 'wplab-albedo-combined-' . $handle;
	}


	function get_done() {
		return $this->done;
	}


	public static function get_asset_relative_path( $base_url, $item_url ) {

		// Remove protocol reference from the local base URL
		$base_url = preg_replace( '/^(https?:\/\/|\/\/)/i', '', $base_url );

		// Check if this is a local asset which we can include
		$src_parts = explode( $base_url, $item_url );

		// Get the trailing part of the local URL
		$maybe_relative = end( $src_parts );

		if ( ! file_exists( ABSPATH . $maybe_relative ) ) {
			return false;
		}

		return $maybe_relative;

	}

	function async_init() {

		global $wp_scripts;

		if ( ! is_object( $wp_scripts ) || empty( $wp_scripts->queue ) ) {
			return;
		}

		$base_url = site_url();
		$min_exclude = (array) apply_filters( 'wplab-albedo-combine-exclude-js', array() );

		foreach ( $wp_scripts->queue as $handle ) {

			// Skip asyncing explicitly excluded script handles
			if ( in_array( $handle, $min_exclude ) ) {
				continue;
			}

			$script_relative_path = self::get_asset_relative_path(
				$base_url,
				$wp_scripts->registered[$handle]->src
			);

			if ( ! $script_relative_path ) {
				// Add this script to our async queue
				$this->async_queue[] = $handle;

				// Remove this script from being printed the regular way
				wp_dequeue_script( $handle );
			}

		}

	}

	function async_print() {

		global $wp_scripts;

		if ( empty( $this->async_queue ) ) {
			return;
		}

		?>
		<!-- Asynchronous scripts by Theme -->
		<script id="min-async-scripts" type="text/javascript">
		(function() {
			var js, fjs = document.getElementById('min-async-scripts'),
				add = function( url, id ) {
					js = document.createElement('script');
					js.type = 'text/javascript';
					js.src = url;
					js.async = true;
					js.id = id;
					fjs.parentNode.insertBefore(js, fjs);
				};
			<?php
			foreach ( $this->async_queue as $handle ) {
				printf(
					'add("%s", "%s"); ',
					$wp_scripts->registered[$handle]->src,
					'async-script-' . esc_attr( $handle )
				);
			}
			?>
		})();
		</script>
		<?php

	}

	function script_tag_async( $tag, $handle, $src ) {

		// Allow others to disable this feature
		if ( ! apply_filters( 'wplab-albedo-combine-script-tag-async', true ) ) {
			return $tag;
		}

		// Do this for minified scripts only
		if ( false === stripos( $handle, 'wplab-albedo-combined-' ) ) {
			return $tag;
		}

		// Bail if async is already set
		if ( false !== stripos( $tag, ' async' ) ) {
			return $tag;
		}

		return str_ireplace( '<script ', '<script async ', $tag );

	}

	function comment_combined( $content, $object, $script ) {
		if ( ! $content ) {
			return $content;
		}

		return sprintf(
			"\n\n/* Combined files: %s */\n",
			$object->registered[ $script ]->src
		) . $content;
	}

	function add_toc( $content, $items ) {
		if ( ! $content || empty( $items ) ) {
			return $content;
		}

		$toc = array();

		foreach ( $items as $handle => $item_content ) {
			$toc[] = sprintf( ' - %s', $handle );
		}

		return sprintf( "/* TOC:\n%s\n*/", implode( "\n", $toc ) ) . $content;
	}

	function resolve_css_urls( $content, $object, $script ) {
		if ( ! $content ) {
			return $content;
		}

		$src = Minit::get_asset_relative_path(
			$object->base_url,
			$object->registered[ $script ]->src
		);

		// Make all local asset URLs absolute
		$content = preg_replace(
			'/url\(["\' ]?+(?!data:|https?:|\/\/)(.*?)["\' ]?\)/i',
			sprintf( "url('%s/$1')", $object->base_url . dirname( $src ) ),
			$content
		);

		return $content;
	}

	function resolve_css_imports( $content, $object, $script ) {
		if ( ! $content ) {
			return $content;
		}

		$src = self::get_asset_relative_path(
			$object->base_url,
			$object->registered[ $script ]->src
		);

		// Make all import asset URLs absolute
		$content = preg_replace(
			'/@import\s+(url\()?["\'](?!https?:|\/\/)(.*?)["\'](\)?)/i',
			sprintf( "@import url('%s/$2')", $object->base_url . dirname( $src ) ),
			$content
		);

		return $content;
	}

	function exclude_css_with_media_query( $content, $object, $script ) {
		if ( ! $content ) {
			return $content;
		}

		$whitelist = array( '', 'all', 'screen' );

		// Exclude from Minit if media query specified
		if ( ! in_array( $object->registered[ $script ]->args, $whitelist ) ) {
			return false;
		}

		return $content;
	}

	function maybe_ssl_url( $url ) {
		if ( is_ssl() ) {
			return str_replace( 'http://', 'https://', $url );
		}

		return $url;
	}


	/**
	 * Purge the cache
	 **/
	function purge_combined_assets() {
		update_option( 'wplab_albedo_min_cache_ver', time() );

		$wp_upload_dir = wp_upload_dir();
		$minit_files = glob( $wp_upload_dir['basedir'] . '/combined/' . get_stylesheet() . '/*' );

		if ( $minit_files ) {
			foreach ( $minit_files as $minit_file ) {
				@unlink( $minit_file );
			}
		}

		exit;

	}

}
