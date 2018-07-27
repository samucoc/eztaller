<?php
	if (!defined('FW')) die( 'Forbidden' );
	if ( is_admin()){
		return;
	}
?>

<div class="contact-info style-iconic">

<?php if( $atts['address'] <> '' ): ?>

	<div class="content-row address">
		<div class="icon">
			<?php wplab_albedo_media::image_src( '', get_template_directory_uri() . '/images/address.svg' ); ?>
		</div>
		<div class="text-container">
			<div class="text">
				<?php echo nl2br( $atts['address'] ); ?>
			</div>
		</div>
	</div>

<?php endif; ?>

<?php if( $atts['phone'] <> '' ): ?>

	<div class="content-row phones">
		<div class="icon">
			<?php wplab_albedo_media::image_src( '', get_template_directory_uri() . '/images/phone.svg' ); ?>
		</div>
		<div class="text-container">
			<div class="text">
				<?php echo nl2br( $atts['phone'] ); ?>
			</div>
		</div>
	</div>

<?php endif; ?>

<?php if( $atts['email'] <> '' ): ?>

	<div class="content-row emails">
		<div class="icon">
			<?php wplab_albedo_media::image_src( '', get_template_directory_uri() . '/images/email.svg' ); ?>
		</div>
		<div class="text-container">
			<div class="text">
				<?php echo nl2br( wplab_albedo_utils::emailize( $atts['email'] ) ); ?>
			</div>
		</div>
	</div>

<?php endif; ?>
</div>
