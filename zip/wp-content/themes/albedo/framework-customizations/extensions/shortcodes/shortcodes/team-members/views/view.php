<?php
	if (!defined('FW')) die('Forbidden');
	if ( is_admin()){
		return;
	}
	$attributes = $classes = array();

	$id = esc_attr( $atts['id'] );

	/** unique id **/
	$attributes[] = 'id="shortcode-' . $id . '"';
	$classes[] = 'cols-' . absint( $atts['cols'] );

	$cols = absint( $atts['cols'] );
	$column = 12/$cols;

	$animated = filter_var( $atts['animate_on_display']['enabled'], FILTER_VALIDATE_BOOLEAN );
	$animation = !empty( $atts['animate_on_display'] ) && isset( $atts['animate_on_display']['yes']['animation_effect'] ) ? $atts['animate_on_display']['yes']['animation_effect'] : '';
	$animation_step = !empty( $atts['animate_on_display'] ) && isset( $atts['animate_on_display']['yes']['animation_step'] ) ? $atts['animate_on_display']['yes']['animation_step'] : '';

	$animated_on_hover = filter_var( $atts['animate_on_hover']['enabled'], FILTER_VALIDATE_BOOLEAN );
	$hover_animation = !empty( $atts['animate_on_hover'] ) && isset( $atts['animate_on_hover']['yes']['animation_effect'] ) ? $atts['animate_on_hover']['yes']['animation_effect'] : '';

	if( count( $atts['items'] ) > 0 ):
?>

<div class="team-members <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>

	<?php $counter = 0; foreach ( $atts['items'] as $key => $item ): ?>

		<?php if( $counter % $cols == 0 ): ?>
		<div class="row">
		<?php endif; $counter++; ?>

		<?php $is_vacancy = filter_var( $item['is_vacancy'], FILTER_VALIDATE_BOOLEAN ); ?>

		<div class="item col-md-<?php echo $column; ?> <?php echo $is_vacancy ? 'vacancy' : ''; ?> <?php if( $animated ): ?>wow <?php echo esc_attr( $animation ); endif; ?>" <?php if( $animated ): ?>data-wow-delay="<?php echo esc_attr( $animation_step * $counter / 2 ); ?>s"<?php endif; ?>>

			<?php
				$text = $item['free_text'];
				$name = $item['name'];
				$position = $item['position'];
				$photo = isset( $item['photo']['data']['icon'] ) ? $item['photo']['data']['icon'] : '';
			?>

			<div class="inside">

				<div class="photo<?php if( $animated_on_hover ): ?> animate-on-hover<?php endif; ?>" data-hover-animation="<?php echo esc_attr($hover_animation); ?>">
					<?php if( $photo <> '' ): ?>
						<?php echo wplab_albedo_media::image( $photo, 160, 160, true, true, $photo ); ?>
					<?php else: ?>
						<div class="placeholder"></div>
					<?php endif; ?>
				</div>

				<div class="text-content">

					<?php if( $position <> '' ): ?>
					<div class="position">
						<?php echo wp_kses_post( $position ); ?>
					</div>
					<?php endif; ?>

					<?php if( $name <> '' ): ?>
					<div class="name">
						<?php echo wp_kses_post( $name ); ?>
					</div>
					<?php endif; ?>

					<?php if( $text <> '' ): ?>
					<div class="text">
						<?php echo wp_kses_post( $text ); ?>
					</div>
					<?php endif; ?>

					<div class="social">
					<?php wplab_albedo_front::print_fa_icons( $item ); ?>
					</div>

					<?php if( filter_var( $item['display_button']['enabled'], FILTER_VALIDATE_BOOLEAN ) ): ?>
					<div class="btn">
						<a href="<?php echo esc_attr( $item['display_button']['yes']['btn_url'] ); ?>" class="button size-medium style-<?php echo esc_attr( $item['display_button']['yes']['btn_style'] ); ?>" target="<?php echo esc_attr( $item['display_button']['yes']['btn_target'] ); ?>"><?php echo wp_kses_post( $item['display_button']['yes']['btn_text'] ); ?></a>
					</div>
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
