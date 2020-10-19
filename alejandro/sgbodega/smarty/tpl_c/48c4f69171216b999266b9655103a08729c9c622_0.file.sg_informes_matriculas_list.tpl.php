<?php
/* Smarty version 3.1.33, created on 2019-07-29 16:44:30
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_informes_matriculas_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d3f5aaeabd1e1_04468468',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '48c4f69171216b999266b9655103a08729c9c622' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/nmva/sgadministrativo/smarty/tpl/sg_informes_matriculas_list.tpl',
      1 => 1563312324,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d3f5aaeabd1e1_04468468 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo" colspan="16" align='left' style="font-size: 8px !important; border: 0px"><?php echo $_smarty_tpl->tpl_vars['nombre']->value;?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" colspan="16" align='left' style="font-size: 8px !important; border: 0px"><?php echo $_smarty_tpl->tpl_vars['rut']->value;?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" colspan="16" align='left' style="font-size: 8px !important; border: 0px"><?php echo $_smarty_tpl->tpl_vars['direccion']->value;?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" colspan="16" align='left' style="font-size: 8px !important; border: 0px"><?php echo $_smarty_tpl->tpl_vars['ciudad']->value;?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" colspan="16" align='center' style="font-size: 8px !important; border: 0px">REGISTRO MATRICULA DE ALUMNOS PERIODO <?php echo $_smarty_tpl->tpl_vars['anio']->value;?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Numero de Matricula</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">R.U.N.</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Identificacion del alumno</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Sexo</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Fecha de Nacimiento</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important; width:5%" >Curso</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Local Escolar</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Fecha de matricula</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Domicilio del alumno</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Nombre de los Padres y/o Apoderados</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Telefono Apoderado</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Fecha Retiro</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Motivo Retiro - Observacion</td>
    </tr>
    <?php
$__section_registros_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistros']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registros_0_total = $__section_registros_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registros'] = new Smarty_Variable(array());
if ($__section_registros_0_total !== 0) {
for ($__section_registros_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] = 0; $__section_registros_0_iteration <= $__section_registros_0_total; $__section_registros_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']++){
?>
            <tr> 
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important; width:5%"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NroMatricula'];?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important; width:5%"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NumeroRutAlumno'];?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['alumno'];?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['SexoAlumno'];?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['FechaNacimiento'];?>
</td>
                <td class="grilla-tab-fila-campo" align='center' style="font-size: 8px !important"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['NombreCurso'];?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important">Principal</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['Fecha'];?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['DireccionParticularAlumno'];?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['apoderado'];?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['TelefonoParticularApoderado'];?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important">
                    <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['FechaRetiro'] == '00/00/0000') {?>
                    <?php } else { ?>
                        <?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['FechaRetiro'];?>

                    <?php }?>
                </td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['MotivoRetiro'];?>
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
