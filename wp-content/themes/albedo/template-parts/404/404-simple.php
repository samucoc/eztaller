<?php
	/**
	 * Page 404, Simple style template
	 **/
	global $wplab_albedo_core;

	/** get layout options from customizer **/
	$h1_text = wplab_albedo_utils::get_theme_mod(
		'page_404_title_1',
		$wplab_albedo_core->default_options['page_404_title_1']
	);

	$h2_text = wplab_albedo_utils::get_theme_mod(
		'page_404_title_2',
		$wplab_albedo_core->default_options['page_404_title_2']
	);

	$h3_text = wplab_albedo_utils::get_theme_mod(
		'page_404_title_3',
		$wplab_albedo_core->default_options['page_404_title_3']
	);

	$display_search_form = wplab_albedo_utils::get_theme_mod(
		'page_404_display_search',
		$wplab_albedo_core->default_options['page_404_display_search']
	);

	$display_home_btn = wplab_albedo_utils::get_theme_mod(
		'page_404_display_home_btn',
		$wplab_albedo_core->default_options['page_404_display_home_btn']
	);

?>

<div class="container">
	<div class="row">
		<div class="col-md-5">
			<?php if( $h1_text <> '' ): ?>
			<h1><?php echo wp_kses_post( $h1_text ); ?></h1>
			<?php endif; ?>
		</div>
		<div class="col-md-7">
			<?php if( $h2_text <> '' ): ?>
			<h2><?php echo nl2br( wp_kses_post( $h2_text ) ); ?></h2>
			<?php endif; ?>
			<?php if( $h3_text <> '' ): ?>
			<p class="line3"><?php echo nl2br( wp_kses_post( $h3_text ) ); ?></p>
			<?php endif; ?>
		</div>
	</div>
	<?php if( filter_var( $display_search_form, FILTER_VALIDATE_BOOLEAN ) ): ?>
	<div class="row">
		<div class="col-md-12">
		<?php get_search_form(); ?>
		</div>
	</div>
	<?php endif; ?>
	<?php if( filter_var( $display_home_btn['enabled'], FILTER_VALIDATE_BOOLEAN ) && $display_home_btn['yes']['page_404_home_btn_text'] <> '' ): ?>
	<div class="row">
		<div class="col-md-12">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button style-blue size-medium"><?php echo wp_kses_post( $display_home_btn['yes']['page_404_home_btn_text'] ); ?></a>
		</div>
	</div>
	<?php endif; ?>
</div>
