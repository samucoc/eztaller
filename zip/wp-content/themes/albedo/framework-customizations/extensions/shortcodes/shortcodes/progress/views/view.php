<?php
	if (!defined('FW')) die('Forbidden');
	if ( is_admin()){
		return;
	}
?>

<div class="progress-bar style-<?php echo esc_attr( $atts['style'] ); ?>" id="shortcode-<?php echo esc_attr( $atts['id'] ); ?>">
	<div class="progress-bar-title">
		<span class="title"><?php echo wp_kses_post( $atts['title'] ); ?></span>
	</div>
	<div class="progress">
		<div class="progress-bar-value">
			<div class="progress-bar-value-inner">
				<div class="value wow animationProgressBar" data-wow-delay="0.1s" data-width="<?php echo esc_attr( $atts['value'] ); ?>%" style="width: 0%"></div>
			</div>
		</div>
		<div class="num"><?php echo is_rtl() ? '%' . wp_kses_post( $atts['value'] ) : wp_kses_post( $atts['value'] ) . '%'; ?></div>
		<div class="clearfix"></div>
	</div>
</div>
