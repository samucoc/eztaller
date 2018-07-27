<?php
/**
 * Top Bar Template Part
 **/
global $wplab_albedo_core;

if( wplab_albedo_utils::is_unyson() && filter_var( fw_get_db_customizer_option( 'top_bar_enabled/enabled'), FILTER_VALIDATE_BOOLEAN ) ):
	$top_bar_elements = (array)fw_get_db_customizer_option( 'top_bar_enabled/yes/top_bar_elements');
	$top_bar_sticky = filter_var( fw_get_db_customizer_option( 'top_bar_sticky'), FILTER_VALIDATE_BOOLEAN );
	$top_bar_sticky_on_mobiles = filter_var( fw_get_db_customizer_option( 'top_bar_sticky_mobile'), FILTER_VALIDATE_BOOLEAN );
	$top_bar_hide_on_mobiles = filter_var( fw_get_db_customizer_option( 'top_bar_hide_mobile'), FILTER_VALIDATE_BOOLEAN );
	$top_bar_responsive_at = absint( fw_get_db_customizer_option( 'top_bar_responsive_at') );
?>
<div id="top-bar" class="top-bar <?php echo $top_bar_sticky ? 'sticky' : 'normal'; ?> mobile-sticky-<?php echo $top_bar_sticky_on_mobiles ? 'on' : 'off'; ?> <?php if( $top_bar_hide_on_mobiles ): ?>mobile-hidden<?php endif; ?>" data-responsive="<?php echo esc_attr( $top_bar_responsive_at ); ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<?php foreach( $top_bar_elements as $elem ): ?>

				<div class="top-bar-item type-<?php echo esc_attr( $elem['type']['elem_type'] ); ?><?php if( filter_var( $elem['type'][ $elem['type']['elem_type'] ]['move_right'], FILTER_VALIDATE_BOOLEAN ) ): ?> alignright<?php endif; ?><?php if( filter_var( $elem['type'][ $elem['type']['elem_type'] ]['hide_on_mobiles'], FILTER_VALIDATE_BOOLEAN ) ): ?> mobile-hidden<?php endif; ?>">

					<?php if( $elem['type']['elem_type'] == 'text' ): ?>

						<!--
							Top Bar Text element
						-->
						<span class="elem-text"><?php echo make_clickable( $elem['type']['text']['content'] ); ?></span>

					<?php elseif( $elem['type']['elem_type'] == 'text_icon' ): ?>

						<!--
							Top Bar Text & Icon element
						-->
						<span class="elem-text-icon">
						<?php
							if( $elem['type']['text_icon']['icon']['type'] == 'icon-font' && $elem['type']['text_icon']['icon']['icon-class'] <> '' ) {
								echo '<i class="elem-icon ' . $elem['type']['text_icon']['icon']['icon-class'] . '"></i>';
							} elseif( $elem['type']['text_icon']['icon']['type'] == 'custom-upload' ) {
								echo '<img src="' . $elem['type']['text_icon']['icon']['url'] . '" alt="" />';
							}
						?>
							<span><?php echo make_clickable( $elem['type']['text_icon']['content'] ); ?></span>
						</span>

						<span class="elem-text"><?php echo wp_kses_post( $elem['type']['text']['content'] ); ?></span>

					<?php elseif( $elem['type']['elem_type'] == 'social_icons' ): ?>
						<!--
							Top Bar Social Icons element
						-->
						<span class="elem-social-icons">

							<?php
								wplab_albedo_front::print_fa_icons( array(
									'instagram_url' => $elem['type']['social_icons']['instagram_url'],
									'facebook_url' => $elem['type']['social_icons']['facebook_url'],
									'twitter_url' => $elem['type']['social_icons']['twitter_url'],
									'linkedin_url' => $elem['type']['social_icons']['linkedin_url'],
									'google_plus_url' => $elem['type']['social_icons']['google_plus_url'],
									'youtube_url' => $elem['type']['social_icons']['youtube_url'],
									'medium_url' => $elem['type']['social_icons']['medium_url'],
								));
							?>

						</span>
					<?php elseif( $elem['type']['elem_type'] == 'wpml_switcher' && function_exists( 'icl_get_languages') ): ?>
						<!--
							WPML Language switcher
						-->
						<span class="elem-wpml-switcher">
							<ul>
							<?php
								$languages = icl_get_languages('skip_missing=0&orderby=code');
								if(!empty($languages)){
									foreach($languages as $l){
										echo '<li class="lang-item">';
										if($l['country_flag_url']){
											if(!$l['active']) echo '<a href="'.$l['url'].'">';
											echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
											if(!$l['active']) echo '</a>';
										}
										echo '</li>';
									}
								}
							?>
							</ul>
						</span>

					<?php elseif( $elem['type']['elem_type'] == 'polylang_switcher' && function_exists( 'pll_the_languages') ): ?>

						<!--
							Polylang Language switcher
						-->
						<span class="elem-polylang-switcher">
							<ul><?php pll_the_languages( 'show_flags=1&show_names=0');?></ul>
						</span>

					<?php endif; ?>

				</div>

				<?php endforeach; ?>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<?php endif;
