<?php
/* Smarty version 3.1.33, created on 2019-07-25 12:45:22
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_alumnos_Asistencia_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d39dca2589359_75710297',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3dc90490d4efc4bca4693282c9e39966e5bfc916' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_alumnos_Asistencia_list.tpl',
      1 => 1563312312,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d39dca2589359_75710297 (Smarty_Internal_Template $_smarty_tpl) {
?><div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
    	<td class="grilla-tab-fila-titulo" align="left">Alumno</td>
    	<td class="grilla-tab-fila-titulo" colspan="4" align="left" style="font-weight: bold; width: 80% !important"><?php echo $_smarty_tpl->tpl_vars['nombre_alumno']->value;?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align="left">Curso</td>
        <td class="grilla-tab-fila-titulo" colspan="4" align="left" style="font-weight: bold"><?php echo $_smarty_tpl->tpl_vars['nombre_curso']->value;?>
</td>
    </tr>
        <?php
$__section_registros1_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistros1']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registros1_0_total = $__section_registros1_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registros1'] = new Smarty_Variable(array());
if ($__section_registros1_0_total !== 0) {
for ($__section_registros1_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registros1']->value['index'] = 0; $__section_registros1_0_iteration <= $__section_registros1_0_total; $__section_registros1_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registros1']->value['index']++){
?>
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <?php if ((($_smarty_tpl->tpl_vars['arrRegistros1']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros1']->value['index'] : null)]['FechaInasistencia'] == 'Inasistencias') || ($_smarty_tpl->tpl_vars['arrRegistros1']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros1']->value['index'] : null)]['FechaInasistencia'] == 'Atrasos'))) {?>
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        
                    </td>
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        <?php echo $_smarty_tpl->tpl_vars['arrRegistros1']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros1']->value['index'] : null)]['FechaInasistencia'];?>

                    </td>
                <?php } else { ?>
                    <td class='grilla-tab-fila-campo' align='left'>
                        <?php echo $_smarty_tpl->tpl_vars['arrRegistros1']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros1']->value['index'] : null)]['item'];?>

                    </td>
                    <td class='grilla-tab-fila-campo' align='left'>
                        <?php echo $_smarty_tpl->tpl_vars['arrRegistros1']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros1']->value['index'] : null)]['FechaInasistencia'];?>

                    </td>
                    <td class='grilla-tab-fila-campo' align='left'>
                        <?php echo $_smarty_tpl->tpl_vars['arrRegistros1']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros1']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros1']->value['index'] : null)]['Observacion'];?>

                    </td>
                <?php }?>
           
            </tr>
        <?php
}
}
?>
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    
        <?php
$__section_registros_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistros']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registros_1_total = $__section_registros_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registros'] = new Smarty_Variable(array());
if ($__section_registros_1_total !== 0) {
for ($__section_registros_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] = 0; $__section_registros_1_iteration <= $__section_registros_1_total; $__section_registros_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']++){
?>
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <?php if ((($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['FechaInasistencia'] == 'Inasistencias') || ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['FechaInasistencia'] == 'Atrasos'))) {?>
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        
                    </td>
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['FechaInasistencia'];?>

                    </td>
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        Observaci&oacute;n
                    </td>
                <?php } else { ?>
                    <td class='grilla-tab-fila-campo' align='left'>
                        <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['item'];?>

                    </td>
                    <td class='grilla-tab-fila-campo' align='left'>
                        <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['FechaInasistencia'];?>

                    </td>
                    <td class='grilla-tab-fila-campo' align='left'>
                        <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['Observacion'];?>

                    </td>
                <?php }?>
           
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
