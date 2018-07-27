<?php

	tgmpa_load_bulk_installer();
	$url     = wp_nonce_url( add_query_arg( array( 'plugins' => 'go' ) ), 'envato-setup' );
	$plugins = $data['plugins'];

	// copied from TGM

	$method = ''; // Leave blank so WP_Filesystem can populate it as necessary.
	$fields = array_keys( $_POST ); // Extra fields to pass to WP_Filesystem.

	if ( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, $fields ) ) ) {
		return true; // Stop the normal page form from displaying, credential request form will be shown.
	}

	// Now we have some credentials, setup WP_Filesystem.
	if ( ! WP_Filesystem( $creds ) ) {
		// Our credentials were no good, ask the user for them again.
		request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, $fields );

		return true;
	}

	/* If we arrive here, we have the filesystem */

?>
<h1><?php esc_html_e( 'Default Plugins', 'albedo' ); ?></h1>
<form method="post">

	<?php
	if ( count( $plugins['all'] ) ) {
		?>
		<p><?php esc_html_e( 'Your website needs a few essential plugins. The following plugins will be installed or updated:', 'albedo' ); ?></p>
		<ul class="envato-wizard-plugins">
			<?php foreach ( $plugins['all'] as $slug => $plugin ) { ?>
				<li data-slug="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $plugin['name'] ); ?>
					<span>
						<?php
							$keys = array();
							if ( isset( $plugins['install'][ $slug ] ) ) {
								$keys[] = 'Installation';
							}
							if ( isset( $plugins['update'][ $slug ] ) ) {
								$keys[] = 'Update';
							}
							if ( isset( $plugins['activate'][ $slug ] ) ) {
								$keys[] = 'Activation';
							}
							echo implode( ' and ', $keys ) . ' required';
						?>
					</span>
					<div class="spinner"></div>
				</li>
			<?php } ?>
		</ul>
		<?php
	} else {
		echo '<p><strong>' . esc_html__( 'Good news! All plugins are already installed and up to date. Please continue.', 'albedo' ) . '</strong></p>';
	} ?>

	<p><?php esc_html_e( 'You can add and remove plugins later on from within WordPress.', 'albedo' ); ?></p>

	<p class="wplab-albedo-setup-actions step">
		<a href="<?php echo esc_url( $data['next_step_link'] ); ?>"
			 class="button-primary button button-large button-next"
			 data-callback="install_plugins"><?php esc_html_e( 'Continue', 'albedo' ); ?></a>
		<?php wp_nonce_field( 'wplab-albedo-wizard' ); ?>
	</p>
</form>
