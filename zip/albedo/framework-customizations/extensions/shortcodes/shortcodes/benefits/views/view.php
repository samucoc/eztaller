<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
	$attributes = $classes = array();

	$cols = absint( $atts['cols'] );
	$column = 12/$cols;

	$animated = filter_var( $atts['animate_on_display']['enabled'], FILTER_VALIDATE_BOOLEAN );
	$animation = !empty( $atts['animate_on_display'] ) && isset( $atts['animate_on_display']['yes']['animation_effect'] ) ? $atts['animate_on_display']['yes']['animation_effect'] : '';
	$animation_step = !empty( $atts['animate_on_display'] ) && isset( $atts['animate_on_display']['yes']['animation_step'] ) ? $atts['animate_on_display']['yes']['animation_step'] : '';

	$animated_on_hover = filter_var( $atts['animate_on_hover']['enabled'], FILTER_VALIDATE_BOOLEAN );
	$hover_animation = !empty( $atts['animate_on_hover'] ) && isset( $atts['animate_on_hover']['yes']['animation_effect'] ) ? $atts['animate_on_hover']['yes']['animation_effect'] : '';

	$style = isset( $atts['style']['items_style'] ) && $atts['style']['items_style'] <> '' ? $atts['style']['items_style'] : '';
	$accent = $style == 'colorful' ? '-' . $atts['style']['colorful']['accent_color'] : '';

	$display_borders = filter_var( $atts['display_borders'], FILTER_VALIDATE_BOOLEAN );

	if( count( $atts['items'] ) > 0 ):
?>

<div class="shortcode-benefits cols-<?php echo $cols; ?> <?php if( $display_borders ): ?>with-borders<?php endif; ?> icon-position-<?php echo esc_attr( $atts['icon_position'] ); ?> style-<?php echo esc_attr( $style ); ?> items-accent<?php echo esc_attr( $accent ); ?>" id="shortcode-<?php echo esc_attr( $atts['id'] ); ?>">
	<?php $counter = 0; foreach ( $atts['items'] as $key => $item ): ?>

		<?php if( $counter % $cols == 0 ): ?>
		<div class="row">
		<?php endif; $counter++; ?>

		<div class="item col-md-<?php echo $column; ?> <?php echo $item['icon_type']['benefit_icon'] == '' ? 'no-icon' : ''; ?> <?php if( $animated ): ?>wow <?php echo esc_attr( $animation ); endif; ?>" <?php if( $animated ): ?>data-wow-delay="<?php echo esc_attr( $animation_step * $counter / 2 ); ?>s"<?php endif; ?>>
			<div class="item-inside">

					<?php if( $item['icon_type']['benefit_icon'] == 'fontawesome' ): ?>

					<div class="icon<?php if( $animated_on_hover ): ?> animate-on-hover<?php endif; ?>" data-hover-animation="<?php echo esc_attr($hover_animation); ?>">
						<i class="<?php echo esc_attr( $item['icon_type']['fontawesome']['icon'] ); ?>"></i>
					</div>

					<?php elseif( $item['icon_type']['benefit_icon'] == 'custom' ): ?>

					<div class="icon<?php if( $animated_on_hover ): ?> animate-on-hover<?php endif; ?>" data-hover-animation="<?php echo esc_attr($hover_animation); ?>">
						<?php wplab_albedo_media::image_src( $item['icon_type']['custom']['icon'] ); ?>
					</div>

					<?php endif; ?>

					<div class="benefit-text">
						<?php if( $item['link'] <> '' ): ?>
						<a target="<?php echo esc_attr( $atts['link_target'] ); ?>" href="<?php echo esc_attr( $item['link'] ); ?>">
						<?php endif; ?>

						<?php if( $item['title'] <> '' ): ?>
						<h4><?php echo nl2br( wp_kses_post( $item['title'] ) ); ?></h4>
						<?php endif; ?>

						<?php if( $item['link'] <> '' ): ?>
						</a>
						<?php endif; ?>

						<?php if( $item['text'] <> '' ): ?>
						<div class="desc"><?php echo wp_kses_post( $item['text'] ); ?></div>
						<?php endif; ?>

						<?php if( $item['link'] <> '' && filter_var( $atts['display_button']['enabled'], FILTER_VALIDATE_BOOLEAN ) ): ?>
						<a target="<?php echo esc_attr( $atts['link_target'] ); ?>" href="<?php echo esc_attr( $item['link'] ); ?>" class="button style-<?php echo esc_attr( $atts['display_button']['yes']['button_style'] ); ?> size-small"><?php echo wp_kses_post( $atts['display_button']['yes']['button_text'] ); ?></a>
						<?php endif; ?>

					</div>

			</div>
		</div>

	<?php if( $counter % $cols == 0 ): ?>
	</div>
	<?php endif; ?>

	<?php endforeach; ?>

	<?php if( $counter%$cols != 0 ): ?>
	</div>
	<?php endif; ?>

</div>

<?php endif;
