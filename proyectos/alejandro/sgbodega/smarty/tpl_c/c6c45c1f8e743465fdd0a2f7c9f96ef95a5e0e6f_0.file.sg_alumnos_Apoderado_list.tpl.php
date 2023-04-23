<?php
/* Smarty version 3.1.33, created on 2018-12-11 20:41:00
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/test/sige/smarty/tpl/sg_alumnos_Apoderado_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c104b0c0ae321_50012944',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c6c45c1f8e743465fdd0a2f7c9f96ef95a5e0e6f' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/test/sige/smarty/tpl/sg_alumnos_Apoderado_list.tpl',
      1 => 1503529482,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c104b0c0ae321_50012944 (Smarty_Internal_Template $_smarty_tpl) {
?><div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
    	<td class="grilla-tab-fila-titulo" align="left">Alumno</td>
    	<td class="grilla-tab-fila-titulo" colspan="5" align="left" style="font-weight: bold"><?php echo $_smarty_tpl->tpl_vars['nombre_alumno']->value;?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align="left">Curso</td>
        <td class="grilla-tab-fila-titulo" colspan="5" align="left" style="font-weight: bold"><?php echo $_smarty_tpl->tpl_vars['nombre_curso']->value;?>
</td>
    </tr>
    <tr >
            <td class='grilla-tab-fila-campo' align='center'>
                Nombre Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Tipo Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Direccion Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Tel&eacute;fono Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                M&oacute;vil Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Correo Apoderado
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
                <a href="#" style="cursor: hand;" onclick="xajax_TraerApoderado(xajax.getFormValues('Form1'), '<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['RutApoderado'];?>
', '<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['RutAlumno'];?>
');" ><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nombre_apoderado'];?>
</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" style="cursor: hand;" onclick="xajax_TraerApoderado(xajax.getFormValues('Form1'), '<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['RutApoderado'];?>
', '<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['RutAlumno'];?>
');" ><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['tipo_apoderado'];?>
</a>

                
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" style="cursor: hand;" onclick="xajax_TraerApoderado(xajax.getFormValues('Form1'), '<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['RutApoderado'];?>
', '<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['RutAlumno'];?>
');" ><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['direcc_apoderado'];?>
</a>
                
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" style="cursor: hand;" onclick="xajax_TraerApoderado(xajax.getFormValues('Form1'), '<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['RutApoderado'];?>
', '<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['RutAlumno'];?>
');" ><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['telefono_apoderado'];?>
</a>
                
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" style="cursor: hand;" onclick="xajax_TraerApoderado(xajax.getFormValues('Form1'), '<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['RutApoderado'];?>
', '<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['RutAlumno'];?>
');" ><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['movil_apoderado'];?>
</a>
                
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="mailto:<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['correo_apoderado'];?>
"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['correo_apoderado'];?>
</a>
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
