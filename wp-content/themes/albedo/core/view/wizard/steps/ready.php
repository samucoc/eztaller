<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://themeforest.net/user/wplab/portfolio?ref=wplab" data-text="<?php echo esc_attr( 'I have just installed the #' . wp_get_theme() . ' #WordPress theme from #ThemeForest' ); ?>" data-via="EnvatoMarket" data-size="large">Tweet</a>
<script type="text/javascript">
	!function (d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (!d.getElementById(id)) {
			js = d.createElement(s);
			js.id = id;
			js.src = "//platform.twitter.com/widgets.js";
			fjs.parentNode.insertBefore(js, fjs);
		}
	}(document, "script", "twitter-wjs");
</script>

<h1><?php esc_html_e( 'Installation finished!', 'albedo' ); ?></h1>

<p><?php esc_html_e( 'Congratulations! The theme has been activated and your website is ready to install demo data and customizations! Login to your WordPress dashboard to make changes and modify any of the default content to suit your needs.', 'albedo' ); ?></p>
<p><?php echo wp_kses_post( sprintf( __( 'Please come back and <a href="%s" target="_blank">leave a 5-star rating</a> if you are happy with this theme.', 'albedo'), 'http://themeforest.net/downloads' ) ); ?></p>

<div class="wplab-albedo-next-steps">
	<div class="wplab-albedo-next-steps-first">
		<h2><?php esc_html_e( 'Next Steps', 'albedo' ); ?></h2>
		<ul>
			<li class="documentation"><a href="https://www.albedo-theme.com/docs/" target="_blank"><?php esc_html_e( 'Read the theme documentation', 'albedo' ); ?></a></li>
			<?php if( class_exists( 'ZipArchive' ) && function_exists('curl_version') && (function_exists( 'fw_ext') && fw_ext('backups')) ): ?>
			<li class="demodata"><a href="<?php echo admin_url( 'tools.php?page=fw-backups-demo-content'); ?>"><?php esc_html_e( 'Install sample content', 'albedo' ); ?></a></li>
			<?php endif; ?>
			<li class="options"><a href="<?php echo admin_url( 'admin.php?page=fw-settings'); ?>"><?php esc_html_e( 'Customize theme options', 'albedo' ); ?></a></li>
			<li class="realcontent"><a href="<?php echo admin_url( 'edit.php?post_type=page'); ?>"><?php esc_html_e( 'Add some real content', 'albedo' ); ?></a></li>
		</ul>
	</div>
	<div class="wplab-albedo-next-steps-last">
		<h2>&nbsp;</h2>
		<ul>
			<li class="setup-product"><a class="button button-primary button-large" href="http://themeforest.net/user/wplab/follow" target="_blank"><?php esc_html_e( 'Follow @wplab on ThemeForest', 'albedo' ); ?></a>
			</li>
			<li class="setup-product"><a class="button button-next button-large" href="<?php echo esc_url( admin_url() ); ?>"><?php esc_html_e( 'Back to WordPress Admin', 'albedo' ); ?></a>
			</li>
		</ul>
	</div>
</div>
