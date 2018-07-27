<?php
if ( is_admin()){
	return;
}
$class_width = 'col-md-' . ceil(12 / count($atts['table']['cols'])); ?>
<?php foreach ($atts['table']['cols'] as $col_key => $col): ?>
	<div class="fw-package-wrap <?php echo esc_attr($class_width . ' ' . $col['name']); ?> ">
		<div class="fw-package">
			<?php foreach ($atts['table']['rows'] as $row_key => $row): ?>
				<?php if( $col['name'] == 'desc-col' ) : ?>
					<div class="fw-<?php echo esc_attr( $row['name'] ); ?>">
						<?php $value = isset( $atts['table']['content'][$row_key][$col_key]['textarea'] ) ? $atts['table']['content'][$row_key][$col_key]['textarea'] : ''; ?>
						<?php echo trim( $value ) <> '' ? wp_kses_post( $value ) : '&nbsp;'; ?>
					</div>
				<?php continue; endif; ?>
				<?php if ($row['name'] === 'heading-row'): ?>
					<div class="fw-heading-row">
						<?php $value = $atts['table']['content'][$row_key][$col_key]['textarea']; ?>
						<span>
							<?php echo (empty($value)) ? '&nbsp;' : $value; ?>
						</span>
					</div>
				<?php elseif ($row['name'] === 'pricing-row'): ?>
					<div class="fw-pricing-row">
						<?php $amount = $atts['table']['content'][$row_key][$col_key]['amount'] ?>
						<?php $desc   = $atts['table']['content'][$row_key][$col_key]['description']; ?>
						<span>
							<?php echo (empty($amount)) ? '&nbsp;' : $amount; ?>
						</span>
						<small>
							<?php echo (empty($desc)) ? '&nbsp;' : $desc; ?>
						</small>
					</div>
				<?php elseif ( $row['name'] == 'button-row' ) : ?>
					<?php $button = fw_ext( 'shortcodes' )->get_shortcode( 'button' ); ?>
						<div class="fw-button-row">
							<?php if ( false === empty( $atts['table']['content'][ $row_key ][ $col_key ]['button'] ) and false === empty($button) ) : ?>
								<?php echo $button->render($atts['table']['content'][ $row_key ][ $col_key ]['button']); ?>
							<?php else : ?>
								<span>&nbsp;</span>
							<?php endif; ?>
						</div>
				<?php elseif ( $row['name'] == 'icon-row' ) : ?>
					<?php $icon = fw_ext( 'shortcodes' )->get_shortcode( 'font_svg_icon' ); ?>
						<div class="fw-icon-row">
							<?php if ( false === empty( $atts['table']['content'][ $row_key ][ $col_key ]['icon'] ) and false === empty($icon) ) : ?>
								<?php echo $icon->render($atts['table']['content'][ $row_key ][ $col_key ]['icon']); ?>
							<?php else : ?>
								<span>&nbsp;</span>
							<?php endif; ?>
						</div>
				<?php elseif ($row['name'] === 'default-row') : ?>
					<div class="fw-default-row">
						<?php $value = $atts['table']['content'][$row_key][$col_key]['textarea']; ?>
						<?php echo trim( $value ) <> '' ? wp_kses_post( $value ) : '&nbsp;'; ?>
					</div>
				<?php elseif ($row['name'] === 'term-row') : ?>
					<div class="fw-term-row">
						<?php $value = $atts['table']['content'][$row_key][$col_key]['textarea']; ?>
						<?php echo trim( $value ) <> '' ? wp_kses_post( $value ) : '&nbsp;'; ?>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
<?php endforeach;
