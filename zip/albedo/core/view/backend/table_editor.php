<?php global $wplab_albedo_core_plugin; ?>
<table class="widefat" id="albedo-pricing-table-editor">
	<?php if( !is_array( $data['pricing_table'] ) || count( $data['pricing_table'] ) <= 0 ): ?>
	<thead>
		<tr>
			<th class="ex"><?php esc_html_e('Package Title', 'albedo'); ?></th>
			<th class="package-title"><input name="pt[packages][names][0]" type="text" value="<?php esc_html_e('Basic', 'albedo'); ?>" /></th>
			<th class="package-title"><input name="pt[packages][names][1]" type="text" value="<?php esc_html_e('Pro', 'albedo'); ?>" /></th>
			<th class="package-title"><input name="pt[packages][names][2]" type="text" value="<?php esc_html_e('Unlimited', 'albedo'); ?>" /></th>
			<th class="ex"><a href="javascript:;" class="albedo-add-pricing-package button"><i class="fa fa-plus"></i> <?php esc_html_e('Add package', 'albedo'); ?></a></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th class="ex"><a href="javascript:;" class="albedo-add-pricing-feature button"><i class="fa fa-plus"></i> <?php esc_html_e('Add feature', 'albedo'); ?></a></th>
			<th class="center">
				<a href="javascript:;" title="<?php esc_html_e('Remove this plan', 'albedo'); ?>" class="albedo-delete-package button"><i class="fa fa-times"></i></a>
				<a href="javascript:;" title="<?php esc_html_e('Mark this column as description', 'albedo'); ?>" class="albedo-make-desc-col button"><i class="fa fa-info-circle"></i><input type="radio" name="pt[pricing_table][desc_col]" value="0" /></a>
				<a href="javascript:;" title="<?php esc_html_e('Mark this plan as featured', 'albedo'); ?>" class="albedo-make-featured-price button"><i class="fa fa-star"></i><input type="radio" name="pt[pricing_table][featured]" value="0" /></a>
			</th>
			<th class="center">
				<a href="javascript:;" title="<?php esc_html_e('Remove this plan', 'albedo'); ?>" class="albedo-delete-package button"><i class="fa fa-times"></i></a>
				<a href="javascript:;" title="<?php esc_html_e('Mark this column as description', 'albedo'); ?>" class="albedo-make-desc-col button"><i class="fa fa-info-circle"></i><input type="radio" name="pt[pricing_table][desc_col]" value="1" /></a>
				<a href="javascript:;" title="<?php esc_html_e('Mark this plan as featured', 'albedo'); ?>" class="albedo-make-featured-price button button-primary"><i class="fa fa-star"></i><input type="radio" name="pt[pricing_table][featured]" checked="checked" value="1" /></a>
			</th>
			<th class="center">
				<a href="javascript:;" title="<?php esc_html_e('Remove this plan', 'albedo'); ?>" class="albedo-delete-package button"><i class="fa fa-times"></i></a>
				<a href="javascript:;" title="<?php esc_html_e('Mark this column as description', 'albedo'); ?>" class="albedo-make-desc-col button"><i class="fa fa-info-circle"></i><input type="radio" name="pt[pricing_table][desc_col]" value="2" /></a>
				<a href="javascript:;" title="<?php esc_html_e('Mark this plan as featured', 'albedo'); ?>" class="albedo-make-featured-price button"><i class="fa fa-star"></i><input type="radio" name="pt[pricing_table][featured]" value="2" /></a>
			</th>
			<th class="ex"></th>
		</tr>
	</tfoot>
	<tbody>
		<tr class="move system-item item-icon">
			<td class="description ex">
				<i><?php esc_html_e('Icon', 'albedo'); ?></i>
			</td>
			<td class="td-icon">
				<a href="#" title="<?php esc_html_e('Upload icon', 'albedo'); ?>" class="albedo-upload-icon button"><i class="fa fa-upload"></i></a>
				<a href="#" title="<?php esc_html_e('Remove icon', 'albedo'); ?>" class="albedo-remove-icon button"><i class="fa fa-times"></i></a>
				<input type="hidden" class="icon-id" name="pt[features][icon_id][0][]" value="" />
				<input type="hidden" class="icon-url" name="pt[features][icon_url][0][]" value="" />
				<div class="plan-icon"></div>
			</td>
			<td class="td-icon">
				<a href="#" title="<?php esc_html_e('Upload icon', 'albedo'); ?>" class="albedo-upload-icon button"><i class="fa fa-upload"></i></a>
				<a href="#" title="<?php esc_html_e('Remove icon', 'albedo'); ?>" class="albedo-remove-icon button"><i class="fa fa-times"></i></a>
				<input type="hidden" class="icon-id" name="pt[features][icon_id][1][]" value="" />
				<input type="hidden" class="icon-url" name="pt[features][icon_url][1][]" value="" />
				<div class="plan-icon"></div>
			</td>
			<td class="td-icon">
				<a href="#" title="<?php esc_html_e('Upload icon', 'albedo'); ?>" class="albedo-upload-icon button"><i class="fa fa-upload"></i></a>
				<a href="#" title="<?php esc_html_e('Remove icon', 'albedo'); ?>" class="albedo-remove-icon button"><i class="fa fa-times"></i></a>
				<input type="hidden" class="icon-id" name="pt[features][icon_id][2][]" value="" />
				<input type="hidden" class="icon-url" name="pt[features][icon_url][2][]" value="" />
				<div class="plan-icon"></div>
			</td>
			<td class="ex"></td>
		</tr>
		<tr class="move system-item item-price">
			<td class="description ex">
				<i><?php esc_html_e('Price', 'albedo'); ?></i>
			</td>
			<td><input name="pt[features][price][0][]" type="text" value="" /></td>
			<td><input name="pt[features][price][1][]" type="text" value="" /></td>
			<td><input name="pt[features][price][2][]" type="text" value="" /></td>
			<td class="ex"></td>
		</tr>
		<tr class="move system-item item-period">
			<td class="description ex">
				<i><?php esc_html_e('Time period (e.g. month / year etc.)', 'albedo'); ?></i>
			</td>
			<td><input name="pt[features][period][0][]" type="text" value="" /></td>
			<td><input name="pt[features][period][1][]" type="text" value="" /></td>
			<td><input name="pt[features][period][2][]" type="text" value="" /></td>
			<td class="ex"></td>
		</tr>
		<tr class="move system-item item-details">
			<td class="description ex">
				<i><?php esc_html_e('Details / Description', 'albedo'); ?></i>
			</td>
			<td><textarea name="pt[features][details][0][]"></textarea></td>
			<td><textarea name="pt[features][details][1][]"></textarea></td>
			<td><textarea name="pt[features][details][2][]"></textarea></td>
			<td class="ex"></td>
		</tr>
		<tr class="move system-item item-button">
			<td class="description ex">
				<i><?php esc_html_e('Button text', 'albedo'); ?></i><br />
				<i><?php esc_html_e('Button URL', 'albedo'); ?></i><br />
				<i><?php esc_html_e('Button Style', 'albedo'); ?></i>
			</td>
			<td>
				<input name="pt[features][button_text][0][]" type="text" value="" /><br />
				<input name="pt[features][button_url][0][]" type="text" value="" /><br />
				<select name="pt[features][button_style][0][]">
					<?php foreach( $wplab_albedo_core_plugin->cfg['button_styles'] as $desc=>$v ): ?>
						<option value="<?php echo esc_attr( $v ); ?>"><?php echo wp_kses_post( $desc ); ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<input name="pt[features][button_text][1][]" type="text" value="" /><br />
				<input name="pt[features][button_url][1][]" type="text" value="" /><br />
				<select name="pt[features][button_style][1][]">
					<?php foreach( $wplab_albedo_core_plugin->cfg['button_styles'] as $desc=>$v ): ?>
						<option value="<?php echo esc_attr( $v ); ?>"><?php echo wp_kses_post( $desc ); ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<input name="pt[features][button_text][2][]" type="text" value="" /><br />
				<input name="pt[features][button_url][2][]" type="text" value="" /><br />
				<select name="pt[features][button_style][2][]">
					<?php foreach( $wplab_albedo_core_plugin->cfg['button_styles'] as $desc=>$v ): ?>
						<option value="<?php echo esc_attr( $v ); ?>"><?php echo wp_kses_post( $desc ); ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td class="ex"></td>
		</tr>
		<tr class="move custom-item">
			<td class="description ex">

				<a href="javascript:;" title="<?php esc_html_e('Remove this feature', 'albedo'); ?>" class="button albedo-delete-feature"><i class="fa fa-times"></i></a>

				<input name="pt[features][user_features_names][0][]" class="input-feature" type="text" value="<?php esc_html_e( 'Your feature', 'albedo'); ?>" />
			</td>
			<td><input name="pt[features][user_features_values][0][]" type="text" value="<?php esc_html_e( 'Basic value', 'albedo'); ?>" /></td>
			<td><input name="pt[features][user_features_values][1][]" type="text" value="<?php esc_html_e( 'Pro value', 'albedo'); ?>" /></td>
			<td><input name="pt[features][user_features_values][2][]" type="text" value="<?php esc_html_e( 'Unlimited value', 'albedo'); ?>" /></td>
			<td class="center ex"><img width="16" height="16" src="<?php echo get_template_directory_uri() . '/images/admin/'; ?>move@2x.png" alt="" /></td>
		</tr>
	</tbody>
	<?php else: ?>
	<thead>
		<tr>
			<th class="ex"><?php esc_html_e('Package Title', 'albedo'); ?></th>
			<?php if( isset( $data['pricing_table']['packages']['names'] ) && is_array( $data['pricing_table']['packages']['names'] ) && count( $data['pricing_table']['packages']['names'] ) > 0 ): ?>

				<?php foreach( $data['pricing_table']['packages']['names'] as $k=>$v ): ?>
				<th class="package-title"><input name="pt[packages][names][<?php echo esc_attr( $k ); ?>]" type="text" value="<?php echo esc_attr( $v ); ?>" /></th>
				<?php endforeach; ?>

			<?php endif; ?>
			<th class="ex"><a href="javascript:;" class="albedo-add-pricing-package button"><i class="fa fa-plus"></i> <?php esc_html_e('Add package', 'albedo'); ?></a></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th class="ex"><a href="javascript:;" class="albedo-add-pricing-feature button"><i class="fa fa-plus"></i> <?php esc_html_e('Add feature', 'albedo'); ?></a></th>
			<?php if( isset( $data['pricing_table']['packages']['names'] ) && is_array( $data['pricing_table']['packages']['names'] ) && count( $data['pricing_table']['packages']['names'] ) > 0 ): ?>

				<?php foreach( $data['pricing_table']['packages']['names'] as $k=>$v ): ?>

				<?php
					$desc_col = isset( $data['pricing_table']['pricing_table']['desc_col'] ) && ! is_array( $data['pricing_table']['pricing_table']['desc_col'] ) ? absint( $data['pricing_table']['pricing_table']['desc_col'] ) : -1;
					$featured = isset( $data['pricing_table']['pricing_table']['featured'] ) && ! is_array( $data['pricing_table']['pricing_table']['featured'] ) ? absint( $data['pricing_table']['pricing_table']['featured'] ) : -1;
				?>

				<th class="center">
					<a href="javascript:;" title="<?php esc_html_e('Remove this plan', 'albedo'); ?>" class="albedo-delete-package button"><i class="fa fa-times"></i></a>
					<a href="javascript:;" title="<?php esc_html_e('Mark this column as description', 'albedo'); ?>" class="albedo-make-desc-col button<?php echo $k == $desc_col ? ' button-primary' : ''; ?>"><i class="fa fa-info-circle"></i><input type="radio" <?php echo $k == $desc_col ? 'checked="checked"' : ''; ?> name="pt[pricing_table][desc_col]" value="<?php echo esc_attr( $k ); ?>" /></a>
					<a href="javascript:;" title="<?php esc_html_e('Mark this plan as featured', 'albedo'); ?>" class="albedo-make-featured-price button<?php echo $k == $featured ? ' button-primary' : ''; ?>"><i class="fa fa-star"></i><input type="radio" <?php echo $k == $featured ? 'checked="checked"' : ''; ?> name="pt[pricing_table][featured]" value="<?php echo esc_attr( $k ); ?>" /></a>
				</th>
				<?php endforeach; ?>

			<?php endif; ?>
			<th class="ex"></th>
		</tr>
	</tfoot>
	<tbody>
		<tr class="move system-item item-price">
			<td class="description ex">
				<i><?php esc_html_e('Icon', 'albedo'); ?></i>
			</td>
			<?php for( $i=0; $i<count( $data['pricing_table']['packages']['names'] ); $i++ ): ?>
			<td class="td-icon">
				<a href="#" title="<?php esc_html_e('Upload icon', 'albedo'); ?>" class="albedo-upload-icon button"><i class="fa fa-upload"></i></a>
				<a href="#" title="<?php esc_html_e('Remove icon', 'albedo'); ?>" class="albedo-remove-icon button"><i class="fa fa-times"></i></a>
				<input type="hidden" class="icon-id" name="pt[features][icon_id][<?php echo esc_attr( $i ); ?>][]" value="<?php echo isset($data['pricing_table']['features']['icon_id'][ $i ][0]) ? esc_attr( $data['pricing_table']['features']['icon_id'][ $i ][0] ) : ''; ?>" />
				<?php $icon_isset = isset($data['pricing_table']['features']['icon_url'][ $i ][0]) && $data['pricing_table']['features']['icon_url'][ $i ][0] <> ''; ?>
				<input type="hidden" class="icon-url" name="pt[features][icon_url][<?php echo esc_attr( $i ); ?>][]" value="<?php echo $icon_isset ? esc_attr( $data['pricing_table']['features']['icon_url'][ $i ][0] ) : ''; ?>" />
				<div class="plan-icon <?php if($icon_isset): echo 'with-icon'; endif; ?>" style="<?php if($icon_isset): echo 'background-image: url(' . $data['pricing_table']['features']['icon_url'][ $i ][0] . ')'; endif; ?>"></div>
			</td>
			<?php endfor; ?>
			<td class="ex"></td>
		</tr>
		<tr class="move system-item item-price">
			<td class="description ex">
				<i><?php esc_html_e('Price', 'albedo'); ?></i>
			</td>
			<?php for( $i=0; $i<count( $data['pricing_table']['packages']['names'] ); $i++ ): ?>
			<td><input name="pt[features][price][<?php echo esc_attr( $i ); ?>][]" type="text" value="<?php echo isset($data['pricing_table']['features']['price'][ $i ][0]) ? esc_attr( $data['pricing_table']['features']['price'][ $i ][0] ) : ''; ?>" /></td>
			<?php endfor; ?>
			<td class="ex"></td>
		</tr>
		<tr class="move system-item item-period">
			<td class="description ex">
				<i><?php esc_html_e('Time period (e.g. month / year etc.)', 'albedo'); ?></i>
			</td>
			<?php for( $i=0; $i<count( $data['pricing_table']['packages']['names'] ); $i++ ): ?>
			<td><input name="pt[features][period][<?php echo esc_attr( $i ); ?>][]" type="text" value="<?php echo isset($data['pricing_table']['features']['period'][ $i ][0]) ? esc_attr( $data['pricing_table']['features']['period'][ $i ][0] ) : ''; ?>" /></td>
			<?php endfor; ?>
			<td class="ex"></td>
		</tr>
		<tr class="move system-item item-details">
			<td class="description ex">
				<i><?php esc_html_e('Details / Description', 'albedo'); ?></i>
			</td>
			<?php for( $i=0; $i<count( $data['pricing_table']['packages']['names'] ); $i++ ): ?>
			<td><textarea name="pt[features][details][<?php echo esc_attr( $i ); ?>][]"><?php echo isset($data['pricing_table']['features']['details'][ $i ][0]) ? esc_textarea( $data['pricing_table']['features']['details'][ $i ][0] ) : ''; ?></textarea></td>
			<?php endfor; ?>
			<td class="ex"></td>
		</tr>
		<tr class="move system-item item-button">
			<td class="description ex">
				<i><?php esc_html_e('Button text', 'albedo'); ?></i><br />
				<i><?php esc_html_e('Button URL', 'albedo'); ?></i><br/>
				<i><?php esc_html_e('Button Style', 'albedo'); ?></i>
			</td>
			<?php for( $i=0; $i<count( $data['pricing_table']['packages']['names'] ); $i++ ): ?>
			<td>
				<input name="pt[features][button_text][<?php echo esc_attr( $i ); ?>][]" type="text" value="<?php echo isset($data['pricing_table']['features']['button_text'][ $i ][0]) ? esc_attr( $data['pricing_table']['features']['button_text'][ $i ][0] ) : ''; ?>" /><br />
				<input name="pt[features][button_url][<?php echo esc_attr( $i ); ?>][]" type="text" value="<?php echo isset($data['pricing_table']['features']['button_url'][ $i ][0]) ? esc_attr( $data['pricing_table']['features']['button_url'][ $i ][0] ) : ''; ?>" />
				<select name="pt[features][button_style][<?php echo esc_attr( $i ); ?>][]">
					<?php foreach( $wplab_albedo_core_plugin->cfg['button_styles'] as $desc=>$v ): ?>
						<option <?php echo isset( $data['pricing_table']['features']['button_style'][ $i ][0]) && $data['pricing_table']['features']['button_style'][ $i ][0] == $v ? 'selected="selected"' : ''; ?> value="<?php echo esc_attr( $v ); ?>"><?php echo wp_kses_post( $desc ); ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<?php endfor; ?>
			<td class="ex"></td>
		</tr>
		<?php if( isset( $data['pricing_table']['features']['user_features_names'] ) && count( $data['pricing_table']['features']['user_features_names'] ) ): ?>

			<?php foreach( $data['pricing_table']['features']['user_features_names'] as $k=>$v ): ?>

			<tr class="move custom-item">
				<td class="description ex">

					<a href="javascript:;" title="<?php esc_html_e('Remove this feature', 'albedo'); ?>" class="button albedo-delete-feature"><i class="fa fa-times"></i></a>

					<input name="pt[features][user_features_names][<?php $k; ?>][]" type="text" value="<?php echo isset( $v[0] ) ? esc_attr( $v[0] ) : ''; ?>" />
				</td>

				<?php for( $i=0; $i<count( $data['pricing_table']['packages']['names'] ); $i++ ): ?>
				<td><input name="pt[features][user_features_values][<?php echo esc_attr( $i ); ?>][]" type="text" value="<?php echo isset( $data['pricing_table']['features']['user_features_values'][$i][$k] ) ? esc_attr( $data['pricing_table']['features']['user_features_values'][$i][$k] ) : ''; ?>" /></td>
				<?php endfor; ?>
				<td class="center ex"><img width="16" height="16" src="<?php echo get_template_directory_uri() . '/images/admin/'; ?>move@2x.png" alt="" /></td>
			</tr>

			<?php endforeach; ?>

		<?php endif; ?>

	</tbody>

	<?php endif; ?>
</table>
