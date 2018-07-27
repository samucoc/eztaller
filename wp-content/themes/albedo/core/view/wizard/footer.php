<?php if ( 'next_steps' === $data['step'] ) : ?>
	<a class="wc-return-to-dashboard" href="<?php echo esc_url( admin_url() ); ?>"><?php esc_html_e( 'Return to the WordPress Dashboard', 'albedo' ); ?></a>
<?php endif; ?>
</body>
<?php
	@do_action( 'admin_footer' ); // this was spitting out some errors in some admin templates. quick @ fix until I have time to find out what's causing errors.
	do_action( 'admin_print_footer_scripts' );
?>
</html>
