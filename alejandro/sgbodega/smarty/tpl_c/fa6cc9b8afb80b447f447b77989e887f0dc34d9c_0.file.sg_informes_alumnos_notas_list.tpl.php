<?php
/* Smarty version 3.1.33, created on 2018-12-12 21:14:44
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/test/sige/smarty/tpl/sg_informes_alumnos_notas_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c11a474e849f9_37242713',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fa6cc9b8afb80b447f447b77989e887f0dc34d9c' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/test/sige/smarty/tpl/sg_informes_alumnos_notas_list.tpl',
      1 => 1510690274,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c11a474e849f9_37242713 (Smarty_Internal_Template $_smarty_tpl) {
?><div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-titulo' align='left'>
                Nro Matricula
            </td>
            <td class='grilla-tab-fila-titulo' align='left'>
                Nro Lista
            </td>
            <td class='grilla-tab-fila-titulo' align='left'>
                Alumno
            </td>
            <td class='grilla-tab-fila-titulo' align='left'>
                Acciones
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
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NroMatricula'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NroLista'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nombre_alumno'];?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <a href="#" target="_self">
                    <img src="../images/basicos/imprimir.png" border=0 title="Imprimir Informe" 
                        onclick="xajax_ImprimePDF(xajax.getFormValues('Form1'),'<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['rut_alumno'];?>
','<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['semestre'];?>
');"
                        width="32">
                </a>
                
            </td>
                
        </tr>
    <?php
}
}
?>
    </table>

    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
            <td colspan='16' class="grilla-tab-fila-titulo">
                <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir Todo el Curso" onclick="xajax_ImprimePDFCurso(xajax.getFormValues('Form1'));" width="32"></a>
                <!--
                <a href="#" style="cursor: hand;"><img src="../images/basicos/email2.png" border=0 title="Enviar Todo el Curso" onclick="xajax_EnviarPDFCurso(xajax.getFormValues('Form1'));" width="32"></a>
                -->
            </td>
	    </tr>
    </table>
</div>
                
<?php }
}
