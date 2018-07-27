<?php
	/**
	 * Sub-header layout style 1 and 2, it looks like these screenshots
	 * similar HTML markup, but different CSS styles
	 * /wp-content/themes/wplab-albedo/images/header_layout_1.jpg
	 * /wp-content/themes/wplab-albedo/images/header_layout_2.jpg
	 **/
	global $wplab_albedo_core;

	/**
	 * Page title and page description
	 **/
	$display_page_title = filter_var( wplab_albedo_utils::get_theme_mod(
		'display_header_page_title',
		$wplab_albedo_core->default_options['display_header_page_title']
	), FILTER_VALIDATE_BOOLEAN );

	$display_page_description = filter_var( wplab_albedo_utils::get_theme_mod(
		'display_header_page_desc',
		$wplab_albedo_core->default_options['display_header_page_desc']
	), FILTER_VALIDATE_BOOLEAN );

	$display_cta_button = filter_var( wplab_albedo_utils::get_theme_mod(
		'header_cta/enabled',
		$wplab_albedo_core->default_options['header_cta']
	), FILTER_VALIDATE_BOOLEAN );

	/**
	 * Second menu
	 **/
	 $display_second_menu = filter_var( wplab_albedo_utils::get_theme_mod(
		'display_header_second_menu',
		$wplab_albedo_core->default_options['display_header_second_menu']
	), FILTER_VALIDATE_BOOLEAN );

	/**
	 * Breadcrumbs
	 **/
	$display_breadcrumbs = filter_var( wplab_albedo_utils::get_theme_mod(
		'display_header_breadcrumbs',
		$wplab_albedo_core->default_options['display_header_breadcrumbs']
	), FILTER_VALIDATE_BOOLEAN );

	/**
	 * Page title and breadcrumbs also can be hidden for current page only
	**/
	$hide_page_title_block = $hide_breadcrumbs_block = $hide_header_second_menu = false;

	if( is_page() && wplab_albedo_utils::is_unyson() ) {
		$hide_page_title_block = filter_var( fw_get_db_post_option( get_the_ID(), 'hide_header_title' ), FILTER_VALIDATE_BOOLEAN );
		$hide_header_second_menu = filter_var( fw_get_db_post_option( get_the_ID(), 'hide_header_second_menu' ), FILTER_VALIDATE_BOOLEAN );
		$hide_breadcrumbs_block = filter_var( fw_get_db_post_option( get_the_ID(), 'hide_header_breadcrumbs' ), FILTER_VALIDATE_BOOLEAN );
	}

	if( !$hide_page_title_block && ( $display_page_title || $display_page_description || $display_cta_button ) ):
?>
<div id="header-title-desc">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="subheader-container">

					<div class="subheader-text">

						<?php if( $display_page_title ): ?>
							<?php wplab_albedo_front::print_page_title(); ?>
						<?php endif; ?>

						<?php
							if( wplab_albedo_utils::is_unyson() && $display_page_description ):
								$page_description = wplab_albedo_front::get_page_desc();
						?>
						<h6><?php echo wp_kses_post( $page_description ); ?></h6>
						<?php endif; ?>

					</div>

					<div class="subheader-cta">
						<?php if( wplab_albedo_utils::is_unyson() && $display_cta_button ): ?>

						<?php
							$cta_button_text = wplab_albedo_utils::get_theme_mod(
								'header_cta_button_text',
								$wplab_albedo_core->default_options['header_cta_button_text']
							);
							$cta_button_link = wplab_albedo_utils::get_theme_mod(
								'header_cta_button_url',
								$wplab_albedo_core->default_options['header_cta_button_url']
							);
							$cta_button_style = wplab_albedo_utils::get_theme_mod(
								'header_cta_button_style',
								$wplab_albedo_core->default_options['header_cta_button_style']
							);
						?>

						<?php if( $cta_button_text <> '' && $cta_button_link <> '' ): ?>
						<a href="<?php echo esc_attr( $cta_button_link ); ?>" class="button size-small style-<?php echo esc_attr( $cta_button_style ); ?>"><?php echo wp_kses_post( $cta_button_text ); ?></a>
						<?php endif; ?>

					<?php endif; ?>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<?php if( !$hide_header_second_menu && $display_second_menu ): ?>
	<div id="header-second-menu">
		<div class="container">
			<div class="col-md-12">
				<?php wp_nav_menu( array( 'theme_location' => 'header_second_menu' ) ); ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if( !$hide_breadcrumbs_block && ( $display_breadcrumbs && wplab_albedo_utils::is_unyson() && function_exists( 'fw_ext_get_breadcrumbs' ) ) ): ?>
<div id="header-breadcrumbs" class="subheader-breadcrumbs">
	<div class="container">
		<div class="col-md-12">
			<?php echo fw_ext_get_breadcrumbs(); ?>
		</div>
	</div>
</div>
<?php endif; ?>

<?php
	endif;
