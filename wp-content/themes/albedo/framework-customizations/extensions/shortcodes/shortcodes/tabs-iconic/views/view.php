<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
	$attributes = $classes = array();

	$animated_on_hover = filter_var( $atts['animate_on_hover']['enabled'], FILTER_VALIDATE_BOOLEAN );
	$hover_animation = !empty( $atts['animate_on_hover'] ) && isset( $atts['animate_on_hover']['yes']['animation_effect'] ) ? $atts['animate_on_hover']['yes']['animation_effect'] : '';
?>
<div class="theme-iconic-tabs" data-responsive-break="<?php echo esc_attr( $atts['responsive_break'] ); ?>">
	<nav>
		<?php $i=0; foreach ($atts['tabs'] as $key => $tab): ?>
			<a data-item="<?php echo $i; ?>" href="javascript:;">
				<?php if( $tab['icon_type']['tab_icon'] == 'fontawesome' ): ?>

				<div class="tab-icon<?php if( $animated_on_hover ): ?> animate-on-hover<?php endif; ?>" data-hover-animation="<?php echo esc_attr($hover_animation); ?>">
					<i class="<?php echo esc_attr( $tab['icon_type']['fontawesome']['icon'] ); ?>"></i>
				</div>

				<?php elseif( $tab['icon_type']['tab_icon'] == 'custom' ): ?>

				<div class="tab-icon<?php if( $animated_on_hover ): ?> animate-on-hover<?php endif; ?>" data-hover-animation="<?php echo esc_attr($hover_animation); ?>">
					<?php wplab_albedo_media::image_src( $tab['icon_type']['custom']['icon'] ); ?>
				</div>

				<?php endif; ?>
				<span class="title"><?php echo wp_kses_post( $tab['tab_title'] ); ?></span>
			</a>
		<?php $i++; endforeach; ?>

	</nav>
	<div class="tabs">
		<?php $i=0; foreach ( $atts['tabs'] as $key => $tab ): ?>
			<div class="tab_content tab_number_<?php echo $i; ?>">

				<div class="tab-content-wrapper">
					<?php
						if( $tab['tab_image']['url'] <> '' ):
							$img_width = isset( $tab['tab_image_width'] ) && is_numeric( $tab['tab_image_width'] ) ? $tab['tab_image_width'] : null;
							$img_height = isset( $tab['tab_image_height'] ) && is_numeric( $tab['tab_image_height'] ) ? $tab['tab_image_height'] : null;
					?>
					<div class="tab-content-image" style="<?php echo is_numeric( $img_width ) ? 'width: ' . $img_width . 'px' : ''; ?>">

						<?php echo wplab_albedo_media::image( $tab['tab_image']['url'], $img_width, $img_height, true, true, $tab['tab_image']['url'], true ); ?>

					</div>
					<?php endif; ?>

					<div class="tab-content-text">

						<?php echo do_shortcode( $tab['tab_content'] ) ?>

					</div>

				</div>

			</div>
		<?php $i++; endforeach; ?>
	</div>
</div>
