<?php
/* Smarty version 3.1.33, created on 2019-01-08 16:30:34
  from '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/test/sige/smarty/tpl/sg_notas_ingresar_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c34fa5a2e7cd7_36200687',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e95755879d0c93c48d654c928ef266a3f18cf616' => 
    array (
      0 => '/home/dominios/gescol.cl/web/80/www.gescol.cl/public_html/test/sige/smarty/tpl/sg_notas_ingresar_list.tpl',
      1 => 1542759111,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c34fa5a2e7cd7_36200687 (Smarty_Internal_Template $_smarty_tpl) {
?><div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">A&ntilde;o</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_anio" colspan="<?php echo $_smarty_tpl->tpl_vars['notas_ingresadas']->value+2;?>
"></td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Semestre</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_semestre" colspan="<?php echo $_smarty_tpl->tpl_vars['notas_ingresadas']->value+2;?>
"></td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Curso</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_curso" colspan="<?php echo $_smarty_tpl->tpl_vars['notas_ingresadas']->value+2;?>
"></td>
    </tr>
    <tr> 
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Asignatura</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_asignatura" colspan="<?php echo $_smarty_tpl->tpl_vars['notas_ingresadas']->value+2;?>
"></td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nro Lista</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nombre Alumno</td>
        <?php
$__section_registrosRP_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registrosRP_0_total = $__section_registrosRP_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registrosRP'] = new Smarty_Variable(array());
if ($__section_registrosRP_0_total !== 0) {
for ($__section_registrosRP_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] = 0; $__section_registrosRP_0_iteration <= $__section_registrosRP_0_total; $__section_registrosRP_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']++){
?>
		   	<td class="grilla-tab-fila-titulo-pequenio" align="center">
				<?php if ($_smarty_tpl->tpl_vars['situacion_final']->value == 1) {?>
                    <a href="#" title="<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['DescripcionPrueba'];?>
">
                        N-<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['NumeroNota'];?>

                    </a>
                    <div id="div_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['NumeroNota'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['CodigoCurso'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['CodigoRamo'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['AnoAcademico'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['Semestre'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['Prueba'];?>
" style="display:none">
                        <a id="mo_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['NumeroNota'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['CodigoCurso'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['CodigoRamo'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['AnoAcademico'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['Semestre'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['Prueba'];?>
" href="#">Editar</a>
                        <a id="el_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['NumeroNota'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['CodigoCurso'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['CodigoRamo'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['AnoAcademico'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['Semestre'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['Prueba'];?>
" href="#">Eliminar</a>
                    </div>
                <?php } else { ?>
                    <a onclick="cambiar('<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['NumeroNota'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['CodigoCurso'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['CodigoRamo'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['AnoAcademico'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['Semestre'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['Prueba'];?>
')" href="#" title="<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['DescripcionPrueba'];?>
">
    					N-<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['NumeroNota'];?>

    				</a>
    				<div id="div_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['NumeroNota'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['CodigoCurso'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['CodigoRamo'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['AnoAcademico'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['Semestre'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['Prueba'];?>
" style="display:none">
    					<a id="mo_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['NumeroNota'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['CodigoCurso'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['CodigoRamo'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['AnoAcademico'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['Semestre'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['Prueba'];?>
" onclick="xajax_ModificarNotaCM(xajax.getFormValues('Form1'),'<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['NumeroNota'];?>
','<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['CodigoCurso'];?>
','<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['CodigoRamo'];?>
','<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['AnoAcademico'];?>
','<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['Semestre'];?>
','<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['Prueba'];?>
')" href="#">Editar</a>
    					<a id="el_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['NumeroNota'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['CodigoCurso'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['CodigoRamo'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['AnoAcademico'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['Semestre'];?>
_<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['Prueba'];?>
" onclick="xajax_EliminarNota(xajax.getFormValues('Form1'),'<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['NumeroNota'];?>
','<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['CodigoCurso'];?>
','<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['CodigoRamo'];?>
','<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['AnoAcademico'];?>
','<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['Semestre'];?>
','<?php echo $_smarty_tpl->tpl_vars['arrRegistrosPrueba']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosRP']->value['index'] : null)]['Prueba'];?>
')" href="#">Eliminar</a>
    				</div>
                <?php }?>
            </td>
        <?php
}
}
?>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">
				Promedio
        </td> 
    </tr>
    <?php
$__section_registros_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistros']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registros_1_total = $__section_registros_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registros'] = new Smarty_Variable(array());
if ($__section_registros_1_total !== 0) {
for ($__section_registros_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] = 0; $__section_registros_1_iteration <= $__section_registros_1_total; $__section_registros_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']++){
?>
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class="grilla-tab-fila-campo-pequenio" align="center"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nro_lista_alumno'];?>
</td>
     		<td class="grilla-tab-fila-campo-pequenio" align="left"><?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['nombre_alumno'];?>
</td>
        
			<?php
$__section_registrosDetalle_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_registrosDetalle_2_total = $__section_registrosDetalle_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle'] = new Smarty_Variable(array());
if ($__section_registrosDetalle_2_total !== 0) {
for ($__section_registrosDetalle_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] = 0; $__section_registrosDetalle_2_iteration <= $__section_registrosDetalle_2_total; $__section_registrosDetalle_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']++){
?>
                <?php if ($_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['rut_alumno'] == $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['rut_alumno']) {?>
            			<td class='grilla-tab-fila-campo-pequenio' align='center' onclick="xajax_ModificarNota(xajax.getFormValues('Form1'),
                											'<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['rut_alumno'];?>
',
                											'<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['asignatura'];?>
',
                											'<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['anio'];?>
',
                											'<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['curso'];?>
',
                											'<?php echo $_smarty_tpl->tpl_vars['arrRegistros']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registros']->value['index'] : null)]['semestre'];?>
',
                											'<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['prueba'];?>
',
                											'<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['nro_nota'];?>
',
                											'<?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['nota'];?>
')">
                											<!-- $asignatura,$anio,$curso,$semestre,$prueba,$nro_nota,$nota -->
                        	<?php if ($_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['nota'] == '') {?>
                            <div style="color:#FF0000">                
                                --
                            </div>
                            <?php } else { ?>
                                <?php if ($_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['nota'] < 4) {?>
                                <div style="color:#FF0000">                
                                    <?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['nota'];?>

                                </div>
                                <?php } else { ?>
                                    <?php echo $_smarty_tpl->tpl_vars['arrRegistrosDetalle']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_registrosDetalle']->value['index'] : null)]['nota'];?>

                                <?php }?>
                            <?php }?>
                        </td>
                <?php }?>
            <?php
}
}
?>
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
