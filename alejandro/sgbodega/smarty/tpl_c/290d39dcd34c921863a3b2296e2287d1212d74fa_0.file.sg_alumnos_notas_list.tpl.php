<?php
/* Smarty version 3.1.33, created on 2018-12-11 20:28:59
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/test/sige/smarty/tpl/sg_alumnos_notas_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c10483b13bf07_32258890',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '290d39dcd34c921863a3b2296e2287d1212d74fa' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/test/sige/smarty/tpl/sg_alumnos_notas_list.tpl',
      1 => 1497402669,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c10483b13bf07_32258890 (Smarty_Internal_Template $_smarty_tpl) {
?><div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
    	<td class="grilla-tab-fila-titulo" align="left">Alumno</td>
    	<td class="grilla-tab-fila-titulo" colspan="<?php echo $_smarty_tpl->tpl_vars['notas_ingresadas']->value+1;?>
" align="left" style="font-weight: bold"><?php echo $_smarty_tpl->tpl_vars['nombre_alumno']->value;?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align="left">Curso</td>
        <td class="grilla-tab-fila-titulo" colspan="<?php echo $_smarty_tpl->tpl_vars['notas_ingresadas']->value+1;?>
" align="left" style="font-weight: bold"><?php echo $_smarty_tpl->tpl_vars['nombre_curso']->value;?>
</td>
    </tr>
       	<tr>
    	<td class="grilla-tab-fila-titulo" align="left">Semestre</td>
    	<td class="grilla-tab-fila-titulo" colspan="<?php echo $_smarty_tpl->tpl_vars['notas_ingresadas']->value+1;?>
"  align="center" style="font-weight: bold"><?php echo $_smarty_tpl->tpl_vars['nombre_semestre']->value;?>
</td>
    </tr>
    
    <tr>
        <td class="grilla-tab-fila-titulo"  align="left">Asignatura</td>
        <?php
$__section_cu_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['notas_ingresadas']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_cu_0_start = min(0, $__section_cu_0_loop);
$__section_cu_0_total = min(($__section_cu_0_loop - $__section_cu_0_start), $__section_cu_0_loop);
$_smarty_tpl->tpl_vars['__smarty_section_cu'] = new Smarty_Variable(array());
if ($__section_cu_0_total !== 0) {
for ($__section_cu_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_cu']->value['index'] = $__section_cu_0_start; $__section_cu_0_iteration <= $__section_cu_0_total; $__section_cu_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_cu']->value['index']++){
?>
		   	<td class="grilla-tab-fila-titulo" align="center">
				N-<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_cu']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cu']->value['index'] : null)+1;?>

            </td>
        <?php
}
}
?>
        <td class="grilla-tab-fila-titulo" align="center">
				Promedio
            </td> 
    </tr>
    <?php
$__section_registros_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistros']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registros_1_total = $__section_registros_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registros'] = new Smarty_Variable(array());
if ($__section_registros_1_total !== 0) {
for ($__section_registros_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] = 0; $__section_registros_1_iteration <= $__section_registros_1_total; $__section_registros_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']++){
?>
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nombre_asignatura'];?>

            </td>
            <?php
$__section_registrosDetalle_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registrosDetalle_2_total = $__section_registrosDetalle_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle'] = new Smarty_Variable(array());
if ($__section_registrosDetalle_2_total !== 0) {
for ($__section_registrosDetalle_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] = 0; $__section_registrosDetalle_2_iteration <= $__section_registrosDetalle_2_total; $__section_registrosDetalle_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']++){
?>
                <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['codigo_asignatura'] == $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['codigo_asignatura']) {?>
                        <td class='grilla-tab-fila-campo' align='center' >
                        	<?php if ($_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['nota'] < 4) {?>
                            <div style="color:#FF0000">                
                                <?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['nota'];?>

                            </div>
                            <?php } else { ?>
                                <?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['nota'];?>

                            <?php }?>
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
        <td colspan='16' class="grilla-tab-fila-titulo">
            <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
    
        </td>
    </tr>
    </table>
</div><?php }
}
