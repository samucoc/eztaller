<?php /* Smarty version 2.6.18, created on 2018-11-20 21:11:52
         compiled from sg_notas_ingresar_list.tpl */ ?>
<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">A&ntilde;o</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_anio" colspan="<?php echo $this->_tpl_vars['notas_ingresadas']+2; ?>
"></td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Semestre</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_semestre" colspan="<?php echo $this->_tpl_vars['notas_ingresadas']+2; ?>
"></td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Curso</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_curso" colspan="<?php echo $this->_tpl_vars['notas_ingresadas']+2; ?>
"></td>
    </tr>
    <tr> 
        <td class="grilla-tab-fila-titulo-pequenio" align="left">Asignatura</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" id="txt_asignatura" colspan="<?php echo $this->_tpl_vars['notas_ingresadas']+2; ?>
"></td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nro Lista</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nombre Alumno</td>
        <?php unset($this->_sections['registrosRP']);
$this->_sections['registrosRP']['name'] = 'registrosRP';
$this->_sections['registrosRP']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistrosPrueba']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['registrosRP']['show'] = true;
$this->_sections['registrosRP']['max'] = $this->_sections['registrosRP']['loop'];
$this->_sections['registrosRP']['step'] = 1;
$this->_sections['registrosRP']['start'] = $this->_sections['registrosRP']['step'] > 0 ? 0 : $this->_sections['registrosRP']['loop']-1;
if ($this->_sections['registrosRP']['show']) {
    $this->_sections['registrosRP']['total'] = $this->_sections['registrosRP']['loop'];
    if ($this->_sections['registrosRP']['total'] == 0)
        $this->_sections['registrosRP']['show'] = false;
} else
    $this->_sections['registrosRP']['total'] = 0;
if ($this->_sections['registrosRP']['show']):

            for ($this->_sections['registrosRP']['index'] = $this->_sections['registrosRP']['start'], $this->_sections['registrosRP']['iteration'] = 1;
                 $this->_sections['registrosRP']['iteration'] <= $this->_sections['registrosRP']['total'];
                 $this->_sections['registrosRP']['index'] += $this->_sections['registrosRP']['step'], $this->_sections['registrosRP']['iteration']++):
$this->_sections['registrosRP']['rownum'] = $this->_sections['registrosRP']['iteration'];
$this->_sections['registrosRP']['index_prev'] = $this->_sections['registrosRP']['index'] - $this->_sections['registrosRP']['step'];
$this->_sections['registrosRP']['index_next'] = $this->_sections['registrosRP']['index'] + $this->_sections['registrosRP']['step'];
$this->_sections['registrosRP']['first']      = ($this->_sections['registrosRP']['iteration'] == 1);
$this->_sections['registrosRP']['last']       = ($this->_sections['registrosRP']['iteration'] == $this->_sections['registrosRP']['total']);
?>
		   	<td class="grilla-tab-fila-titulo-pequenio" align="center">
				<?php if ($this->_tpl_vars['situacion_final'] == 1): ?>
                    <a href="#" title="<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['DescripcionPrueba']; ?>
">
                        N-<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['NumeroNota']; ?>

                    </a>
                    <div id="div_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['NumeroNota']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['CodigoCurso']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['CodigoRamo']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['AnoAcademico']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['Semestre']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['Prueba']; ?>
" style="display:none">
                        <a id="mo_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['NumeroNota']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['CodigoCurso']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['CodigoRamo']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['AnoAcademico']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['Semestre']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['Prueba']; ?>
" href="#">Editar</a>
                        <a id="el_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['NumeroNota']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['CodigoCurso']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['CodigoRamo']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['AnoAcademico']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['Semestre']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['Prueba']; ?>
" href="#">Eliminar</a>
                    </div>
                <?php else: ?>
                    <a onclick="cambiar('<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['NumeroNota']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['CodigoCurso']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['CodigoRamo']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['AnoAcademico']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['Semestre']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['Prueba']; ?>
')" href="#" title="<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['DescripcionPrueba']; ?>
">
    					N-<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['NumeroNota']; ?>

    				</a>
    				<div id="div_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['NumeroNota']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['CodigoCurso']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['CodigoRamo']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['AnoAcademico']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['Semestre']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['Prueba']; ?>
" style="display:none">
    					<a id="mo_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['NumeroNota']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['CodigoCurso']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['CodigoRamo']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['AnoAcademico']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['Semestre']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['Prueba']; ?>
