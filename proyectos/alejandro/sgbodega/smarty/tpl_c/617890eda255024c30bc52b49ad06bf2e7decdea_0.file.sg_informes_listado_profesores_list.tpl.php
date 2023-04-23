<?php
/* Smarty version 3.1.33, created on 2019-07-29 12:44:01
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_informes_listado_profesores_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d3f225174d7a9_21575686',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '617890eda255024c30bc52b49ad06bf2e7decdea' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_informes_listado_profesores_list.tpl',
      1 => 1563312324,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d3f225174d7a9_21575686 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/includes/php/cls_smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nombre </td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Rut </td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Tipo Funcionario </td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Fecha Ingreso </td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">A&ntilde;os de Servicio </td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Direccion </td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Telefono </td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Email </td>
    </tr>
    <?php
$__section_registros_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistros']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registros_0_total = $__section_registros_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registros'] = new Smarty_Variable(array());
if ($__section_registros_0_total !== 0) {
for ($__section_registros_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] = 0; $__section_registros_0_iteration <= $__section_registros_0_total; $__section_registros_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']++){
?>
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nombre'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['rut'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreTipoFuncionario'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['IngresoFuncionario'],"%d/%m/%Y");?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['fe'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['direccion'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['telefono'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['email'];?>

            </td>
        </tr>
    <?php
}
}
?>
    </table>
</div><?php }
}
