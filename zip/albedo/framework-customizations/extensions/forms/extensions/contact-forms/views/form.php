<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * @var string $form_id
 * @var string $form_html
 * @var array $extra_data
 */
 
 $form_style = isset( $extra_data['form_style'] ) && $extra_data['form_style'] <> '' ? $extra_data['form_style'] : 'default';
 $inputs_style = isset( $extra_data['inputs_style'] ) && $extra_data['inputs_style'] <> '' ? $extra_data['inputs_style'] : 'rounded';
 $boxed = isset( $extra_data['form_boxed']['enabled'] ) && filter_var( $extra_data['form_boxed']['enabled'], FILTER_VALIDATE_BOOLEAN );
 $box_style = $boxed ? $extra_data['form_boxed']['yes']['box_style'] : 'light';
 $redirect_url = isset( $extra_data['redirect_on_success'] ) ? $extra_data['redirect_on_success'] : '';
?>
<div data-redirect-url="<?php echo esc_attr( $redirect_url ); ?>" class="form-wrapper contact-form form-style-<?php echo esc_attr( $form_style ); ?> inputs-style-<?php echo esc_attr( $inputs_style ); ?> <?php if( $boxed ): ?>box-element box-style-<?php echo esc_attr( $box_style ); ?><?php endif; ?>">
	<?php echo str_replace( '<p><em>', '<p class="instructions"><em>', $form_html ); ?>
</div>