<?php /* Smarty version 2.6.18, created on 2016-05-18 13:14:13
         compiled from sg_pruebas_gestion_profesores_list.tpl */ ?>
<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Listado Ingreso Notas</td>
    </tr>
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" width="20%" align="center">A&ntilde;o</td>
        <td class="grilla-tab-fila-titulo-pequenio"  width="20%" align="center"><?php echo $this->_tpl_vars['anio_busqueda']; ?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" width="20%" align="center">Periodo</td>
        <td class="grilla-tab-fila-titulo-pequenio"  width="20%" align="center"><?php echo $this->_tpl_vars['periodo_busqueda']; ?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" width="20%" align="center">Curso</td>
        <td class="grilla-tab-fila-titulo-pequenio"  width="20%" align="center"><?php echo $this->_tpl_vars['curso_busqueda']; ?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" width="20%" align="center">Nombre Asignatura</td>
        <td class="grilla-tab-fila-titulo-pequenio"  width="20%" align="center">Nombre Profesor</td>
        <?php unset($this->_sections['registrosRD']);
$this->_sections['registrosRD']['name'] = 'registrosRD';
$this->_sections['registrosRD']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistrosPrueba']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['registrosRD']['show'] = true;
$this->_sections['registrosRD']['max'] = $this->_sections['registrosRD']['loop'];
$this->_sections['registrosRD']['step'] = 1;
$this->_sections['registrosRD']['start'] = $this->_sections['registrosRD']['step'] > 0 ? 0 : $this->_sections['registrosRD']['loop']-1;
if ($this->_sections['registrosRD']['show']) {
    $this->_sections['registrosRD']['total'] = $this->_sections['registrosRD']['loop'];
    if ($this->_sections['registrosRD']['total'] == 0)
        $this->_sections['registrosRD']['show'] = false;
} else
    $this->_sections['registrosRD']['total'] = 0;
if ($this->_sections['registrosRD']['show']):

            for ($this->_sections['registrosRD']['index'] = $this->_sections['registrosRD']['start'], $this->_sections['registrosRD']['iteration'] = 1;
                 $this->_sections['registrosRD']['iteration'] <= $this->_sections['registrosRD']['total'];
                 $this->_sections['registrosRD']['index'] += $this->_sections['registrosRD']['step'], $this->_sections['registrosRD']['iteration']++):
$this->_sections['registrosRD']['rownum'] = $this->_sections['registrosRD']['iteration'];
$this->_sections['registrosRD']['index_prev'] = $this->_sections['registrosRD']['index'] - $this->_sections['registrosRD']['step'];
$this->_sections['registrosRD']['index_next'] = $this->_sections['registrosRD']['index'] + $this->_sections['registrosRD']['step'];
$this->_sections['registrosRD']['first']      = ($this->_sections['registrosRD']['iteration'] == 1);
$this->_sections['registrosRD']['last']       = ($this->_sections['registrosRD']['iteration'] == $this->_sections['registrosRD']['total']);
?>
       	<td class="grilla-tab-fila-titulo-pequenio" align="center">
				<a href="#" onclick="cambiar('<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRD']['index']]['NumeroNota']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRD']['index']]['CodigoCurso']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRD']['index']]['CodigoRamo']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRD']['index']]['AnoAcademico']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRD']['index']]['Semestre']; ?>
_<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRD']['index']]['Prueba']; ?>
')">N-<?php echo $this->_tpl_vars['arrRegistrosPrueba'][$this->_sections['registrosRD']['index']]['NumeroNota']; ?>
</a>
        </td>
        <?php endfor; endif; ?>
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
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre_asignatura']; ?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre_alumno']; ?>

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
            	<?php if (( ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['prueba_ncorr'] == $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['prueba_ncorr'] ) && ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['curso'] == $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['curso'] ) && ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['asignatura'] == $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['asignatura'] ) )): ?>
                    <?php if ($this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['cant_dias'] == 'NO'): ?>
                    <td class='grilla-tab-fila-campo-pequenio' align='center'><!--Rojo-->
                        <img src="../images/cara_roja.jpg" title="<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['FechaPrueba']; ?>
-<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['DescripcionPrueba']; ?>
-<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['CoeficientePrueba']; ?>
"/>
                    </td>
                    <?php else: ?>
                        <td class='grilla-tab-fila-campo-pequenio' align='center' >
                            <a href="#" onclick="xajax_CargaVentana(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['curso']; ?>
',
                                                '<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['asignatura']; ?>
','<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['NumeroNota']; ?>
',
                                                '<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['Semestre']; ?>
','<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['AnoAcademico']; ?>
');">
                                <img src="../images/cara_verde.jpg" title="<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['FechaPrueba']; ?>
-<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['DescripcionPrueba']; ?>
-<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['CoeficientePrueba']; ?>
"/>
                            </a>
                        </td>
                        <!--
                        <?php if ($this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['cant_dias'] < 10): ?>
                           
                        <?php else: ?>
                            <td class='grilla-tab-fila-campo-pequenio' align='center' >
                                <img src="../images/cara_amarilla.jpg"/>
                            </td>
                        <?php endif; ?>	
                        -->
                	<?php endif; ?>
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