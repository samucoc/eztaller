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

	$style = $atts['style'];

	if( count( $atts['items'] ) > 0 ):
?>

<div class="shortcode-numeric-benefits style-<?php echo esc_attr( $style ); ?>" id="shortcode-<?php echo esc_attr( $atts['id'] ); ?>">
	<?php $counter = 0; $num = 0; foreach ( $atts['items'] as $key => $item ): $num++; ?>

		<?php if( $counter % $cols == 0 ): ?>
		<div class="row">
		<?php endif; $counter++; ?>

		<?php
			$bg_image = $style == 'photo' && isset( $item['bg']['data']['icon'] ) ? $item['bg']['data']['icon'] : '';
		?>
		<div class="item col-md-<?php echo $column; ?> <?php if( $animated ): ?>wow <?php echo esc_attr( $animation ); endif; ?>" style="<?php if( $bg_image <> '' ): ?>background-image: url(<?php echo esc_attr( $bg_image ); ?><?php endif; ?>" <?php if( $animated ): ?>data-wow-delay="<?php echo esc_attr( $animation_step * $counter / 2 ); ?>s"<?php endif; ?>>
			<div class="item-inside">

				<div class="number"><?php echo str_pad( $num, 2, '0', STR_PAD_LEFT); ?>.</div>

				<div class="benefit-text">

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
