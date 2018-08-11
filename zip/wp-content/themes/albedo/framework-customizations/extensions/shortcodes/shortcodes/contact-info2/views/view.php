<?php
if (!defined('FW')) die( 'Forbidden' );
if ( is_admin()){
	return;
}

$cols = absint( $atts['cols'] );
$column = 12/$cols;

if( count( $atts['items'] ) > 0 ):
?>
<div class="contact-info style-grid">
		<?php $counter = 0; foreach ( $atts['items'] as $key => $item ): ?>

			<?php if( $counter % $cols == 0 ): ?>
			<div class="row">
			<?php endif; $counter++; ?>

			<div class="item col-md-<?php echo $column; ?>">

				<div class="inside">
					<?php if( $item['header'] <> '' ): ?>

						<h4>
							<?php echo wp_kses_post( $item['header'] ); ?>
						</h4>

					<?php endif; ?>

					<dl>
					<?php if( $item['address'] <> '' ): ?>
						<dt><?php echo wp_kses_post( $item['address_title'] ); ?></dt>
						<dd><?php echo nl2br( $item['address'] ); ?></dd>
					<?php endif; ?>

					<?php if( $item['phone'] <> '' ): ?>
						<dt><?php echo wp_kses_post( $item['phone_title'] ); ?></dt>
						<dd><?php echo nl2br( $item['phone'] ); ?></dd>
					<?php endif; ?>

					<?php if( $item['email'] <> '' ): ?>
						<dt><?php echo wp_kses_post( $item['email_title'] ); ?></dt>
						<dd><?php echo nl2br( wplab_albedo_utils::emailize( $item['email'] ) ); ?></dd>
					<?php endif; ?>
					</dl>
				</div>
			</div>

			<?php if( $counter % $cols == 0 ): ?>
			</div>
			<?php endif; ?>

		<?php endforeach; ?>

		<?php if( $counter%$cols != 0 ): ?>
		</div>
		<?php endif; ?>
</div>
<?php endif;
