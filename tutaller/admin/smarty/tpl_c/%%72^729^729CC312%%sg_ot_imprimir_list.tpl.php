<?php /* Smarty version 2.6.18, created on 2016-09-23 10:27:35
         compiled from sg_ot_imprimir_list.tpl */ ?>
<div id="pivot">
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Nro OT</td>
		<td class="grilla-tab-fila-titulo" align='center'><?php echo $this->_tpl_vars['ot_ncorr']; ?>
</td>
	</tr>
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
		<td class="grilla-tab-fila-titulo" align='center'><?php echo $this->_tpl_vars['fecha']; ?>
</td>
	</tr>
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Folio</td>
		<td class="grilla-tab-fila-titulo" align='center'><?php echo $this->_tpl_vars['folio']; ?>
</td>
	</tr>
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Mecanico</td>
		<td class="grilla-tab-fila-titulo" align='center'><?php echo $this->_tpl_vars['nombre_mecanico']; ?>
</td>
	</tr>
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Patente</td>
		<td class="grilla-tab-fila-titulo" align='center'><?php echo $this->_tpl_vars['patente']; ?>
</td>
	</tr>
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Trabajador</td>
		<td class="grilla-tab-fila-titulo" align='center'><?php echo $this->_tpl_vars['nombre_trabajador']; ?>
</td>
	</tr>
	</table>
	<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
		<td class="grilla-tab-fila-titulo" align='center' colspan="6">Mano de Obra</td>
		</tr>
		<tr>
			<td class="grilla-tab-fila-titulo" align='center'>Detalle</td>
			<td class="grilla-tab-fila-titulo" align='center'>Cantidad</td>
			<td class="grilla-tab-fila-titulo" align='center'>Precio neto</td>
			<td class="grilla-tab-fila-titulo" align='center'>Iva</td>
			<td class="grilla-tab-fila-titulo" align='center'>Total unitario</td>
			<td class="grilla-tab-fila-titulo" align='center'>Total</td>
		</tr>
	<?php unset($this->_sections['registros_mo']);
$this->_sections['registros_mo']['name'] = 'registros_mo';
$this->_sections['registros_mo']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros_MO']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['registros_mo']['show'] = true;
$this->_sections['registros_mo']['max'] = $this->_sections['registros_mo']['loop'];
$this->_sections['registros_mo']['step'] = 1;
$this->_sections['registros_mo']['start'] = $this->_sections['registros_mo']['step'] > 0 ? 0 : $this->_sections['registros_mo']['loop']-1;
if ($this->_sections['registros_mo']['show']) {
    $this->_sections['registros_mo']['total'] = $this->_sections['registros_mo']['loop'];
    if ($this->_sections['registros_mo']['total'] == 0)
        $this->_sections['registros_mo']['show'] = false;
} else
    $this->_sections['registros_mo']['total'] = 0;
if ($this->_sections['registros_mo']['show']):

            for ($this->_sections['registros_mo']['index'] = $this->_sections['registros_mo']['start'], $this->_sections['registros_mo']['iteration'] = 1;
                 $this->_sections['registros_mo']['iteration'] <= $this->_sections['registros_mo']['total'];
                 $this->_sections['registros_mo']['index'] += $this->_sections['registros_mo']['step'], $this->_sections['registros_mo']['iteration']++):
$this->_sections['registros_mo']['rownum'] = $this->_sections['registros_mo']['iteration'];
$this->_sections['registros_mo']['index_prev'] = $this->_sections['registros_mo']['index'] - $this->_sections['registros_mo']['step'];
$this->_sections['registros_mo']['index_next'] = $this->_sections['registros_mo']['index'] + $this->_sections['registros_mo']['step'];
$this->_sections['registros_mo']['first']      = ($this->_sections['registros_mo']['iteration'] == 1);
$this->_sections['registros_mo']['last']       = ($this->_sections['registros_mo']['iteration'] == $this->_sections['registros_mo']['total']);
?>
		<tr >
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros_MO'][$this->_sections['registros_mo']['index']]['detalle']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros_MO'][$this->_sections['registros_mo']['index']]['cantidad']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros_MO'][$this->_sections['registros_mo']['index']]['precio_neto']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros_MO'][$this->_sections['registros_mo']['index']]['iva']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros_MO'][$this->_sections['registros_mo']['index']]['total_unitario']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros_MO'][$this->_sections['registros_mo']['index']]['total']; ?>
</td>
		</tr>
	<?php endfor; endif; ?>
		<tr>
			<td class="grilla-tab-fila-titulo" align='center' colspan="6">Repuestos</td>
		</tr>
		<tr>
			<td class="grilla-tab-fila-titulo" align='center'>Detalle</td>
			<td class="grilla-tab-fila-titulo" align='center'>Cantidad</td>
			<td class="grilla-tab-fila-titulo" align='center'>Precio neto</td>
			<td class="grilla-tab-fila-titulo" align='center'>Iva</td>
			<td class="grilla-tab-fila-titulo" align='center'>Total unitario</td>
			<td class="grilla-tab-fila-titulo" align='center'>Total</td>
		</tr>
	<?php unset($this->_sections['registros_rep']);
