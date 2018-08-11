<?php
	global $wplab_albedo_core;
?>
<h3><?php esc_html_e( 'Social profiles', 'albedo'); ?></h3>

<table class="form-table">
	<?php foreach( $wplab_albedo_core->cfg['social_profiles'] as $k=>$v ): ?>
		<tr>
			<th><label for="<?php echo esc_attr( $k ); ?>"><?php echo wp_kses_post( $v ); ?></label></th>
			<td>
				<input type="text" id="<?php echo esc_attr( $k ); ?>" name="social_icons[<?php echo esc_attr( $k ); ?>]" value="<?php echo get_the_author_meta( $k, $data->ID ); ?>" class="regular-text" />
			</td>
		</tr>
	<?php endforeach; ?>
</table>
