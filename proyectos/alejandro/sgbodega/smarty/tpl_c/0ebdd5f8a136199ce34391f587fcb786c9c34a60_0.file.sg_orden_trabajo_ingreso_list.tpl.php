<?php
/* Smarty version 3.1.33, created on 2020-10-19 12:26:04
  from 'C:\xampp\htdocs\eztaller\eztaller\alejandro\sgbodega\smarty\tpl\sg_orden_trabajo_ingreso_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5f8db00c26d646_29031235',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0ebdd5f8a136199ce34391f587fcb786c9c34a60' => 
    array (
      0 => 'C:\\xampp\\htdocs\\eztaller\\eztaller\\alejandro\\sgbodega\\smarty\\tpl\\sg_orden_trabajo_ingreso_list.tpl',
      1 => 1393958877,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f8db00c26d646_29031235 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">


<?php
$__section_registros_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistros']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registros_0_total = $__section_registros_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registros'] = new Smarty_Variable(array());
if ($__section_registros_0_total !== 0) {
for ($__section_registros_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] = 0; $__section_registros_0_iteration <= $__section_registros_0_total; $__section_registros_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']++){
?>
	<tr>
		<td class="grilla-tab-fila-campo" style="width: 7%"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['codigo'];?>
</td>
		<td class="grilla-tab-fila-campo" style="width: 38%"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['descripcion'];?>
</td>
		<td class="grilla-tab-fila-campo" style="width: 7%" align='right'><?php echo number_format($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['cantidad'],0,',','.');?>
</td>
		<td class="grilla-tab-fila-campo">
			<a href="#" style="cursor: hand;"><img src="../images/cross.png" border=0 title="Eliminar" onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['ncorr'];?>
');"></a>
		</td>
	</tr>
		
<?php
}
}
?>

</table>
</div>



<?php }
}
