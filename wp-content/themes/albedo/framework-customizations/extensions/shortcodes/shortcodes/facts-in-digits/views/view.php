<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
	$attributes = $classes = array();

	$id = esc_attr( $atts['id'] );
	$cols = absint( $atts['cols'] );
	$column = 12/$cols;

	$animated = filter_var( $atts['animate_on_display']['enabled'], FILTER_VALIDATE_BOOLEAN );
	$animation = !empty( $atts['animate_on_display'] ) && isset( $atts['animate_on_display']['yes']['animation_effect'] ) ? $atts['animate_on_display']['yes']['animation_effect'] : '';
	$animation_step = !empty( $atts['animate_on_display'] ) && isset( $atts['animate_on_display']['yes']['animation_step'] ) ? $atts['animate_on_display']['yes']['animation_step'] : '';

	/** unique id **/
	$attributes[] = 'id="shortcode-' . $id . '"';

	if( count( $atts['items'] ) > 0 ):
?>
<div class="facts-in-digits <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>
	<div class="container-fluid">
	<?php $counter = 0; foreach ( $atts['items'] as $key => $item ): ?>

		<?php if( $counter % $cols == 0 ): ?>
		<div class="row">
		<?php endif; $counter++; ?>

		<div class="item col-md-<?php echo $column; ?> <?php echo $item['icon_type']['item_icon'] == '' ? 'no-icon' : ''; ?> <?php if( $animated ): ?>wow <?php echo esc_attr( $animation ); endif; ?>" <?php if( $animated ): ?>data-wow-delay="<?php echo esc_attr( $animation_step * $counter / 2 ); ?>s"<?php endif; ?>>
			<div class="item-inside">

				<?php if( $item['icon_type']['item_icon'] == 'fontawesome' ): ?>

				<div class="icon">
					<i class="<?php echo esc_attr( $item['icon_type']['fontawesome']['icon'] ); ?>"></i>
				</div>

				<?php elseif( $item['icon_type']['item_icon'] == 'custom' ): ?>

				<div class="icon">
					<?php wplab_albedo_media::image_src( $item['icon_type']['custom']['icon'] ); ?>
				</div>

				<?php endif; ?>

				<div class="item-text">

					<?php
						$animation_class = '';
						if( $atts['animation_type']['type'] == 'numinate' ) {
							$animation_class = 'animationNuminate';
						} elseif( $atts['animation_type']['type'] == 'typing' ) {
							$animation_class = 'typed';
						} else {
							$animation_class = esc_attr( $atts['animation_type']['type'] );
						}
					?>

					<?php if( $item['number'] <> '' ): ?>

						<?php if( $atts['animation_type']['type'] == 'numinate' || $atts['animation_type']['type'] == 'odometer' ): ?>
						<div class="number wow <?php echo $animation_class; ?>" data-to="<?php echo absint( $item['number'] ); ?>">0</div>
						<?php endif; ?>

						<?php if( $atts['animation_type']['type'] == 'typing' ): ?>
						<div class="number wow <?php echo $animation_class; ?>" data-typed-speed="<?php echo absint( $atts['animation_type']['typing']['speed'] ); ?>" data-typed-delay="<?php echo absint( $atts['animation_type']['typing']['delay'] ); ?>"><?php echo absint( $item['number'] ); ?></div>
						<?php endif; ?>

					<?php endif; ?>

					<?php if( $item['text'] <> '' ): ?>
					<div class="text"><?php echo wp_kses_post( $item['text'] ); ?></div>
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
</div>
<?php endif;
