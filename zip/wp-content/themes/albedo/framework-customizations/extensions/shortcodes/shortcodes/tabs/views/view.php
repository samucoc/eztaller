<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
?>
<div class="theme-tabs tabs-style-<?php echo esc_attr( $atts['tabs_style'] ); ?> tabs-type-<?php echo esc_attr( $atts['tabs_type'] ); ?>" data-responsive-break="<?php echo esc_attr( $atts['responsive_break'] ); ?>">
	<nav class="nav-mobile">
		<select>
		<?php $i=0; foreach ($atts['tabs'] as $key => $tab): ?>

			<?php
				/**
				 * Tab icon
				 **/
				$icon = '';
				if( $tab['tab_icon']['type'] == 'icon-font' && $tab['tab_icon']['icon-class'] <> '' ) {
					$icon = '<i class="tab-icon ' . esc_attr( $tab['tab_icon']['icon-class'] ) . '"></i>';
				}
			?>

			<option value="<?php echo $i; ?>"><?php echo trim( $icon ); echo wp_kses_post( $tab['tab_title'] ); ?></option>
		<?php $i++; endforeach; ?>
		</select>
	</nav>
	<nav class="nav-desktop">
		<?php $i=0; foreach ($atts['tabs'] as $key => $tab): ?>

			<?php
				/**
				 * Tab icon
				 **/
				$icon = '';
				if( $tab['tab_icon']['type'] == 'icon-font' && $tab['tab_icon']['icon-class'] <> '' ) {
					$icon = '<i class="tab-icon ' . esc_attr( $tab['tab_icon']['icon-class'] ) . '"></i>';
				}
			?>

			<a data-item="<?php echo $i; ?>" class="a-tab-desktop" href="javascript:;"><?php echo trim( $icon ); echo wp_kses_post( $tab['tab_title'] ); ?></a>
		<?php $i++; endforeach; ?>

	</nav>
	<div class="tabs">
		<?php $i=0; foreach ( $atts['tabs'] as $key => $tab ): ?>
			<div class="tab_content tab_number_<?php echo $i; ?>">

				<div class="tab-content-wrapper">
					<?php if( in_array( $atts['tabs_style'], array('modern', 'modern_alt') ) && !empty( $tab['tab_image'] ) && $atts['tabs_type'] == 'horizontal' ): ?>

					<?php
						$img_width = isset( $tab['tab_image_width'] ) && is_numeric( $tab['tab_image_width'] ) ? $tab['tab_image_width'] : null;
						$img_height = isset( $tab['tab_image_height'] ) && is_numeric( $tab['tab_image_height'] ) ? $tab['tab_image_height'] : null;
					?>
					<div class="tab-content-image" style="<?php echo is_numeric( $img_width ) ? 'width: ' . $img_width . 'px' : ''; ?>">

						<?php echo wplab_albedo_media::image( $tab['tab_image']['url'], $img_width, $img_height, true, true, $tab['tab_image']['url'], true ); ?>

					</div>
					<?php endif; ?>

					<div class="tab-content-text">

						<?php if( filter_var( $atts['display_title'], FILTER_VALIDATE_BOOLEAN ) ): ?>
						<h4 class="title"><?php echo wp_kses_post( $tab['tab_title'] ); ?></h4>
						<?php endif; ?>

						<?php echo do_shortcode( $tab['tab_content'] ) ?>

					</div>

					<?php if( in_array( $atts['tabs_style'], array('modern', 'modern_alt') ) && !empty( $tab['tab_image'] ) && $atts['tabs_type'] == 'vertical' ): ?>

					<?php
						$img_width = isset( $tab['tab_image_width'] ) && is_numeric( $tab['tab_image_width'] ) ? $tab['tab_image_width'] : null;
						$img_height = isset( $tab['tab_image_height'] ) && is_numeric( $tab['tab_image_height'] ) ? $tab['tab_image_height'] : null;
					?>
					<div class="tab-content-image" style="<?php echo is_numeric( $img_width ) ? 'width: ' . $img_width . 'px' : ''; ?>">

						<?php echo wplab_albedo_media::image( $tab['tab_image']['url'], $img_width, $img_height, true, true, $tab['tab_image']['url'], true ); ?>

					</div>
					<?php endif; ?>

				</div>

			</div>
		<?php $i++; endforeach; ?>
	</div>
</div>
