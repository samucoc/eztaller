<?php
/* Smarty version 3.1.33, created on 2019-10-10 10:36:35
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_cursos_malla_curricular_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d9f33e35b8572_65470953',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a12d87e40a94ec2d413b00d96b478712dd296194' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_cursos_malla_curricular_list.tpl',
      1 => 1563312316,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d9f33e35b8572_65470953 (Smarty_Internal_Template $_smarty_tpl) {
?><div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Curso</td>
        <td class="grilla-tab-fila-titulo-pequenio" colspan="4" align="center"><?php echo $_smarty_tpl->tpl_vars['nombre_curso']->value;?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">C&oacute;digo Asginatura</td>
        <td class="grilla-tab-fila-titulo-pequenio" colspan="4" align="center">Nombre Asignatura</td>
    </tr>
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo" align='center'>Curso</td>
        <td class="grilla-tab-fila-titulo" align='center'>N&uacute;mero Orden</td>
        <td class="grilla-tab-fila-titulo" align='center'>Asignatura</td>
        <td class="grilla-tab-fila-titulo" align='center'>Profesor</td>
        <td class="grilla-tab-fila-titulo" align='center'>C&oacute;digo RECH</td>
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
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['curso'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['numero'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['Descripcion'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['profesor'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['RECH'];?>

            </td>
            
	    </tr>
    <?php
}
}
?>
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
            <a href="#" style="cursor: hand;"><img src="../images/basicos/salida.png" border=0 title="Volver" onclick="window.history.back();" width="32"></a>
    
        </td>
    </tr>
    </table>
</div><?php }
}
