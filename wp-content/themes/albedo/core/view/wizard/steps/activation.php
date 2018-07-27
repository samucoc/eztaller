<h1><?php esc_html_e( 'Theme Activation', 'albedo' ); ?></h1>

<p><?php printf( __( 'Due to the <a href="%s">Theme Forest license terms</a>, <strong>you can use one theme license for one domain</strong>. If you plan to use this theme for several different domains, please, <a href="%s" target="_blank">purchase additional licenses</a> for each of them.', 'albedo'), 'https://themeforest.net/licenses/terms/regular/?ref=wplab', 'https://themeforest.net/user/wplab/portfolio/?ref=wplab' ); ?></p>

<p><?php esc_html_e( 'Once you activate your theme, you will be able to install demo content and receive auto-updates.', 'albedo' ); ?></p>

<?php if( function_exists('curl_version') ): ?>

<p><em><?php esc_html_e( 'On the next page you will be asked to Login with your ThemeForest account and grant permissions to activate this theme.', 'albedo' ); ?></em></p>

<?php if( isset( $_GET['error'] ) ): ?>

	<?php if( $_GET['error'] == 'oauth' ): ?>
		<p><strong style="color: red;"><?php esc_html_e( 'Error happened. Please try again, if the problem persists, contact to our support.', 'albedo' ); ?></strong></p>
	<?php endif; ?>

<?php endif; ?>

<form method="post">
	<p class="wplab-albedo-setup-actions step">
		<input type="submit" class="button-primary button button-large button-next" value="<?php esc_attr_e( 'Login with Envato Account', 'albedo' ); ?>" name="save_step" />
		<?php wp_nonce_field( 'wplab-albedo-wizard' ); ?>
	</p>
</form>
<?php else: ?>
	<p><strong style="color: red;"><?php esc_html_e( 'ERROR: It is not possible to activate the theme on your host since CURL Extension is disabled. Contact to your hosting provider and ask him to enable CURL, and then visit this screen again.', 'albedo' ); ?></strong></p>
<?php endif;
