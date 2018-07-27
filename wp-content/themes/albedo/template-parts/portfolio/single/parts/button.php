<?php

/**
* Project button
**/

$post_id = get_the_ID();

/** if we need to display a button **/
$display_button = filter_var( fw_get_db_post_option( $post_id, 'single_button/enabled' ), FILTER_VALIDATE_BOOLEAN );
$button_text = $button_url = $button_style = '';

if( $display_button ) {
	$button_text = fw_get_db_post_option( $post_id, 'single_button/yes/button_text' );
	$button_url = fw_get_db_post_option( $post_id, 'single_button/yes/button_url' );
	$button_style = fw_get_db_post_option( $post_id, 'single_button/yes/button_style' );
}

if( $display_button ): ?>
	<p class="single-post-button">
		<a href="<?php echo esc_attr( $button_url ); ?>" class="button style-<?php echo esc_attr( $button_style ); ?>"><?php echo wp_kses_post( $button_text ); ?></a>
	</p>
<?php endif;
