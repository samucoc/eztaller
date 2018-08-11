<?php
/**
 * Side overlay menu for minimal headers
 **/

if( ! wplab_albedo_utils::is_unyson() ) {
	return false;
}

global $wplab_albedo_core;

$header_menu_style = wplab_albedo_utils::get_theme_mod(
	'menu_style/style',
	$wplab_albedo_core->default_options['menu_style']
);

$is_side_menu = false;
$submenu_free_text = '';

if( $header_menu_style == 'minimal' ) {
	
	$submenu_minimal_style = wplab_albedo_utils::get_theme_mod(
		'menu_style/minimal/submenu_minimal_style',
		$wplab_albedo_core->default_options['submenu_minimal_style']
	);
	
	$submenu_free_text = wplab_albedo_utils::get_theme_mod(
		'menu_style/minimal/submenu_minimal_free_text',
		$wplab_albedo_core->default_options['submenu_minimal_free_text']
	);
	
	if( $submenu_minimal_style != 'style_1' ) {
		$is_side_menu = true;
	}
	
}

if( $is_side_menu ):
?>
<div id="side-minimal-menu">
	<div class="overlay"></div>
	<a href="javascript:;" class="overlay-close"></a>
	<div class="side-menu-content">
	
		<?php
			/**
			 * Display a logo for menu style 2
			 **/
			if( $submenu_minimal_style == 'style_2' ):
			?>
			<div class="side-menu-logo">
			
			<?php
				// get logo style based on settings
				$logo_style = wplab_albedo_utils::get_theme_mod(
					'header_logo_type/logo_type',
					$wplab_albedo_core->default_options['header_logo_type']
				);
				
				// site title only
				if( $logo_style == 'title' ):
				?>
					<a href="<?php echo site_url(); ?>" class="logo">
						<span class="title"><?php echo esc_html( get_bloginfo('name') ); ?></span>
					</a>
				<?php
				// site title and tagline
				elseif( $logo_style == 'title_and_tagline' ):
				?>
					<a href="<?php echo site_url(); ?>" class="logo">
						<span class="title"><?php echo esc_html( get_bloginfo('name') ); ?></span>
						<span class="tagline"><?php echo esc_html( get_bloginfo('description') ); ?></span>
					</a>
				<?php
				// image logo
				elseif( $logo_style == 'image' ):
				
					$custom_page_logo = is_page() && filter_var( fw_get_db_post_option( get_the_ID(), 'page_custom_logo/enabled' ), FILTER_VALIDATE_BOOLEAN );
				
					// default logo
					$logo_img = fw_get_db_customizer_option( 'header_logo_type/image/header_logo_image' );
					$logo_img_2x = fw_get_db_customizer_option( 'header_logo_type/image/header_logo_image_2x' );
					
					if( $custom_page_logo ) {
						$logo_img = fw_get_db_post_option( get_the_ID(), 'page_custom_logo/yes/header_logo_image' );
						$logo_img_2x = fw_get_db_post_option( get_the_ID(), 'page_custom_logo/yes/header_logo_image_2x' );
					}
					
					// if logo image was uploaded in settings
					if( is_array( $logo_img ) ):
					
						if( $custom_page_logo ) {
							
							$logo_width = fw_get_db_post_option( get_the_ID(), 'page_custom_logo/yes/header_logo_width' );
							$logo_height = fw_get_db_post_option( get_the_ID(), 'page_custom_logo/yes/header_logo_height' );			
							$logo_style = wplab_albedo_utils::get_styles( array(
								'width' 				=> $logo_width,
								'height' 				=> $logo_height,
								'top_margin' 		=> fw_get_db_post_option( get_the_ID(), 'page_custom_logo/yes/header_logo_margins/top' ),
								'right_margin' 	=> fw_get_db_post_option( get_the_ID(), 'page_custom_logo/yes/header_logo_margins/right' ),
								'bottom_margin' => fw_get_db_post_option( get_the_ID(), 'page_custom_logo/yes/header_logo_margins/bottom' ),
								'left_margin' 	=> fw_get_db_post_option( get_the_ID(), 'page_custom_logo/yes/header_logo_margins/left' ),
							));	
							
						} else {
							
							$logo_width = fw_get_db_customizer_option( 'header_logo_type/image/header_logo_width' );
							$logo_height = fw_get_db_customizer_option( 'header_logo_type/image/header_logo_height' );			
							$logo_style = wplab_albedo_utils::get_styles( array(
								'width' 				=> $logo_width,
								'height' 				=> $logo_height,
								'top_margin' 		=> fw_get_db_settings_option( 'header_logo_type/image/header_logo_margins/top' ),
								'right_margin' 	=> fw_get_db_settings_option( 'header_logo_type/image/header_logo_margins/right' ),
								'bottom_margin' => fw_get_db_settings_option( 'header_logo_type/image/header_logo_margins/bottom' ),
								'left_margin' 	=> fw_get_db_settings_option( 'header_logo_type/image/header_logo_margins/left' ),
							));	
							
						}
							
					?>
						<a href="<?php echo site_url(); ?>" class="logo" style="<?php echo esc_attr( $logo_style ); ?>">
							<?php
							
								$retina_logo_url = $logo_img['url'];
								
								if( is_array( $logo_img_2x ) && $logo_img_2x['url'] <> '' ) {
									$retina_logo_url = $logo_img_2x['url'];
								}
							
								echo wplab_albedo_media::img( array(
									'url' => $logo_img['url'],
									'url_hd' => $retina_logo_url,
									'width' => $logo_width,
									'height' => $logo_height,
									'atts' => array( 'alt="' . esc_attr( get_bloginfo('name') ) . ' - ' . esc_attr( get_bloginfo('description') ) . '"' )
								));
							?>
						</a>
					<?php
					endif;
					
				endif;
			?>
			
			</div>
			<?php
			endif;
		?>
	
		<div class="side-menu-menu">
		<?php
			// if OnePage menu enabled
			$is_onepage = wplab_albedo_utils::is_unyson() && is_page() ? filter_var( fw_get_db_post_option( get_the_ID(), 'one_page_menu' ), FILTER_VALIDATE_BOOLEAN ) : false;
			
			wp_nav_menu( array(
				'theme_location' => $is_onepage ? 'header_onepage_menu' : 'header_menu',
				'menu_id' => 'menu',
				'menu_class' => $is_onepage ? 'one-page-menu' : '',
				'fallback_cb' => false,
				'container' => 'div',
				'container_class' => 'menu-layout-item item-menu'						
			));
		?>
		</div>
		
		<?php
			/**
			 * Display social icons for menu style 2,3,4
			 **/
			if( $submenu_free_text <> '' ):
			?>
			<div class="side-menu-free-text">
			<?php
				echo wp_kses_post( $submenu_free_text );
			?>
			</div>
			<?php
			endif;
		?>
	</div>
</div>
<?php
endif;