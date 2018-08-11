<?php

// Prevent direct access
if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
if ( is_admin()){
	return;
}
$css_classes = $attributes = array();

$main_row_id = 'shortcode-' . $atts['id'];

$video_parallax = false;

/**
 * Custom ID
 **/
if( isset( $atts['section_id'] ) && $atts['section_id'] <> '' ) {
	$main_row_id = $atts['section_id'];
}

/**
 * Custom CSS Classes
 **/
if( isset( $atts['section_class'] ) && $atts['section_class'] <> '' ) {
	$css_classes[] = esc_attr( $atts['section_class'] );
}

if( isset( $atts['background_fixed'] ) && filter_var( $atts['background_fixed'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'fixed-bg-section';
}

$bg_layers = $particles = false;

if( isset( $atts['section_style'] ) && $atts['section_style'] <> '' ) {
	if( $atts['section_style'] == 'boxed_rounded' ) {
		$css_classes[] = 'box-element box-rounded';
	} elseif( $atts['section_style'] == 'boxed' ) {
		$css_classes[] = 'box-element box-square';
	} else {
		$css_classes[] = $atts['section_style'];
		$css_classes[] = 'wow';
		$bg_layers = true;
	}
}

if( isset( $atts['section_style'] ) && $atts['section_style'] == 'boxed_rounded' ) {
	$css_classes[] = 'box-element';
}

$centered_content = false;
if( isset( $atts['full_height']['enabled'] ) && filter_var( $atts['full_height']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'full-height-section';
	if( filter_var( $atts['full_height']['yes']['center_content'], FILTER_VALIDATE_BOOLEAN ) ) {
		$centered_content = true;
		$css_classes[] = 'full-height-centered';
	}
}

if( isset( $atts['hide_bg_large_screens'] ) && filter_var( $atts['hide_bg_large_screens'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'bgimage-hidden-lg';
}

if( isset( $atts['hide_bg_medium_screens'] ) && filter_var( $atts['hide_bg_medium_screens'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'bgimage-hidden-md';
}

if( isset( $atts['hide_bg_small_screens'] ) && filter_var( $atts['hide_bg_small_screens'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'bgimage-hidden-sm';
}

if( isset( $atts['hide_bg_estra_small_screens'] ) && filter_var( $atts['hide_bg_estra_small_screens'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'bgimage-hidden-xs';
}

if( isset( $atts['hide_lg'] ) && filter_var( $atts['hide_lg'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'hidden-lg';
}

if( isset( $atts['hide_md'] ) && filter_var( $atts['hide_md'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'hidden-md';
}

if( isset( $atts['hide_sm'] ) && filter_var( $atts['hide_sm'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'hidden-sm';
}

if( isset( $atts['hide_xs'] ) && filter_var( $atts['hide_xs'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'hidden-xs';
}

/**
 * Animations
 **/
if( isset( $atts['animation']['enabled'] ) && filter_var( $atts['animation']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
	$css_classes[] = 'wow';
	$css_classes[] = $atts['animation']['yes']['effect'];
	$attributes[] = 'data-wow-delay="' . esc_attr( $atts['animation']['yes']['animation_delay'] ) . '"';
}

/**
 * 	Stretch class
 **/
if( isset( $atts['container_stretch'] ) && $atts['container_stretch'] <> '' ) {
	$css_classes[] = $atts['container_stretch'];
}

/**
 * Is Full-width container
 **/
$sidebar_position = function_exists('fw_ext_sidebars_get_current_position') ? fw_ext_sidebars_get_current_position() : 'right';
if( is_null( $sidebar_position ) ) {
	$sidebar_position = 'right';
}
$p_tpl = basename( get_page_template() );
if( $p_tpl == 'page-template-custom.php' || $p_tpl == 'page-template-no-header-footer.php' ) {
	$sidebar_position = 'full';
}
$container_stretch = ( isset( $atts['container_stretch'] ) && ( $atts['container_stretch'] == 'stretch_row_content' || $atts['container_stretch'] == 'stretch_row_content_no_paddings' ) );
$container_class = $container_stretch || ( !is_null( $sidebar_position ) && $sidebar_position !== 'full' ) ? 'container-fluid' : 'container';

/**
 * Section effects
 **/

if( isset( $atts['parallax_effects']['effect'] ) && $atts['parallax_effects']['effect'] <> '' ) {
	/**
	 * Parallax Background Effect
	 **/
	if( $atts['parallax_effects']['effect'] == 'parallax' ) {
		$parallax_speed = $atts['parallax_effects']['parallax']['parallax_speed'] <> '' ? $atts['parallax_effects']['parallax']['parallax_speed'] : '0.2';
		$parallax_bg = isset( $atts['background_image']['data']['icon'] ) ? $atts['background_image']['data']['icon'] : '';

		if( $parallax_bg <> '' ) {
			$css_classes[] = 'parallax-section';
			$attributes[] = 'data-stellar-background-ratio="' . esc_attr( $parallax_speed ) . '"';
			$attributes[] = 'data-lazy-src="' . esc_attr( $parallax_bg ) . '"';
			$css_classes[] = 'b-lazy';
		}
	}

	/**
	 * Mouse parallax
	 **/
	elseif( $atts['parallax_effects']['effect'] == 'mouse_parallax' ) {
		$css_classes[] = 'parallax-js-section';
	}
	/**
	 * Scrollr Effect
	 **/
	elseif( $atts['parallax_effects']['effect'] == 'scroll_animation' ) {
		$css_classes[] = 'skrollr';
		$attributes[] = 'data-0="' . esc_attr( $atts['parallax_effects']['scroll_animation']['start_css'] ) . '"';
		$attributes[] = 'data-' . absint( $atts['parallax_effects']['scroll_animation']['end_pos'] ) . '="' . esc_attr( $atts['parallax_effects']['scroll_animation']['end_css'] ) . '"';
	}
}

if( isset( $atts['section_effects']['effect'] ) && $atts['section_effects']['effect'] <> '' ) {

	/**
	 * YouTube Video Background Effect
	 **/
	if( $atts['section_effects']['effect'] == 'video' ) {
		$css_classes[] = 'video-bg-section';
		if( isset( $atts['section_effects']['video']['video_parallax_speed'] ) && $atts['section_effects']['video']['video_parallax_speed'] <> '' ) {
			if( isset( $atts['section_effects']['video']['video_fallback_image']['url'] ) && $atts['section_effects']['video']['video_fallback_image']['url'] <> '' ) {
				$attributes[] = 'data-video-fallabck="' . esc_attr( $atts['section_effects']['video']['video_fallback_image']['url'] ) . '"';
			}
			$css_classes[] = 'video-parallax';
			$video_parallax = true;
		}
	}

	/**
	 * Particle Groud Effect
	 **/
	elseif( $atts['section_effects']['effect'] == 'particleground' ) {
		$css_classes[] = 'particle-ground-section';
		$attributes[] = 'data-dot-color="' . esc_attr( $atts['section_effects']['particleground']['dot_color'] ) . '"';
		$attributes[] = 'data-line-color="' . esc_attr( $atts['section_effects']['particleground']['line_color'] ) . '"';
		$attributes[] = 'data-particle-radius="' . esc_attr( $atts['section_effects']['particleground']['particle_radius'] ) . '"';
		$attributes[] = 'data-line-width="' . esc_attr( $atts['section_effects']['particleground']['line_width'] ) . '"';
		$attributes[] = 'data-curved-lines="' . esc_attr( $atts['section_effects']['particleground']['curved_lines'] ) . '"';
		$attributes[] = 'data-parallax="' . esc_attr( $atts['section_effects']['particleground']['parallax'] ) . '"';
		$attributes[] = 'data-parallax-multiplier="' . esc_attr( $atts['section_effects']['particleground']['parallax_multiplier'] ) . '"';
		$attributes[] = 'data-proximity="' . esc_attr( $atts['section_effects']['particleground']['proximity'] ) . '"';
		$attributes[] = 'data-min-speed-x="' . esc_attr( $atts['section_effects']['particleground']['min_speed_x'] ) . '"';
		$attributes[] = 'data-max-speed-x="' . esc_attr( $atts['section_effects']['particleground']['max_speed_x'] ) . '"';
		$attributes[] = 'data-min-speed-y="' . esc_attr( $atts['section_effects']['particleground']['min_speed_y'] ) . '"';
		$attributes[] = 'data-max-speed-y="' . esc_attr( $atts['section_effects']['particleground']['max_speed_y'] ) . '"';
		$attributes[] = 'data-direction-x="' . esc_attr( $atts['section_effects']['particleground']['direction_x'] ) . '"';
		$attributes[] = 'data-direction-y="' . esc_attr( $atts['section_effects']['particleground']['direction_y'] ) . '"';
		$attributes[] = 'data-destiny="' . esc_attr( $atts['section_effects']['particleground']['destiny'] ) . '"';
	}

	/**
	 * Particles Effect
	 **/
	elseif( $atts['section_effects']['effect'] == 'particles' ) {
		$particles = true;
	}

}

/**
 * Lazy load bg image
 **/
if( filter_var( $atts['background_lazy'], FILTER_VALIDATE_BOOLEAN ) && !empty( $atts['background_image']['data']['css'] ) ) {
	$css_classes[] = 'b-lazy';
	$attributes[] = 'data-lazy-src="' . esc_attr( $atts['background_image']['data']['icon'] ) . '"';
}

?>
<div id="<?php echo esc_attr( $main_row_id ); ?>" class="pb-section <?php echo implode( ' ', $css_classes ); ?>" <?php echo implode( ' ', $attributes ); ?>>

	<?php
	$parallax_img = isset( $atts['background_image']['data']['icon'] ) ? $atts['background_image']['data']['icon'] : '';
	if( $atts['parallax_effects']['effect'] == 'mouse_parallax' && is_string($parallax_img) && $parallax_img <> '' ): ?>

	<ul class="parallax-scene"
			data-invert-x="<?php echo $atts['parallax_effects']['mouse_parallax']['invert_x'] == 'yes' ? 'true' : 'false'; ?>"
			data-invert-y="<?php echo $atts['parallax_effects']['mouse_parallax']['invert_y'] == 'yes' ? 'true' : 'false'; ?>"
			data-limit-x="<?php echo esc_attr( $atts['parallax_effects']['mouse_parallax']['limit_x'] ); ?>"
			data-limit-y="<?php echo esc_attr( $atts['parallax_effects']['mouse_parallax']['limit_y'] ); ?>"
			data-scalar-x="<?php echo esc_attr( $atts['parallax_effects']['mouse_parallax']['scalar_x'] ); ?>"
			data-scalar-y="<?php echo esc_attr( $atts['parallax_effects']['mouse_parallax']['scalar_y'] ); ?>"
			data-friction-x="<?php echo esc_attr( $atts['parallax_effects']['mouse_parallax']['friction_x'] ); ?>"
			data-friction-y="<?php echo esc_attr( $atts['parallax_effects']['mouse_parallax']['friction_y'] ); ?>"
			data-origin-x="<?php echo esc_attr( $atts['parallax_effects']['mouse_parallax']['origin_x'] ); ?>"
			data-origin-y="<?php echo esc_attr( $atts['parallax_effects']['mouse_parallax']['origin_y'] ); ?>">
		<li class="layer layer-bg" data-depth="<?php echo esc_attr( $atts['parallax_effects']['mouse_parallax']['depth'] ); ?>"><div></div></li>
	</ul>
	<?php endif; ?>

	<?php if( $atts['section_effects']['effect'] == 'video' ): ?>
		<?php
			$_video_params = array(
				'videoURL' => esc_attr( $atts['section_effects']['video']['video'] ),
				'containment' => '#' . $main_row_id . '-video',
				'autoPlay' => 'true',
				'mute' => esc_attr( $atts['section_effects']['video']['video_mute'] ),
				'showControls' => 'false',
				'quality' => 'hd720',
				'loop' => 'true',
				'showYTLogo' => 'false'
			);

			if( isset( $atts['section_effects']['video']['video_fallback_image']['url'] ) ) {
				$_video_params['mobileFallbackImage'] = $atts['section_effects']['video']['video_fallback_image']['url'];
			}

		?>
	<div id="<?php echo esc_attr( $main_row_id ); ?>-video" class="video-bg" data-property='<?php echo json_encode( $_video_params ); ?>' <?php if( $video_parallax ): ?>data-stellar-ratio="<?php echo esc_attr( $atts['section_effects']['video']['video_parallax_speed'] ); ?>"<?php endif; ?>></div>
	<?php endif; ?>

	<?php if( isset( $atts['overlay'] ) && $atts['overlay']['effect'] <> '' ): ?>
	<div class="section-overlay-effect"></div>
	<?php endif; ?>

	<?php if( $particles ): ?>
	<div class="particles-section">
		<div class="particles-element" id="particles-<?php echo esc_attr( $main_row_id ); ?>"></div>
	</div>
	<?php endif; ?>

	<?php if( $bg_layers ): ?>
	<div class="bg-layer-1"></div>
	<div class="bg-layer-2"></div>
	<?php endif; ?>

	<?php if( $centered_content ): ?>
	<div class="centered-content-wrapper">
	<?php endif; ?>

	<div class="<?php echo esc_attr( $container_class ); ?>">
		<?php echo do_shortcode( $content ); ?>
	</div>

	<?php if( $centered_content ): ?>
	</div>
	<?php endif; ?>

</div>
<?php if( $container_stretch || $atts['container_stretch'] == 'stretch_row' ): ?><div class="row-full-width"></div><?php endif;
