<?php
/* Smarty version 3.1.33, created on 2019-08-08 11:44:05
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_informe_relacion_apoderados_alumnos_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d4c4345bccdd1_16019828',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd66ecf83f87d5ea37ad61ce9cf82d4c783e79144' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_informe_relacion_apoderados_alumnos_list.tpl',
      1 => 1563312328,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d4c4345bccdd1_16019828 (Smarty_Internal_Template $_smarty_tpl) {
?><div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr >
            <td class='grilla-tab-fila-campo' align='center'>
                Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Telefono Particular Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Telefono Movil Apoderado
            </td>
           <td class='grilla-tab-fila-campo' align='center'>
                Alumno
            </td>
           <td class='grilla-tab-fila-campo' align='center'>
                Nombre Curso
            </td>
           
    </tr>
    <?php
$__section_registros_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistros']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registros_0_total = $__section_registros_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registros'] = new Smarty_Variable(array());
if ($__section_registros_0_total !== 0) {
for ($__section_registros_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] = 0; $__section_registros_0_iteration <= $__section_registros_0_total; $__section_registros_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']++){
?>
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['apoderado'];?>

            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['TelefonoParticularApoderado'];?>

            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['TelefonoMovilApoderado'];?>

            </td>
           <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['alumno'];?>

            </td>
           <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'];?>

            </td>
           
	    </tr>
    <?php
}
}
?>
    <tr>
        <td  class="grilla-tab-fila-titulo">
            Cantidad Apoderados
        </td>
        <td colspan="16" class="grilla-tab-fila-titulo">
            <?php echo $_smarty_tpl->tpl_vars['apoderados']->value;?>

        </td>
    </tr>
    <tr>
        <td  class="grilla-tab-fila-titulo">
            Cantidad Alumnos
        </td>
        <td colspan="16" class="grilla-tab-fila-titulo">
            <?php echo $_smarty_tpl->tpl_vars['alumnos']->value;?>

        </td>
    </tr>
    </table>
</div><?php }
}
