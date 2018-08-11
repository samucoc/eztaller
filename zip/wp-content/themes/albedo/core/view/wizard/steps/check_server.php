<h1><?php esc_html_e( 'Checking Server Environment', 'albedo' ); ?></h1>

<p><?php esc_html_e( 'Here we are checking your server environment for possible issues. Please make sure that your server meets the minimum requirements to avoid a low performance and troubles using this theme. If your server does not meet the minimum requirements, we can not guarantee that this theme will work as quickly as on our demo.', 'albedo' ); ?></p>

<table class="table-wizard">
	<tr>
		<th><?php esc_html_e( 'PHP Version', 'albedo'); ?>:</th>
		<td>
			<?php if( version_compare( PHP_VERSION, '7.0.0', '<' ) ): ?>

			<span style="color: red"><?php esc_html_e( 'You are using outdated version of PHP.', 'albedo'); ?></span>
			<br />
			<?php esc_html_e( 'Did you know than PHP7 works on 30% faster? Your PHP version:', 'albedo'); ?> <?php echo PHP_VERSION; ?>
			<br />
			<?php printf( wp_kses_post( __( 'Ask your hosting provider to update PHP version. We recommend <a href="%s" target="_blank">InMotion Hosting</a> with PHP7 and SSD drives for maxium speed at a good price.', 'albedo') ), 'https://goo.gl/Xfif6g' ); ?>

			<?php else: ?>

			<span style="color: green"><?php esc_html_e( 'Everything is fine here, your PHP version is', 'albedo'); ?> <?php echo PHP_VERSION; ?></span>

			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<?php
			global $wpdb;
			$mysql_version = $wpdb->get_var( 'SELECT VERSION();' );
		?>
		<th><?php esc_html_e( 'MySQL Version', 'albedo'); ?>:</th>
		<td>
			<?php if( version_compare( $mysql_version, '5.6.0', '<' ) ): ?>

			<span style="color: red"><?php esc_html_e( 'You are using outdated version of MySQL. Recommended version if 5.6 and higher.', 'albedo'); ?></span>
			<br />
			<?php esc_html_e( 'Your MySQL version:', 'albedo'); ?> <?php echo $mysql_version; ?>
			<br />
			<?php esc_html_e( 'Ask your hosting provider to update MySQL version.', 'albedo'); ?>

			<?php else: ?>

			<span style="color: green"><?php esc_html_e( 'Everything is fine here, your MySQL version is', 'albedo'); ?> <?php echo $mysql_version; ?></span>

			<?php endif; ?>
		</td>
	</tr>
	<tr>
		<th><?php esc_html_e( 'WordPress Memory limit', 'albedo'); ?>:</th>
		<td>

			<?php
				$ini_memory = ini_get('memory_limit');
				$memory_limit = wplab_albedo_utils::return_bytes( $ini_memory );
				if( $memory_limit < ( 128 * 1024 * 1024 ) ):
			?>

			<span style="color: red"><?php esc_html_e( 'Increase memory limit, it should be at least 128M for a good performane, and your memory limit is', 'albedo'); ?> <?php echo $ini_memory; ?></span>

			<br />
			<?php printf( wp_kses_post( __( 'Modify wp-config.php and <a href="%s" target="_blank">increase memory limit</a>.', 'albedo') ), 'https://docs.woocommerce.com/document/increasing-the-wordpress-memory-limit/' ); ?>

			<?php else: ?>

			<span style="color: green"><?php esc_html_e( 'Sounds good! Your memory limit is', 'albedo'); ?> <?php echo $ini_memory; ?></span>

			<?php endif; ?>

		</td>
	</tr>
	<tr>
		<th><?php esc_html_e( 'GZip', 'albedo'); ?>:</th>
		<td>

			<?php if( class_exists( 'ZipArchive' ) ): ?>
			<span style="color: green"><?php esc_html_e( 'GZip enabled', 'albedo'); ?></span>
			<?php else: ?>
			<p><span style="color: red"><?php esc_html_e( 'Disabled', 'albedo'); ?></span></p>
			<p><?php printf( wp_kses_post( __( 'Contact your hosting provide and ask him to enable server-side GZip. To check if GZip enabled <a href="%s" target="_blank">use this service</a>.', 'albedo') ), 'http://www.gidnetwork.com/tools/gzip-test.php' ); ?></p>
			<?php endif; ?>


		</td>
	</tr>
	<tr>
		<th><?php esc_html_e( 'CURL', 'albedo'); ?>:</th>
		<td>

			<?php if( function_exists('curl_version') ): ?>
			<span style="color: green"><?php esc_html_e( 'CURL enabled', 'albedo'); ?></span>
			<?php else: ?>
			<p><span style="color: red"><?php esc_html_e( 'CURL Disabled', 'albedo'); ?></span></p>
			<p><?php esc_html_e( 'Contact your hosting provide and ask him to enable CURL. It required to install demo data, activate your theme and auto-updates', 'albedo'); ?></p>
			<?php endif; ?>

		</td>
	</tr>
	<tr>
		<th><?php esc_html_e( 'PHP ZIP', 'albedo'); ?>:</th>
		<td>

			<?php if( extension_loaded('zip') ): ?>
			<span style="color: green"><?php esc_html_e( 'ZIP enabled', 'albedo'); ?></span>
			<?php else: ?>
			<p><span style="color: red"><?php esc_html_e( 'ZIP Disabled', 'albedo'); ?></span></p>
			<p><?php esc_html_e( 'Contact your hosting provide and ask him to enable PHP ZIP module. It required to install demo data.', 'albedo'); ?></p>
			<?php endif; ?>

		</td>
	</tr>
	<tr>
		<th><?php esc_html_e( 'WordPress Version', 'albedo'); ?>:</th>
		<td>
			<?php
				global $wp_version;
			?>
			<?php if( version_compare( $wp_version, '4.7.5', '>=' ) ): ?>
			<span style="color: green"><?php esc_html_e( 'Great! Your WordPress is up to date.', 'albedo'); ?></span>
			<?php else: ?>
			<p><span style="color: red"><?php esc_html_e( 'Your WordPress version is outdated.', 'albedo'); ?></span></p>
			<p><?php printf( wp_kses_post( __( 'Please <a href="%s" target="_blank">update</a> your WordPress to the latest version before using this theme.', 'albedo') ), 'https://wordpress.org/download/' ); ?></p>
			<?php endif; ?>

		</td>
	</tr>
</table>

<p><?php printf( wp_kses_post( __( 'We recommend <a href="%s" target="_blank">InMotion Hosting</a> with PHP7 and SSD drives for maxium speed at a good price.', 'albedo') ), 'https://goo.gl/OEEZtc' ); ?></p>

<p class="wplab-albedo-setup-actions step">
	<a href="<?php echo esc_url( $data['next_step_link'] ); ?>"
		 class="button-primary button button-large button-next"
		 data-callback="install_plugins"><?php esc_html_e( 'Continue', 'albedo' ); ?></a>
	<?php wp_nonce_field( 'wplab-albedo-wizard' ); ?>
</p>
