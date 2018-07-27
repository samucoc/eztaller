<?php
/**
* Header Call To Action Button template
**/

$link_text = fw_get_db_customizer_option( 'menu_cta/yes/menu_cta_button_text' );
$link_url = fw_get_db_customizer_option( 'menu_cta/yes/menu_cta_button_url' );
$button_style = fw_get_db_customizer_option( 'menu_cta/yes/menu_cta_button_style');

if( $link_text <> '' ):
?>
<div class="menu-layout-item item-cta">
	<a href="<?php echo esc_attr( $link_url ); ?>" class="button size-small style-<?php echo esc_attr( $button_style ); ?>"><?php echo wp_kses_post( $link_text ); ?></a>
</div>
<?php
endif;
