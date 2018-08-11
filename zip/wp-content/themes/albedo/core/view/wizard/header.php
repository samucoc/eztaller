<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<meta name="viewport" content="width=device-width"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<?php
	// avoid theme check issues.
	echo '<t';
	echo 'itle>' . esc_html__( 'Albedo Theme Setup Wizard', 'albedo' ) . '</ti' . 'tle>'; ?>
	<?php wp_print_scripts( 'envato-setup' ); ?>
	<?php do_action( 'admin_print_styles' ); ?>
	<?php do_action( 'admin_print_scripts' ); ?>
	<?php do_action( 'admin_head' ); ?>
</head>
<body class="wplab-albedo wp-core-ui">
<h1 id="theme-logo">
	<a href="<?php echo admin_url( 'admin.php?wplab_albedo_action=wizard-display_wizard_screen'); ?>">
		<img src="<?php echo get_template_directory_uri(); ?>/images/logo-wizard.png" alt="Albedo Theme Install Wizard" />
	</a>
</h1>
