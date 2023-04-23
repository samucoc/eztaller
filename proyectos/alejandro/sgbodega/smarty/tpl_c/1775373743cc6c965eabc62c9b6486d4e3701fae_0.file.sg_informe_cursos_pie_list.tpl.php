<?php
/* Smarty version 3.1.33, created on 2019-06-13 14:17:49
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/test/sige/smarty/tpl/sg_informe_cursos_pie_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d02934d941e01_57052158',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1775373743cc6c965eabc62c9b6486d4e3701fae' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/test/sige/smarty/tpl/sg_informe_cursos_pie_list.tpl',
      1 => 1506555114,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d02934d941e01_57052158 (Smarty_Internal_Template $_smarty_tpl) {
?><div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
         <td class='grilla-tab-fila-titulo-pequenio' align='left' colspan="10">
               Apoyo a la Diversidad (Informaci&oacute;n reservada)
            </td>
    </tr>
    <tr>
         <td class='grilla-tab-fila-titulo-pequenio' align='left'>
               Curso:
            </td>
         <td class='grilla-tab-fila-campo-pequenio' align='left' colspan="10">
                <?php echo $_smarty_tpl->tpl_vars['nombre_curso']->value;?>

            </td>
    </tr>
    <tr>
            <td class='grilla-tab-fila-titulo-pequenio' align='left'>
                Profesor:
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left' colspan="10">
                <?php echo $_smarty_tpl->tpl_vars['nombre_profe']->value;?>

            </td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nro Lista</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Rut Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nombre Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Pie</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Observacion</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">E. Dif.</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Observacion</td>
        
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
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nro_lista'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['rut_alumno'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nombre_alumno'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['PIE'] == '1') {?>
                    SI
                <?php } else { ?>
                     
                <?php }?>
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['TextPIE'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['EvaluacionDiferenciada'] == '1') {?>
                   SI
                <?php } else { ?>
                     
                <?php }?>
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['TextEvaluacionDiferenciada'];?>

            </td>
            
        </tr>
    <?php
}
}
?>

    </table>
</div><?php }
}
