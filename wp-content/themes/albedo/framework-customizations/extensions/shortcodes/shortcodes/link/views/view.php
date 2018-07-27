<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
	$attributes = $classes = $link_atts = $link_class = array();

	/** unique id **/
	$attributes[] = 'id="shortcode-' . esc_attr( $atts['id'] ) . '"';

	$target = esc_attr( $atts['target'] );
	$link = esc_attr( $atts['url'] );

	$classes[] = 'bg-color-' . esc_attr( $atts['style'] );

	if( filter_var( $atts['shadow'], FILTER_VALIDATE_BOOLEAN ) ) {
		$classes[] = 'shadow-color-' . esc_attr( $atts['style'] );
	}

	if( isset( $atts['typed_animation']['enabled'] ) && filter_var( $atts['typed_animation']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
		$link_class[] = 'typed';
		$link_class[] = 'wow';
		$link_atts[] = 'data-typed-speed="' . esc_attr( $atts['typed_animation']['yes']['speed'] ) . '"';
		$link_atts[] = 'data-typed-delay="' . esc_attr( $atts['typed_animation']['yes']['delay'] ) . '"';
	}

?>

<div <?php echo implode(' ', $attributes ); ?> class="link-box <?php echo implode( ' ', $classes ); ?>">
	<a href="<?php echo $link; ?>" class="title" target="<?php echo $target; ?>"><?php echo wp_kses_post( $atts['text'] ); ?></a>
	<a <?php echo implode(' ', $link_atts ); ?> href="<?php echo $link; ?>" class="link <?php echo implode( ' ', $link_class ); ?>" target="<?php echo $target; ?>"><?php echo filter_var( $atts['domain_only'], FILTER_VALIDATE_BOOLEAN ) ? wplab_albedo_utils::get_domain_name( $link ) : $link; ?></a>
</div>
