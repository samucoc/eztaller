<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * @var int $form_id
 * @var string $submit_button_text
 * @var array $extra_data
 */
 
 $submit_style = isset( $extra_data['submit_style'] ) && $extra_data['submit_style'] <> '' ? $extra_data['submit_style'] : 'turquoise simple';

?>
<div>
	<a href="javascript:;" class="form-builder-submit button style-<?php echo esc_attr( $submit_style ); ?>"><?php echo esc_attr( $submit_button_text ); ?></a>
</div>