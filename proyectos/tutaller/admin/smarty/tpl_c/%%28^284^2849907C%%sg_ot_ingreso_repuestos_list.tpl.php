<?php /* Smarty version 2.6.18, created on 2016-09-22 15:37:35
         compiled from sg_ot_ingreso_repuestos_list.tpl */ ?>
<div id="pivot">
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Repuesto</td>
		<td class="grilla-tab-fila-titulo" align='center'>Cantidad</td>
		<td class="grilla-tab-fila-titulo" align='center'>Precio neto</td>
		<td class="grilla-tab-fila-titulo" align='center'>Iva</td>
		<td class="grilla-tab-fila-titulo" align='center'>Total unitario</td>
		<td class="grilla-tab-fila-titulo" align='center'>Total</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
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
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cod_repuesto']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cantidad']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['precio_neto_unitario']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['iva']; ?>
</td>

			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['precio_unitario']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['total']; ?>
</td>
			<td class="grilla-tab-fila-campo">
				<a href="#" onclick="xajax_EliminarRepuesto(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['otr_ncorr']; ?>
','<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['grupo_mod']; ?>
');">
					<img src="../images/close_delete.png" title="Eliminar Repuesto" />
				</a>
			</td>
			
		</tr>
	<?php endfor; endif; ?>
</table>
</div>