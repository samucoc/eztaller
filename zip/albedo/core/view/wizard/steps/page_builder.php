<h1><?php esc_html_e( 'Choose the Page Builder', 'albedo' ); ?></h1>
<p><?php esc_html_e( 'Albedo Theme supports two Page Builders: Visual Composer and Unyson Page Builder. Since these page builers builder do not have backward compatibility (it is impossible to use Visual Composer widgets in Unyson Page Builder and conversely), please choose, what Page Builder do you want to use:', 'albedo' ); ?></p>

<form method="post">
	<p><label><input type="radio" checked="checked" name="page_builder" value="visual_composer" /> <?php echo wp_kses_post( __( '<strong>Visual Composer</strong> is a most-popular Visual Page Builer on the market. It allows to edit website pages via Front-End (WYSIWYG style) or Back-End (through WordPress admin panel) and it has a lot of addons that can be purchased via ThemeForest / CodeCanyon websites.', 'albedo') ); ?></label></p>
	<p><label><input type="radio" name="page_builder" value="unyson_page_builder" /> <?php echo wp_kses_post( __( '<strong>Unyson Page Builder</strong> works only in Back-End mode, but it much faster and has a better user interface than Visual Composer.', 'albedo') ); ?></label></p>

	<p class="wplab-albedo-setup-actions step">

		<input type="submit" class="button-primary button button-large button-next" value="<?php esc_attr_e( 'Continue', 'albedo' ); ?>" name="save_step"/>

		<?php wp_nonce_field( 'wplab-albedo-wizard' ); ?>
	</p>
</form>
