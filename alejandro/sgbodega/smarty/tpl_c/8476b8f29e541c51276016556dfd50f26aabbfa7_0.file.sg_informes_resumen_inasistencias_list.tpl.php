<?php
/* Smarty version 3.1.33, created on 2019-07-29 11:45:10
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_informes_resumen_inasistencias_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d3f1486cf36f1_18973868',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8476b8f29e541c51276016556dfd50f26aabbfa7' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_informes_resumen_inasistencias_list.tpl',
      1 => 1563312325,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d3f1486cf36f1_18973868 (Smarty_Internal_Template $_smarty_tpl) {
?><table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='center'>
			Curso
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Mar
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Abr
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			May
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Jun
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Jul
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Ago
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Sep
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Oct
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Nov
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Dic
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center'>
			Total
		</td>
	</tr>
<?php
$__section_registros_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistros']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registros_0_total = $__section_registros_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registros'] = new Smarty_Variable(array());
if ($__section_registros_0_total !== 0) {
for ($__section_registros_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] = 0; $__section_registros_0_iteration <= $__section_registros_0_total; $__section_registros_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']++){
?>
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nombre_curso'];?>

		</td>
		<?php
$__section_registrosDetalle_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registrosDetalle_1_total = $__section_registrosDetalle_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle'] = new Smarty_Variable(array());
if ($__section_registrosDetalle_1_total !== 0) {
for ($__section_registrosDetalle_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] = 0; $__section_registrosDetalle_1_iteration <= $__section_registrosDetalle_1_total; $__section_registrosDetalle_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']++){
?>
        	<?php if ($_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['curso'] == $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['curso']) {?>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['marzo'];?>

                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['abril'];?>

                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['mayo'];?>

                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['junio'];?>

                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['julio'];?>

                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['agosto'];?>

                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['septiembre'];?>

                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['octubre'];?>

                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['noviembre'];?>

                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['diciembre'];?>

                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['total'];?>

                </td>
            <?php }?>
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
	<td colspan="<?php echo $_smarty_tpl->tpl_vars['cant_dias']->value+3;?>
" class="grilla-tab-fila-titulo">
      <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
     	<a href="#" style="cursor: hand;" onclick="showPopWin('sg_informe_visualizador_resumen_inasistencias.php?anio=<?php echo $_smarty_tpl->tpl_vars['anio']->value;?>
', 'Grafico Resumen Inasistencias Colegio', 1440, 650, null);" class="btn btn-primary text-center align-middle" title="Grafico Resumen Inasistencias Colegio">
        <i class="fa fa-bar-chart fa-2x" aria-hidden="true"></i>
      </a>
    	<?php if ($_smarty_tpl->tpl_vars['curso']->value != '') {?>
    	<a href="#" style="cursor: hand;" onclick="showPopWin('sg_informe_visualizador_curso_resumen_inasistencias.php?anio=<?php echo $_smarty_tpl->tpl_vars['anio']->value;?>
&curso=<?php echo $_smarty_tpl->tpl_vars['curso']->value;?>
', 'Grafico Resumen Inasistencias Curso', 750, 650, null);" class="btn btn-primary text-center align-middle " title="Grafico Resumen Inasistencias Curso">
        <i class="fa fa-bar-chart fa-2x" aria-hidden="true"></i>
      </a>
    	<?php }?>
    </td>
</tr>
</table>
<?php }
}
