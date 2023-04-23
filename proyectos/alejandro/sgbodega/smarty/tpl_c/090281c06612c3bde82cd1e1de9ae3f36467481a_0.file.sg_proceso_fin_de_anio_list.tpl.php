<?php
/* Smarty version 3.1.33, created on 2019-10-09 16:27:35
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_proceso_fin_de_anio_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d9e34a76f7439_46517552',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '090281c06612c3bde82cd1e1de9ae3f36467481a' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_proceso_fin_de_anio_list.tpl',
      1 => 1563312335,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d9e34a76f7439_46517552 (Smarty_Internal_Template $_smarty_tpl) {
?><div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Curso</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Situaci&oacute;n</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Accion</td>
        
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
                <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['situacion'] == '1') {?>
                    <img src='../images/tick.png' width='24' title='Proceso Cerrado' />
                <?php } else { ?>
                    <img src='../images/stop.png' width='24' title='Proceso Pendiente' />
                <?php }?>
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['situacion_final'] == '1') {?>

                <?php } else { ?>
                <a href="#" onclick="xajax_Grabar(xajax.getFormValues('Form1'),'<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['codigo_curso'];?>
');">
                    <img src='../images/basicos/agregar.png' title='Realizar Fin de A&ntilde;o' width="32"/>                    
                </a>
                <?php }?>
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
