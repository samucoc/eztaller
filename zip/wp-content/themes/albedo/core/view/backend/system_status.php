<?php
	$ini_memory = ini_get('memory_limit');
	$memory_limit = wplab_albedo_utils::return_bytes( $ini_memory );
?>
<div id="albedo-welcome-screen" class="wrap wplab-albedo-about-wrap">
	<img src="<?php echo get_template_directory_uri(); ?>/images/albedo.png" alt="" />

	<?php $theme = wp_get_theme(); ?>
	<div class="about-text">
		<p><?php esc_html_e( 'Universal Creative WordPress Theme', 'albedo' ); ?>. <strong>v<?php echo trim( $theme->get( 'Version' ) ); ?></strong></p>
	</div>

	<div class="welcome-section status">

		<div class="boxes full-width">
			<div class="boxes__box">
				<div class="boxes__text">

					<h3><?php esc_html_e( 'System status', 'albedo'); ?></h3>

					<p><?php esc_html_e( 'This information for our support service, please copy it and include within your tickets. It will help us resolve the problem and answer you much faster!', 'albedo'); ?></p>

					<?php
						global $wp_version, $wpdb;

						$theme_activated = wplab_albedo_utils::is_ad() ? 'Yes' : 'No';
						$debug_active = defined('WP_DEBUG') && WP_DEBUG ? 'Enabled' : 'Disabled';
						$gzip_active = class_exists( 'ZipArchive' ) ? 'Enabled' : 'Disabled';
						$child_active = is_child_theme() ? 'Active' : 'Not used';
						$zip_active = extension_loaded('zip') ? 'Enabled' : 'Disabled';
						$curl_active = function_exists('curl_version') ? 'Enabled' : 'Disabled';

						$plugins_list = array();
						$active_plugins = (array) get_option( 'active_plugins', array() );

						if ( is_multisite() ) {
							$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
						}

						foreach ( $active_plugins as $plugin) {
							$plugin_data = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
							if( $plugin_data['Name'] <> '' ) {
								$plugins_list[] = esc_html( $plugin_data['Name'] );
							}
						}

						$info = '
Website URL: ' . get_option('siteurl') . '
Home URL: ' . home_url() . '
Host: ' . $_SERVER['SERVER_NAME'] . '
Theme activated: ' . $theme_activated . '

WordPress version: ' . $wp_version . '
Active plugins: ' . implode(', ', $plugins_list) . '
Language: ' . get_locale() . '
WP Debug: ' . $debug_active . '

Albedo theme version: ' . wp_get_theme()->get('Version') . '
Child theme: ' . $child_active . '

Server software: ' . $_SERVER['SERVER_SOFTWARE'] . '
GZip: ' . $gzip_active . '
MySQL version: ' . $wpdb->get_var( 'SELECT VERSION();' ) . '
PHP version: ' . PHP_VERSION . '
PHP memory limit: ' . $ini_memory . '
PHP Zip: ' . $zip_active . '
CURL: ' . $curl_active . '
PHP post max size: ' . ini_get('post_max_size') . '
PHP max upload size: ' . size_format( wp_max_upload_size() ) . '
PHP max input vars: ' . ini_get('max_input_vars') . '
PHP max execution time: ' . ini_get('max_execution_time') . '
';
					?>
					<textarea readonly="readonly" style="width: 100%; height: 500px;"><?php echo wp_kses_post( $info ); ?></textarea>

				</div>
			</div>
		</div>

	</div>

</div>
