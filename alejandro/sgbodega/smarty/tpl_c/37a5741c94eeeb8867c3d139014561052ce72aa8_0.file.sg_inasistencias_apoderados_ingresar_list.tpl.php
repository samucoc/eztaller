<?php
/* Smarty version 3.1.33, created on 2019-08-23 12:20:39
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_inasistencias_apoderados_ingresar_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d601257414ef5_13995055',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '37a5741c94eeeb8867c3d139014561052ce72aa8' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_inasistencias_apoderados_ingresar_list.tpl',
      1 => 1563312319,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d601257414ef5_13995055 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/includes/php/cls_smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Periodo
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' colspan="10">
			<?php echo $_smarty_tpl->tpl_vars['periodo']->value;?>

		</td>
	</tr>
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left' >
			Curso
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' colspan="10">
			<?php echo $_smarty_tpl->tpl_vars['curso']->value;?>

		</td>
	</tr>
		<?php
$__section_alumnos_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrAlumnos']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_alumnos_0_total = $__section_alumnos_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_alumnos'] = new Smarty_Variable(array());
if ($__section_alumnos_0_total !== 0) {
for ($__section_alumnos_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_alumnos']->value['index'] = 0; $__section_alumnos_0_iteration <= $__section_alumnos_0_total; $__section_alumnos_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_alumnos']->value['index']++){
?>
		<tr>
       		<td class='grilla-tab-fila-campo-pequenio' align='left' style="width: 20%;">
       			<?php echo $_smarty_tpl->tpl_vars['arrAlumnos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_alumnos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_alumnos']->value['index'] : null)]['nombre_alumno'];?>

            </td>
			<?php
$__section_registrosDetalle_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registrosDetalle_1_total = $__section_registrosDetalle_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle'] = new Smarty_Variable(array());
if ($__section_registrosDetalle_1_total !== 0) {
for ($__section_registrosDetalle_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] = 0; $__section_registrosDetalle_1_iteration <= $__section_registrosDetalle_1_total; $__section_registrosDetalle_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']++){
?>
				<?php
$__section_registros_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistros']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registros_2_total = $__section_registros_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registros'] = new Smarty_Variable(array());
if ($__section_registros_2_total !== 0) {
for ($__section_registros_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] = 0; $__section_registros_2_iteration <= $__section_registros_2_total; $__section_registros_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']++){
?>
					<?php if (($_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['fecha'] == $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['fecha']) && ($_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['rut_alumno'] == $_smarty_tpl->tpl_vars['arrAlumnos']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_alumnos']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_alumnos']->value['index'] : null)]['rut_alumno'])) {?>
						<?php if ($_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['rut_alumno'] == '-----') {?>
						<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" >
							<?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['fecha'] == 'promedio') {?>
								Porc. Asistencia
							<?php } else { ?>
								<a href="#" title="<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['title'];?>
"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['fecha'],'%d/%m/%Y');?>
</a>
							<?php }?>
	                    </td>
						<?php } else { ?>
	             		<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" onclick="xajax_ConfirmarInasistencia(xajax.getFormValues('Form1'),'<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['rut_alumno'];?>
','<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['fecha'];?>
');">
	             			<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['checked'];?>

	                    </td>
	                    <?php }?>
		            <?php }?>
		        <?php
}
}
?>
			<?php
}
}
?>
		</tr>
		<?php
}
}
?>
<tr>
	<td colspan="<?php echo $_smarty_tpl->tpl_vars['cant_dias']->value+5;?>
" class="grilla-tab-fila-titulo">
        <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
     
	</td>
</tr>
</table>
<?php }
}