" onclick="xajax_ModificarNotaCM(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['NumeroNota']; ?>
','<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['CodigoCurso']; ?>
','<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['CodigoRamo']; ?>
','<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['AnoAcademico']; ?>
','<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['Semestre']; ?>
','<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['Prueba']; ?>
')" href="#">Editar</a>
    					<a id="el_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['NumeroNota']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['CodigoCurso']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['CodigoRamo']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['AnoAcademico']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['Semestre']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['Prueba']; ?>
" onclick="xajax_EliminarNota(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['NumeroNota']; ?>
','<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['CodigoCurso']; ?>
','<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['CodigoRamo']; ?>
','<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['AnoAcademico']; ?>
','<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['Semestre']; ?>
','<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRP']['index']]['Prueba']; ?>
')" href="#">Eliminar</a>
    				</div>
                <?php endif; ?>
            </td>
        <?php endfor; endif; ?>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">
				Promedio
        </td> 
    </tr>
    <?php unset($this->_sections['registros']);
$this->_sections['registros']['name'] = 'registros';
$this->_sections['registros']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['registros']['show'] = true;
$this->_sections['registros']['max'] = $this->_sections['registros']['loop'];
$this->_sections['registros']['step'] = 1;
$this->_sections['registros']['start'] = $this->_sections['registros']['step'] > 0 ? 0 : $this->_sections['registros']['loop']-1;
if ($this->_sections['registros']['show']) {
    $this->_sections['registros']['total'] = $this->_sections['registros']['loop'];
    if ($this->_sections['registros']['total'] == 0)
        $this->_sections['registros']['show'] = false;
} else
    $this->_sections['registros']['total'] = 0;
if ($this->_sections['registros']['show']):

            for ($this->_sections['registros']['index'] = $this->_sections['registros']['start'], $this->_sections['registros']['iteration'] = 1;
                 $this->_sections['registros']['iteration'] <= $this->_sections['registros']['total'];
                 $this->_sections['registros']['index'] += $this->_sections['registros']['step'], $this->_sections['registros']['iteration']++):
$this->_sections['registros']['rownum'] = $this->_sections['registros']['iteration'];
$this->_sections['registros']['index_prev'] = $this->_sections['registros']['index'] - $this->_sections['registros']['step'];
$this->_sections['registros']['index_next'] = $this->_sections['registros']['index'] + $this->_sections['registros']['step'];
$this->_sections['registros']['first']      = ($this->_sections['registros']['iteration'] == 1);
$this->_sections['registros']['last']       = ($this->_sections['registros']['iteration'] == $this->_sections['registros']['total']);
?>
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class="grilla-tab-fila-campo-pequenio" align="center"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_lista_alumno']; ?>
</td>
     		<td class="grilla-tab-fila-campo-pequenio" align="left"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre_alumno']; ?>
</td>
        
			<?php unset($this->_sections['registrosDetalle']);
$this->_sections['registrosDetalle']['name'] = 'registrosDetalle';
$this->_sections['registrosDetalle']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistrosDetalle']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['registrosDetalle']['show'] = true;
$this->_sections['registrosDetalle']['max'] = $this->_sections['registrosDetalle']['loop'];
$this->_sections['registrosDetalle']['step'] = 1;
$this->_sections['registrosDetalle']['start'] = $this->_sections['registrosDetalle']['step'] > 0 ? 0 : $this->_sections['registrosDetalle']['loop']-1;
if ($this->_sections['registrosDetalle']['show']) {
    $this->_sections['registrosDetalle']['total'] = $this->_sections['registrosDetalle']['loop'];
    if ($this->_sections['registrosDetalle']['total'] == 0)
        $this->_sections['registrosDetalle']['show'] = false;
} else
    $this->_sections['registrosDetalle']['total'] = 0;
if ($this->_sections['registrosDetalle']['show']):

            for ($this->_sections['registrosDetalle']['index'] = $this->_sections['registrosDetalle']['start'], $this->_sections['registrosDetalle']['iteration'] = 1;
                 $this->_sections['registrosDetalle']['iteration'] <= $this->_sections['registrosDetalle']['total'];
                 $this->_sections['registrosDetalle']['index'] += $this->_sections['registrosDetalle']['step'], $this->_sections['registrosDetalle']['iteration']++):
$this->_sections['registrosDetalle']['rownum'] = $this->_sections['registrosDetalle']['iteration'];
$this->_sections['registrosDetalle']['index_prev'] = $this->_sections['registrosDetalle']['index'] - $this->_sections['registrosDetalle']['step'];
$this->_sections['registrosDetalle']['index_next'] = $this->_sections['registrosDetalle']['index'] + $this->_sections['registrosDetalle']['step'];
$this->_sections['registrosDetalle']['first']      = ($this->_sections['registrosDetalle']['iteration'] == 1);
$this->_sections['registrosDetalle']['last']       = ($this->_sections['registrosDetalle']['iteration'] == $this->_sections['registrosDetalle']['total']);
?>
                <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno'] == $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['rut_alumno']): ?>
            			<td class='grilla-tab-fila-campo-pequenio' align='center' onclick="xajax_ModificarNota(xajax.getFormValues('Form1'),
                											'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>
',
                											'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['asignatura']; ?>
',
                											'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['anio']; ?>
',
                											'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['curso']; ?>
',
                											'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['semestre']; ?>
',
                											'<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['prueba']; ?>
',
                											'<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['nro_nota']; ?>
',
                											'<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['nota']; ?>
')">
                											<!-- $asignatura,$anio,$curso,$semestre,$prueba,$nro_nota,$nota -->
                        	<?php if ($this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['nota'] == ''): ?>
                            <div style="color:#FF0000">                
                                --
                            </div>
                            <?php else: ?>
                                <?php if ($this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['nota'] < 4): ?>
                                <div style="color:#FF0000">                
                                    <?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['nota']; ?>

                                </div>
                                <?php else: ?>
                                    <?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['nota']; ?>

                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                <?php endif; ?>
            <?php endfor; endif; ?>
        </tr>
    <?php endfor; endif; ?>
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
             <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
    
        </td>
    </tr>
    </table>
</div>