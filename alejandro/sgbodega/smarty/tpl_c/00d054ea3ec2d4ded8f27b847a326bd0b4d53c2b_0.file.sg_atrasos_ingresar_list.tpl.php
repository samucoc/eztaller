<?php
/* Smarty version 3.1.33, created on 2019-07-23 15:46:29
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_atrasos_ingresar_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d376415e5dce5_04871691',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '00d054ea3ec2d4ded8f27b847a326bd0b4d53c2b' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_atrasos_ingresar_list.tpl',
      1 => 1563312314,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d376415e5dce5_04871691 (Smarty_Internal_Template $_smarty_tpl) {
?><table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Nro Lista
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Alumno
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' colspan="<?php echo $_smarty_tpl->tpl_vars['cant_dias']->value;?>
">
			Fecha
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Total
		</td>
	</tr>
    <tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
        </td>
		<?php
$__section_dias_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrDias']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_dias_0_total = $__section_dias_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_dias'] = new Smarty_Variable(array());
if ($__section_dias_0_total !== 0) {
for ($__section_dias_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_dias']->value['index'] = 0; $__section_dias_0_iteration <= $__section_dias_0_total; $__section_dias_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_dias']->value['index']++){
?>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			<?php echo $_smarty_tpl->tpl_vars['arrDias']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_dias']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_dias']->value['index'] : null)]['nro_dia'];?>

		</td>
        <?php
}
}
?>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
        </td>
    </tr>
<?php
$__section_registros_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistros']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registros_1_total = $__section_registros_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registros'] = new Smarty_Variable(array());
if ($__section_registros_1_total !== 0) {
for ($__section_registros_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] = 0; $__section_registros_1_iteration <= $__section_registros_1_total; $__section_registros_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']++){
?>
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['numero_lista'];?>

		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nombre_alumno'];?>

		</td>
		<?php
$__section_registrosDetalle_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registrosDetalle_2_total = $__section_registrosDetalle_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle'] = new Smarty_Variable(array());
if ($__section_registrosDetalle_2_total !== 0) {
for ($__section_registrosDetalle_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] = 0; $__section_registrosDetalle_2_iteration <= $__section_registrosDetalle_2_total; $__section_registrosDetalle_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']++){
?>
        	<?php if ($_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['rut_alumno'] == $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['rut_alumno']) {?>
                <?php if ($_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['domingo'] == 'SI' || $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['festivo'] == 'SI') {?>
					<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" style="background-color:#F00">
                    </td>
                <?php } else { ?>
                    <?php if ($_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['atraso'] == 'SI') {?>
                    <td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" ondblclick="xajax_EliminarAtraso(xajax.getFormValues('Form1'),'<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['rut_alumno'];?>
','<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['fecha'];?>
');" >
                    X
                    </td>
                    <?php } else { ?>
                    <td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" ondblclick="xajax_ConfirmarAtraso(xajax.getFormValues('Form1'),'<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['rut_alumno'];?>
','<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['fecha'];?>
');">
                    </td>
                    <?php }?>
                <?php }?>
            <?php }?>
        <?php
}
}
?>
        <td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px">
			<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['contador'];?>

        </td>
	</tr>
<?php
}
}
?>
    <tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
        </td>
		<?php
$__section_dias_3_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrDias']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_dias_3_total = $__section_dias_3_loop;
$_smarty_tpl->tpl_vars['__smarty_section_dias'] = new Smarty_Variable(array());
if ($__section_dias_3_total !== 0) {
for ($__section_dias_3_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_dias']->value['index'] = 0; $__section_dias_3_iteration <= $__section_dias_3_total; $__section_dias_3_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_dias']->value['index']++){
?>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			<?php echo $_smarty_tpl->tpl_vars['arrDias']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_dias']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_dias']->value['index'] : null)]['nro_dia'];?>

		</td>
        <?php
}
}
?>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
        </td>
    </tr>
<tr>
	<td colspan="<?php echo $_smarty_tpl->tpl_vars['cant_dias']->value+3;?>
" class="grilla-tab-fila-titulo">
        <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
    
	</td>
</tr>
</table>
<?php }
}
