<h1><?php esc_html_e( 'Help and Support', 'albedo'); ?></h1>
<p><?php esc_html_e( 'This theme comes with 6 months item support from purchase date (with the option to extend this period). Regular license allows you to use this theme on a single website. Please purchase an additional license to use this theme on another website.', 'albedo'); ?></p>
<p><?php esc_html_e( 'Item Support can be accessed from', 'albedo'); ?> <a href="https://wplab.ticksy.com/" target="_blank">https://wplab.ticksy.com/</a>
	<?php esc_html_e( 'and includes', 'albedo'); ?>:</p>
<ul>
	<li><span><?php esc_html_e( 'Answering technical questions about item features', 'albedo'); ?></span></li>
	<li><span><?php esc_html_e( 'Assistance with reported bugs and issues', 'albedo'); ?></span></li>
</ul>

<p><?php echo wp_kses_post( __( 'Item Support <strong>DOES NOT</strong> Include', 'albedo')); ?>:</p>
<ul>
	<li><span><?php echo wp_kses_post( sprintf( __( 'Customization and installation services (consider to <a href="%s" target="_blank">hire us</a> for customizations, we know how it works!)', 'albedo'), 'https://www.albedo-theme.com/benefits/customization-service/' ) ); ?></span></li>
</ul>
<p>
	<?php echo wp_kses_post( sprintf( __( 'More details about item support can be found in the ThemeForest <a href="%s" target="_blank">Item Support Policy</a>.', 'albedo'), 'https://themeforest.net/page/item_support_policy' ) ); ?>
	<?php esc_html_e( 'Please read theme documentation and Frequently Asked Questions before you post your ticket, many common questions already answered!', 'albedo' ); ?>
</p>
<p class="wplab-albedo-setup-actions step">
	<a href="<?php echo esc_url( $data['next_step_link'] ); ?>"
		 class="button button-primary button-large button-next"><?php esc_html_e( 'Agree and Continue', 'albedo' ); ?></a>
	<?php wp_nonce_field( 'wplab-albedo-wizard' ); ?>
</p>
