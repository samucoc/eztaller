<?php /* Smarty version 2.6.18, created on 2018-06-13 09:01:23
         compiled from sg_informes_resumen_inasistencias_list.tpl */ ?>
<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='center'>
			Curso
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Mar
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Abr
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			May
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Jun
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Jul
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Ago
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Sep
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Oct
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Nov
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center' >
			Dic
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center'>
			Total
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
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre_curso']; ?>

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
        	<?php if ($this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['curso'] == $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['curso']): ?>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['marzo']; ?>

                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['abril']; ?>

                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['mayo']; ?>

                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['junio']; ?>

                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['julio']; ?>

                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['agosto']; ?>

                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['septiembre']; ?>

                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['octubre']; ?>

                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['noviembre']; ?>

                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['diciembre']; ?>

                </td>
            	<td class='grilla-tab-fila-campo-pequenio' align='center' >
            		<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['total']; ?>

                </td>
            <?php endif; ?>
        <?php endfor; endif; ?>
	</tr>
<?php endfor; endif; ?>
<tr>
	<td colspan="<?php echo $this->_tpl_vars['cant_dias']+3; ?>
" class="grilla-tab-fila-titulo">
      <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
     	<a href="#" style="cursor: hand;" onclick="showPopWin('sg_informe_visualizador_resumen_inasistencias.php?anio=<?php echo $this->_tpl_vars['anio']; ?>
', 'Grafico Resumen Inasistencias Colegio', 1440, 650, null);" class="btn btn-primary text-center align-middle" title="Grafico Resumen Inasistencias Colegio">
        <i class="fa fa-bar-chart fa-2x" aria-hidden="true"></i>
      </a>
    	<?php if ($this->_tpl_vars['curso'] != ''): ?>
    	<a href="#" style="cursor: hand;" onclick="showPopWin('sg_informe_visualizador_curso_resumen_inasistencias.php?anio=<?php echo $this->_tpl_vars['anio']; ?>
&curso=<?php echo $this->_tpl_vars['curso']; ?>
', 'Grafico Resumen Inasistencias Curso', 750, 650, null);" class="btn btn-primary text-center align-middle " title="Grafico Resumen Inasistencias Curso">
        <i class="fa fa-bar-chart fa-2x" aria-hidden="true"></i>
      </a>
    	<?php endif; ?>
    </td>
</tr>
</table>