<?php
	/**
	 * Header logo template
	 * displays image / text logo based on theme options
	 **/
	global $wplab_albedo_core;
?>
<div class="menu-layout-item item-logo">
<?php
	// if Unyson Framework is enabled, display logo based on settings
	if( wplab_albedo_utils::is_unyson() ):

		// get logo style based on settings
		$logo_style = wplab_albedo_utils::get_theme_mod(
			'header_logo_type/logo_type',
			$wplab_albedo_core->default_options['header_logo_type']
		);

		// site title only
		if( $logo_style == 'title' ):
		?>
			<a href="<?php echo site_url(); ?>" class="logo logo-title">
				<span class="title"><?php echo esc_html( get_bloginfo('name') ); ?></span>
			</a>
		<?php
		// site title and tagline
		elseif( $logo_style == 'title_and_tagline' ):
		?>
			<a href="<?php echo site_url(); ?>" class="logo logo-title-tagline">
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

			// logo for transparent headers
			$logo_transp_img = fw_get_db_customizer_option( 'header_logo_type/image/header_logo_transp_image' );
			$logo_transp_img_2x = fw_get_db_customizer_option( 'header_logo_type/image/header_logo_transp_image_2x' );

			if( $custom_page_logo ) {
				$logo_transp_img = fw_get_db_post_option( get_the_ID(), 'page_custom_logo/yes/header_logo_transp_image' );
				$logo_transp_img_2x = fw_get_db_post_option( get_the_ID(), 'page_custom_logo/yes/header_logo_transp_image_2x' );
			}

			if( is_array( $logo_transp_img ) ):

				if( $custom_page_logo ) {

					$logo_transp_width = fw_get_db_post_option( get_the_ID(), 'page_custom_logo/yes/header_logo_transp_width' );
					$logo_transp_height = fw_get_db_post_option( get_the_ID(), 'page_custom_logo/yes/header_logo_transp_height' );
					$logo_transp_style = wplab_albedo_utils::get_styles( array(
						'width' 				=> $logo_transp_width,
						'height' 				=> $logo_transp_height,
						'top_margin' 		=> fw_get_db_post_option( get_the_ID(), 'page_custom_logo/yes/header_logo_transp_margins/top' ),
						'right_margin' 	=> fw_get_db_post_option( get_the_ID(), 'page_custom_logo/yes/header_logo_transp_margins/right' ),
						'bottom_margin' => fw_get_db_post_option( get_the_ID(), 'page_custom_logo/yes/header_logo_transp_margins/bottom' ),
						'left_margin' 	=> fw_get_db_post_option( get_the_ID(), 'page_custom_logo/yes/header_logo_transp_margins/left' ),
					));

				} else {

					$logo_transp_width = fw_get_db_customizer_option( 'header_logo_type/image/header_logo_transp_width' );
					$logo_transp_height = fw_get_db_customizer_option( 'header_logo_type/image/header_logo_transp_height' );
					$logo_transp_style = wplab_albedo_utils::get_styles( array(
						'width' 				=> $logo_transp_width,
						'height' 				=> $logo_transp_height,
						'top_margin' 		=> fw_get_db_settings_option( 'header_logo_type/image/header_logo_transp_margins/top' ),
						'right_margin' 	=> fw_get_db_settings_option( 'header_logo_type/image/header_logo_transp_margins/right' ),
						'bottom_margin' => fw_get_db_settings_option( 'header_logo_type/image/header_logo_transp_margins/bottom' ),
						'left_margin' 	=> fw_get_db_settings_option( 'header_logo_type/image/header_logo_transp_margins/left' ),
					));

				}

				?>
				<a href="<?php echo site_url(); ?>" class="logo transp-logo" style="<?php echo esc_attr( $logo_transp_style ); ?>">
					<?php

						$retina_logo_url = $logo_transp_img['url'];

						if( is_array( $logo_transp_img_2x ) && $logo_transp_img_2x['url'] <> '' ) {
							$retina_logo_url = $logo_transp_img_2x['url'];
						}

						echo wplab_albedo_media::img( array(
							'url' => $logo_transp_img['url'],
							'url_hd' => $retina_logo_url,
							'width' => $logo_transp_width,
							'height' => $logo_transp_height,
							'atts' => array( 'alt="' . esc_attr( get_bloginfo('name') ) . ' - ' . esc_attr( get_bloginfo('description') ) . '"' )
						));
					?>
				</a>
				<?php

			endif;

		endif;

	// if Unyson is disabled, display default logo and tagline
	else:
?>
	<a href="<?php echo site_url(); ?>" class="logo">
		<span class="title"><?php echo esc_html( get_bloginfo('name') ); ?></span>
		<span class="tagline"><?php echo esc_html( get_bloginfo('description') ); ?></span>
	</a>
<?php endif; ?>
</div>
