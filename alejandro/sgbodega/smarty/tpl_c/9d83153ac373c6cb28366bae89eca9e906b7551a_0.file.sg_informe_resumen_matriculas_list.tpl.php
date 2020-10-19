<?php
/* Smarty version 3.1.33, created on 2018-12-09 20:03:43
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/test/sige/smarty/tpl/sg_informe_resumen_matriculas_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c0d9f4fe52e37_64593267',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9d83153ac373c6cb28366bae89eca9e906b7551a' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/test/sige/smarty/tpl/sg_informe_resumen_matriculas_list.tpl',
      1 => 1522798644,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c0d9f4fe52e37_64593267 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important; font-weight: bold" colspan="6">INFORME RESUMEN CONTRATOS DE MATRICULAS</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important">Nombre Curso</td>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important">Capacidad</td>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important">Alumnos Antiguos</td>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important">Alumnos Nuevos</td>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important">Cantidad de Alumnos</td>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important">Vacantes</td>
    </tr>
</table>
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%" style="overflow: scroll; height: 600px !important;">

    <?php
$__section_registros_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistros']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registros_0_total = $__section_registros_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registros'] = new Smarty_Variable(array());
if ($__section_registros_0_total !== 0) {
for ($__section_registros_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] = 0; $__section_registros_0_iteration <= $__section_registros_0_total; $__section_registros_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']++){
?>
            <tr <?php if (($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Totales Matricula Antiguos') || ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Totales Matricula Nuevos') || ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Total General')) {?> 
                    style="background-color: #1B4978 !important;"
                <?php } else { ?> 
                    onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'
                <?php }?>>
                <td class="grilla-tab-fila-campo" align='left' style="width: 10% !important;
                     <?php if (($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Totales Matricula Antiguos') || ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Totales Matricula Nuevos') || ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Total General')) {?> 
                     color: white;
                     <?php }?>
                "><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'];?>
</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 10% !important;
                     <?php if (($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Totales Matricula Antiguos') || ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Totales Matricula Nuevos') || ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Total General')) {?> 
                     color: white;
                     <?php }?>
                "><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['Capacidad'];?>
</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 10% !important;
                    <?php if (($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Totales Matricula Antiguos') || ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Totales Matricula Nuevos') || ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Total General')) {?> 
                     color: white;
                     <?php }?>"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['anio_actual'];?>
</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 10% !important;
                    <?php if (($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Totales Matricula Antiguos') || ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Totales Matricula Nuevos') || ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Total General')) {?> 
                     color: white;
                    <?php }?>"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['anio_siguiente'];?>
</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 10% !important;
                    <?php if (($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Totales Matricula Antiguos') || ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Totales Matricula Nuevos') || ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Total General')) {?> 
                     color: white;
                    <?php }?>"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['cantidad_alumnos'];?>
</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 10% !important;
                    <?php if (($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Totales Matricula Antiguos') || ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Totales Matricula Nuevos') || ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'] == 'Total General')) {?> 
                     color: white;
                    <?php }?>"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['disponible'];?>
</td>
            </tr>
    <?php
}
}
?>
<tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
             <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divresultado');" width="32"></a>
    
        </td>
    </tr>
</table>
</div>
<?php }
}
