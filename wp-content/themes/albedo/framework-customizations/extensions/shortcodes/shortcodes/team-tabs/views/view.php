<?php
	if (!defined('FW')) die('Forbidden');
	if ( is_admin()){
		return;
	}
	$attributes = $classes = array();

	$id = esc_attr( $atts['id'] );

	/** unique id **/
	$attributes[] = 'id="shortcode-' . $id . '"';

	$attributes[] = 'data-effect="' . esc_attr( $atts['animation_effect'] ) . '"';

	if( count( $atts['items'] ) > 0 ):
?>

<div class="team-members-tabs <?php echo implode(' ', $classes); ?>" <?php echo implode( ' ', $attributes ); ?>>

	<div class="row">

		<div class="col-md-4 tm-tabs-left">

			<?php if( $atts['block_title'] <> '' ): ?>
			<h3><?php echo wp_kses_post( $atts['block_title'] ); ?></h3>
			<?php endif; ?>

			<?php if( $atts['block_text'] <> '' ): ?>
			<div class="desc"><?php echo wp_kses_post( $atts['block_text'] ); ?></div>
			<?php endif; ?>

			<div class="previews">
			<?php foreach( $atts['items'] as $member ): $photo = isset( $member['photo']['data']['icon'] ) ? $member['photo']['data']['icon'] : ''; ?>
				<a href="javascript:;">
					<?php if( $photo <> '' ): ?>
						<?php echo wplab_albedo_media::image( $photo, 60, 60, true, true, $photo ); ?>
					<?php else: ?>
						<span class="placeholder"></span>
					<?php endif; ?>
				</a>
			<?php endforeach; ?>
			<div class="clearfix"></div>
			</div>

		</div>

		<div class="col-md-8 tm-tabs-right">

			<?php foreach( $atts['items'] as $member ): $photo = isset( $member['content_photo']['data']['icon'] ) ? $member['content_photo']['data']['icon'] : ''; ?>

			<div class="row">

				<?php if( $photo <> '' ): ?>
				<div class="col-md-5 col col-big-photo">
					<?php echo wplab_albedo_media::image( $photo, null, null, true, true, $photo ); ?>
				</div>
				<?php endif; ?>

				<div class="col-md-<?php echo $photo <> '' ? '7' : '12'; ?> col col-text">

					<?php if( $member['name'] <> '' ): ?>
					<h4><?php echo wp_kses_post( $member['name'] ); ?></h4>
					<?php endif; ?>

					<?php if( $member['position'] <> '' ): ?>
					<div class="position"><?php echo wp_kses_post( $member['position'] ); ?></div>
					<?php endif; ?>

					<?php if( $member['free_text'] <> '' ): ?>
					<div class="text"><?php echo wp_kses_post( $member['free_text'] ); ?></div>
					<?php endif; ?>

					<div class="social">
					<?php wplab_albedo_front::print_fa_icons( $member ); ?>
					</div>

				</div>

			</div>

			<?php endforeach; ?>

		</div>

	</div>

</div>
<?php endif;
