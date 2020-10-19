<?php
/* Smarty version 3.1.33, created on 2018-12-11 20:39:09
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/test/sige/smarty/tpl/sg_alumnos_HojaVida_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c104a9d900d14_26181730',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cbbb3705dd8c293aaf17d0ada4c9ed557d6ae188' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/test/sige/smarty/tpl/sg_alumnos_HojaVida_list.tpl',
      1 => 1497402907,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c104a9d900d14_26181730 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/test/sige/includes/php/cls_smarty/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
        <td class="grilla-tab-fila-titulo" align="left">Alumno</td>
        <td class="grilla-tab-fila-titulo" colspan="4" align="left" style="font-weight: bold"><?php echo $_smarty_tpl->tpl_vars['nombre_alumno']->value;?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align="left">Curso</td>
        <td class="grilla-tab-fila-titulo" colspan="4" align="left" style="font-weight: bold"><?php echo $_smarty_tpl->tpl_vars['nombre_curso']->value;?>
</td>
    </tr>
        <tr >
            <td class='grilla-tab-fila-campo' align='center'>
                Fecha
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Asignatura
            </td>
            <td class="grilla-tab-fila-campo" align="center">
                Tipo Anotaci&oacute;n
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Motivo
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Descripci&oacute;n
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
                <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['FechaHojaVida'],"%d-%m-%Y");?>

            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['ramo'];?>

            </td>
            <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nombre'] == 'Positiva') {?>
                <td class="grilla-tab-fila-campo" align="center">
                    <a href="#"><img src='../images/cara_verde.jpg' title='Positiva' width="24" /></a>
                </td>
            <?php } else { ?>  
                <td class="grilla-tab-fila-campo" align="center">
                    <a href="#"><img src='../images/cara_roja.jpg' title='Negativa' width="24" /></a>
                </td>
            <?php }?>
            <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['DescripcionMotivo'];?>

            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['DescripcionHojaVida'];?>

            </td>
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
