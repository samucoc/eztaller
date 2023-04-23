<?php /* Smarty version 2.6.18, created on 2016-09-23 11:30:23
         compiled from sg_ot_informe_trabajador_list.tpl */ ?>
<div id="pivot">
	<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<td class="grilla-tab-fila-titulo" align='center'>Nro OT</td>
			<td class="grilla-tab-fila-titulo" align='center'>Folio</td>
			<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
			<td class="grilla-tab-fila-titulo" align='center'>Mecanico</td>
			<td class="grilla-tab-fila-titulo" align='center'>Patente</td>
			<td class="grilla-tab-fila-titulo" align='center'>Trabajador</td>
			<td class="grilla-tab-fila-titulo" align='center'>Ver detalle</td>
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

		<tr >
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ot_ncorr']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['folio']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['mecanico']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_trabajador']; ?>
</td>
			<td class="grilla-tab-fila-campo"><input type="button"  name="btnDetalle" id="btnDetalle" class="boton" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ot_ncorr']; ?>
');" value="Ver Detalle"></td>
		</tr>
	<?php endfor; endif; ?>
	<tr>
		<td colspan='9' class="grilla-tab-fila-titulo">
			<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
		</td>
	</tr>
</table>
</div>