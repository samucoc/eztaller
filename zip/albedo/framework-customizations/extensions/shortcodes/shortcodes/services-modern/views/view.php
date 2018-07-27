<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
	$attributes = $classes = array();
	$animated = filter_var( $atts['animate_on_display']['enabled'], FILTER_VALIDATE_BOOLEAN );
	$animation = !empty( $atts['animate_on_display'] ) && isset( $atts['animate_on_display']['yes']['animation_effect'] ) ? $atts['animate_on_display']['yes']['animation_effect'] : '';
	$animation_step = !empty( $atts['animate_on_display'] ) && isset( $atts['animate_on_display']['yes']['animation_step'] ) ? $atts['animate_on_display']['yes']['animation_step'] : '';

	$animated_on_hover = filter_var( $atts['animate_on_hover']['enabled'], FILTER_VALIDATE_BOOLEAN );
	$hover_animation = !empty( $atts['animate_on_hover'] ) && isset( $atts['animate_on_hover']['yes']['animation_effect'] ) ? $atts['animate_on_hover']['yes']['animation_effect'] : '';

	if( $animated ) {
		$classes[] = 'wow';
		$classes[] = $animation;
		$attributes[] = 'data-wow-delay="' . esc_attr( $animation_step ) .'s"';
	}
?>
<div class="shortcode-services-modern <?php echo implode(' ', $classes); ?>" id="shortcode-<?php echo esc_attr( $atts['id'] ); ?>" <?php echo implode( ' ', $attributes ); ?>>
	<div class="item-inside">

		<?php
			$header_bg = isset( $atts['photo']['data']['icon'] ) && $atts['photo']['data']['icon'] <> '' ? 'background-image: url(' . $atts['photo']['data']['icon'] . ');' : '';
		?>

		<header style="<?php echo $header_bg <> '' ? esc_attr( $header_bg ) : ''; ?>">

			<?php if( $atts['icon_type']['service_icon'] == 'fontawesome' ): ?>

			<div class="icon<?php if( $animated_on_hover ): ?> animate-on-hover<?php endif; ?>" data-hover-animation="<?php echo esc_attr($hover_animation); ?>">
				<i class="<?php echo esc_attr( $atts['icon_type']['fontawesome']['icon'] ); ?>"></i>
			</div>

			<?php elseif( $atts['icon_type']['service_icon'] == 'custom' ): ?>

			<div class="icon<?php if( $animated_on_hover ): ?> animate-on-hover<?php endif; ?>" data-hover-animation="<?php echo esc_attr($hover_animation); ?>">
				<?php wplab_albedo_media::image_src( $atts['icon_type']['custom']['icon'] ); ?>
			</div>

			<?php endif; ?>

		</header>

		<div class="text">

			<?php if( $atts['category'] <> '' ): ?>
			<div class="category"><?php echo wp_kses_post( $atts['category'] ); ?></div>
			<?php endif; ?>

			<?php if( $atts['link'] <> '' ): ?>
			<a target="<?php echo esc_attr( $atts['link_target'] ); ?>" href="<?php echo esc_attr( $atts['link'] ); ?>">
			<?php endif; ?>

			<?php if( $atts['title'] <> '' ): ?>
			<h4><?php echo wp_kses_post( $atts['title'] ); ?></h4>
			<?php endif; ?>

			<?php if( $atts['link'] <> '' ): ?>
			</a>
			<?php endif; ?>

			<?php if( $atts['text'] <> '' ): ?>
			<?php
				$text = $atts['text'];
				$text = preg_replace("/\*+(.*)?/i","<ul><li>$1</li></ul>", $text);
				$text = preg_replace("/(\<\/ul\>\n(.*)\<ul\>*)+/","", $text);
			?>
			<div class="desc"><?php echo wp_kses_post( $text ); ?></div>
			<?php endif; ?>

			<?php if( $atts['link'] <> '' && filter_var( $atts['display_button']['enabled'], FILTER_VALIDATE_BOOLEAN ) ): ?>
			<a target="<?php echo esc_attr( $atts['link_target'] ); ?>" href="<?php echo esc_attr( $atts['link'] ); ?>" class="button style-<?php echo esc_attr( $atts['display_button']['yes']['button_style'] ); ?> size-medium"><?php echo wp_kses_post( $atts['display_button']['yes']['button_text'] ); ?></a>
			<?php endif; ?>

		</div>

	</div>
</div>
