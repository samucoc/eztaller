<h1><?php printf( esc_html__( 'Welcome to the Setup Wizard for %s theme', 'albedo' ), wp_get_theme() ); ?></h1>
<p><?php printf( __( 'Thank you for choosing <strong>%s &mdash; Advanced Creative Multi-Purpose Premium WordPress Theme</strong> from <a href="%s" target="_blank">WPlab</a>.', 'albedo' ), wp_get_theme(), 'https://themeforest.net/user/wplab/?ref=wplab' ); ?></p>
<p><?php esc_html_e( 'The quick setup wizard will help you configure your new website, it should only take above 5 minutes. Please note, that we recommend to install this theme on a clean WordPress installation.', 'albedo'); ?></p>
<p><?php esc_html_e( 'Once you done, you will be able to install any of available Demos and receive Auto Updates.', 'albedo' ); ?></p>
<p><?php esc_html_e( 'No time right now? If you don\'t want to go through the wizard, you can skip and return to the WordPress dashboard. Come back anytime if you change your mind!', 'albedo' ); ?></p>
<p class="wplab-albedo-setup-actions step">
	<a href="<?php echo esc_url( $data['next_step_link'] ); ?>"
		 class="button-primary button button-large button-next"><?php esc_html_e( 'Let\'s Go!', 'albedo' ); ?></a>
	<a href="<?php echo admin_url( '' ); ?>"
		 class="button button-large"><?php esc_html_e( 'Not right now', 'albedo' ); ?></a>
</p>