$this->_sections['registros_rep']['name'] = 'registros_rep';
$this->_sections['registros_rep']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros_REP']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['registros_rep']['show'] = true;
$this->_sections['registros_rep']['max'] = $this->_sections['registros_rep']['loop'];
$this->_sections['registros_rep']['step'] = 1;
$this->_sections['registros_rep']['start'] = $this->_sections['registros_rep']['step'] > 0 ? 0 : $this->_sections['registros_rep']['loop']-1;
if ($this->_sections['registros_rep']['show']) {
    $this->_sections['registros_rep']['total'] = $this->_sections['registros_rep']['loop'];
    if ($this->_sections['registros_rep']['total'] == 0)
        $this->_sections['registros_rep']['show'] = false;
} else
    $this->_sections['registros_rep']['total'] = 0;
if ($this->_sections['registros_rep']['show']):

            for ($this->_sections['registros_rep']['index'] = $this->_sections['registros_rep']['start'], $this->_sections['registros_rep']['iteration'] = 1;
                 $this->_sections['registros_rep']['iteration'] <= $this->_sections['registros_rep']['total'];
                 $this->_sections['registros_rep']['index'] += $this->_sections['registros_rep']['step'], $this->_sections['registros_rep']['iteration']++):
$this->_sections['registros_rep']['rownum'] = $this->_sections['registros_rep']['iteration'];
$this->_sections['registros_rep']['index_prev'] = $this->_sections['registros_rep']['index'] - $this->_sections['registros_rep']['step'];
$this->_sections['registros_rep']['index_next'] = $this->_sections['registros_rep']['index'] + $this->_sections['registros_rep']['step'];
$this->_sections['registros_rep']['first']      = ($this->_sections['registros_rep']['iteration'] == 1);
$this->_sections['registros_rep']['last']       = ($this->_sections['registros_rep']['iteration'] == $this->_sections['registros_rep']['total']);
?>
		<tr >
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros_REP'][$this->_sections['registros_rep']['index']]['cod_repuesto']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros_REP'][$this->_sections['registros_rep']['index']]['cantidad']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros_REP'][$this->_sections['registros_rep']['index']]['precio_neto_unitario']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros_REP'][$this->_sections['registros_rep']['index']]['iva']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros_REP'][$this->_sections['registros_rep']['index']]['precio_unitario']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros_REP'][$this->_sections['registros_rep']['index']]['total']; ?>
</td>
		</tr>
	<?php endfor; endif; ?>
	</table>
	<table align="right"  class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">>
		<tr>
			<td>
				<table align="right">
					<tr>
						<td class="grilla-tab-fila-titulo" >
							
						</td>
						<td class="grilla-tab-fila-titulo" >
							Neto	
						</td>
						<td class="grilla-tab-fila-titulo" >
							Iva
						</td>
						<td class="grilla-tab-fila-titulo" >
							Total
						</td>
					</tr>
					<tr>
						<td class="grilla-tab-fila-titulo" >
							Total Mano de Obra
						</td>
						<td class="grilla-tab-fila-campo" id="neto_mo_final" name="neto_mo_final">
						
						</td>
						<td class="grilla-tab-fila-campo" id="iva_mo_final" name="iva_mo_final">
						
						</td>
						<td class="grilla-tab-fila-campo" id="total_mo_final" name="total_mo_final">
						
						</td>
					</tr>
					<tr>
						<td class="grilla-tab-fila-titulo" >
							Total Repuestos
						</td>
						<td class="grilla-tab-fila-campo" id="neto_rep_final" name="neto_rep_final">
							
						</td>
						<td class="grilla-tab-fila-campo" id="iva_rep_final" name="iva_rep_final">
							
						</td>
						<td class="grilla-tab-fila-campo" id="total_rep_final" name="total_rep_final">
							
						</td>
					</tr>
					<tr>
						<td class="grilla-tab-fila-titulo" >
							Total
						</td>
						<td class="grilla-tab-fila-campo" id="neto_final" name="neto_final">
							
						</td>
						<td class="grilla-tab-fila-campo" id="iva_final" name="iva_final">
							
						</td>
						<td class="grilla-tab-fila-campo" id="total_final" name="total_final">
							
						</td>
					</tr>
				</table>
			</td>
		</tr>
	<tr>
		<td colspan='9' class="grilla-tab-fila-titulo">
			<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
		</td>
	</tr>
</table>
</div>