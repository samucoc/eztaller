<?php
/* Smarty version 3.1.33, created on 2019-07-29 12:11:15
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_informe_porcentaje_asistencia_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d3f1aa3e82385_11095712',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2d3f7a4d19bd5df7d4617e595ae4f0b79af81129' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_informe_porcentaje_asistencia_list.tpl',
      1 => 1563312328,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d3f1aa3e82385_11095712 (Smarty_Internal_Template $_smarty_tpl) {
?><table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
    		Curso
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Porcentaje
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
			<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['curso'];?>

		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['porcentaje'];?>

		</td>
		<td class="grilla-tab-fila-campo-pequenio">
			<?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['porcentaje'] < '85') {?>
				<img src='../../sgcobranza/images/cara_roja.jpg' width='24'/>
			<?php } elseif ((($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['porcentaje'] >= '85') && ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['porcentaje'] <= '90'))) {?>
				<img src='../../sgcobranza/images/cara_amarilla.jpg' width='24'/>
			<?php } else { ?>
				<img src='../../sgcobranza/images/cara_verde.jpg' width='24'/>
			<?php }?>
		</td>
	</tr>
<?php
}
}
?>
<tr>
	<td colspan="<?php echo $_smarty_tpl->tpl_vars['cant_dias']->value+3;?>
" class="grilla-tab-fila-titulo">
        <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
        <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Grafico" onclick="showPopWin('sg_informe_porcentaje_asistencia_grafico.php?anio=<?php echo $_smarty_tpl->tpl_vars['anio']->value;?>
&periodo=<?php echo $_smarty_tpl->tpl_vars['periodo']->value;?>
', 'Grafico', 1200, 300, null);" width="32"></a>
	</td>
</tr>
</table>
<?php }
}
