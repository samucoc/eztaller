<?php
/* Smarty version 3.1.33, created on 2019-07-29 12:07:03
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_informe_consulta_calendario_planificacion_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d3f19a75be4a3_26525088',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '201b15a41acded7864729c35e3208fa3523ea91e' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_informe_consulta_calendario_planificacion_list.tpl',
      1 => 1563312327,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d3f19a75be4a3_26525088 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td colspan="20" class="grilla-tab-fila-titulo" align='center'>
            Consulta y Seguimiento de Evaluaciones
        </td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align='center'>Curso</td>
        <td class="grilla-tab-fila-titulo" align='center'>Asignatura</td>
        <td class="grilla-tab-fila-titulo" align='center'>Profesor</td>
        <td class="grilla-tab-fila-titulo" align='center'>Nota</td>
        <td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
        <td class="grilla-tab-fila-titulo" align='center'>Descripci&oacute;n</td>
        <td class="grilla-tab-fila-titulo" align='center'>Tipo</td>
        <td class="grilla-tab-fila-titulo" align='center'>I</td>
        <td class="grilla-tab-fila-titulo" align='center'>S</td>
        <td class="grilla-tab-fila-titulo" align='center'>B</td>
        <td class="grilla-tab-fila-titulo" align='center'>MB</td>
    </tr>
    <?php
$__section_registros_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistros']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registros_0_total = $__section_registros_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registros'] = new Smarty_Variable(array());
if ($__section_registros_0_total !== 0) {
for ($__section_registros_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] = 0; $__section_registros_0_iteration <= $__section_registros_0_total; $__section_registros_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']++){
?>
            <tr> 
                <td class="grilla-tab-fila-campo" align='left' ><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'];?>
</td>
                <td class="grilla-tab-fila-campo" align='left' ><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['Descripcion'];?>
</td>
                <td class="grilla-tab-fila-campo" align='left'><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['profesor'];?>
</td>
                <td class="grilla-tab-fila-campo" align='center'><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NumeroNota'];?>
</td>
                <td class="grilla-tab-fila-campo" align='center'><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['FechaPrueba'];?>
</td>
                <td class="grilla-tab-fila-campo" align='left'><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['DescripcionPrueba'];?>
</td>
                <td class="grilla-tab-fila-campo" align='left'><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['DescripcionPlazo'];?>
</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 40px; color: white; background-color: #F01614"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['insuficiente'];?>
 %</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 40px; color: black; background-color: orange"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['suficiente'];?>
 %</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 40px; color: black; background-color: yellow"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['bueno'];?>
 %</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 40px; color: black; background-color: #30C805"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['muy_bueno'];?>
 %</td>
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
</div>
<?php }
}
