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

	if( count( $atts['items'] ) > 0 ):
?>
<div class="shortcode-services-iconic" id="shortcode-<?php echo esc_attr( $atts['id'] ); ?>">
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

					<div class="text">

						<?php if( $item['category'] <> '' ): ?>
						<div class="category"><?php echo wp_kses_post( $item['category'] ); ?></div>
						<?php endif; ?>

						<?php if( $item['link'] <> '' ): ?>
						<a target="<?php echo esc_attr( $atts['link_target'] ); ?>" href="<?php echo esc_attr( $item['link'] ); ?>">
						<?php endif; ?>

						<?php if( $item['title'] <> '' ): ?>
						<h4><?php echo wp_kses_post( $item['title'] ); ?></h4>
						<?php endif; ?>

						<?php if( $item['link'] <> '' ): ?>
						</a>
						<?php endif; ?>

						<?php if( $item['text'] <> '' ): ?>
						<?php
							$text = $item['text'];
							$text = preg_replace("/\*+(.*)?/i","<ul><li>$1</li></ul>", $text);
							$text = preg_replace("/(\<\/ul\>\n(.*)\<ul\>*)+/","", $text);
						?>
						<div class="desc"><?php echo wp_kses_post( $text ); ?></div>
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
