<?php /* Smarty version 2.6.18, created on 2013-08-21 13:38:03
         compiled from sg_nylor_informe_precargas_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_nylor_informe_precargas_list.tpl', 5, false),array('modifier', 'number_format', 'sg_nylor_informe_precargas_list.tpl', 60, false),)), $this); ?>
<div id="pivot">

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='14' class="grilla-tab-fila-titulo" align='center'><b>Informe de Precargas al <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</b></td>
</tr>
<tr>
	<td colspan='4' class="grilla-tab-fila-titulo" align='left'>Periodo:</td>
	<td colspan='10' class="grilla-tab-fila-campo" align='left'>Desde: <?php echo $this->_tpl_vars['DESDE']; ?>
 hasta <?php echo $this->_tpl_vars['HASTA']; ?>
</td>
</tr>
<tr>
	<td colspan='4' class="grilla-tab-fila-titulo" align='left'>Vendedor:</td>
	<td colspan='10' class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['VENDEDOR']; ?>
</td>
</tr>

	<tr>
		<td class="grilla-tab-fila-titulo" align='center'></td>
		<td class="grilla-tab-fila-titulo" align='center' style="width: 5%">Item</td>
		<td class="grilla-tab-fila-titulo" align='center' style="width: 5%">Folio</td>
		<td class="grilla-tab-fila-titulo" align='center' style="width: 5%">Sector</td>
		<td class="grilla-tab-fila-titulo" align='center' style="width: 10%">Fecha</td>
		<td colspan='5' class="grilla-tab-fila-titulo" align='center' style="width: 75%">Cliente</td>
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
		
		<?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['estado_venta'] == 'POR APROBAR' )): ?>
			<td class="grilla-tab-fila-campo">
				<a href="#" style="cursor: hand;"><img  src="../images/estados/aprobar.png" border=0 title="Venta Por Aprobar"></a>
				<br>
				APR
			</td>
		<?php endif; ?>
		
		<td class="grilla-tab-fila-campo" align='center'><b><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['item']; ?>
</b></td>
		<td class="grilla-tab-fila-campo" align='right'><b><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['folio']; ?>
</b></td>
		<td class="grilla-tab-fila-campo" align='right'><b><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['sector']; ?>
</b></td>
		<td class="grilla-tab-fila-campo" align='right'><b><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_tarjeta']; ?>
</b></td>
		<td colspan='5' class="grilla-tab-fila-campo" align='left'><b><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cliente']; ?>
</b></td>
	</tr>
	
	<!-- encabezado de los articulos -->
	<tr> 
		<td colspan='3' class="grilla-tab-fila-campo-pequenio"></td>
		<td class="grilla-tab-fila-campo-pequenio" align='center'>Código</td>
		<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='center'>Descripción</td>
		<td class="grilla-tab-fila-campo-pequenio" align='center'>Observacion</td>
		<td class="grilla-tab-fila-campo-pequenio" align='center'>Cant.</td>
		<td class="grilla-tab-fila-campo-pequenio" align='center'>Pend. Entrega</td>
		<td class="grilla-tab-fila-campo-pequenio" align='center'>Tiempo Espera</td>
		<td class="grilla-tab-fila-campo-pequenio" align='center'>N/U</td>
	</tr>
	<?php unset($this->_sections['detalle']);
$this->_sections['detalle']['name'] = 'detalle';
$this->_sections['detalle']['loop'] = is_array($_loop=$this->_tpl_vars['arrDetalle']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['detalle']['show'] = true;
$this->_sections['detalle']['max'] = $this->_sections['detalle']['loop'];
$this->_sections['detalle']['step'] = 1;
$this->_sections['detalle']['start'] = $this->_sections['detalle']['step'] > 0 ? 0 : $this->_sections['detalle']['loop']-1;
if ($this->_sections['detalle']['show']) {
    $this->_sections['detalle']['total'] = $this->_sections['detalle']['loop'];
    if ($this->_sections['detalle']['total'] == 0)
        $this->_sections['detalle']['show'] = false;
} else
    $this->_sections['detalle']['total'] = 0;
if ($this->_sections['detalle']['show']):

            for ($this->_sections['detalle']['index'] = $this->_sections['detalle']['start'], $this->_sections['detalle']['iteration'] = 1;
                 $this->_sections['detalle']['iteration'] <= $this->_sections['detalle']['total'];
                 $this->_sections['detalle']['index'] += $this->_sections['detalle']['step'], $this->_sections['detalle']['iteration']++):
$this->_sections['detalle']['rownum'] = $this->_sections['detalle']['iteration'];
$this->_sections['detalle']['index_prev'] = $this->_sections['detalle']['index'] - $this->_sections['detalle']['step'];
$this->_sections['detalle']['index_next'] = $this->_sections['detalle']['index'] + $this->_sections['detalle']['step'];
$this->_sections['detalle']['first']      = ($this->_sections['detalle']['iteration'] == 1);
$this->_sections['detalle']['last']       = ($this->_sections['detalle']['iteration'] == $this->_sections['detalle']['total']);
?>
		<?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr'] == $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['ncorr'] )): ?>
			<tr> 
				<td colspan='3' class="grilla-tab-fila-campo-pequenio"></td>
				<td class="grilla-tab-fila-campo-pequenio" align='right'><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['codigo']; ?>
</td>
				<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='left'><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['descripcion']; ?>
</td>
                <td class="grilla-tab-fila-campo-pequenio" align='right'><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['observacion']; ?>
</td>
				<td class="grilla-tab-fila-campo-pequenio" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['cantidad'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
				<td class="grilla-tab-fila-campo-pequenio" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['pend_entrega'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
				<?php if (( $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['estado'] == 'PENDIENTE' )): ?>
					<td class="grilla-tab-fila-campo-pequenio" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['tiempo_espera'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
 días</td>
				<?php endif; ?>
				<?php if (( $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['estado'] == 'ENTREGADO' )): ?>
					<td class="grilla-tab-fila-campo-pequenio" align='center'>
						<label class="requerido">
							<?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['estado']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['fecha_ult_carga'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y %H:%M:%S") : smarty_modifier_date_format($_tmp, "%d/%m/%Y %H:%M:%S")); ?>

						</label>
					</td>
				<?php endif; ?>
				
				<td class="grilla-tab-fila-campo-pequenio" align='center'><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['nu']; ?>
</td>
			</tr>
		<?php endif; ?>
	<?php endfor; endif; ?>
	
	<!--
	<tr> 
		<td colspan='12'>
			<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
				<?php unset($this->_sections['detalle']);
$this->_sections['detalle']['name'] = 'detalle';
$this->_sections['detalle']['loop'] = is_array($_loop=$this->_tpl_vars['arrDetalle']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['detalle']['show'] = true;
$this->_sections['detalle']['max'] = $this->_sections['detalle']['loop'];
$this->_sections['detalle']['step'] = 1;
$this->_sections['detalle']['start'] = $this->_sections['detalle']['step'] > 0 ? 0 : $this->_sections['detalle']['loop']-1;
if ($this->_sections['detalle']['show']) {
    $this->_sections['detalle']['total'] = $this->_sections['detalle']['loop'];
    if ($this->_sections['detalle']['total'] == 0)
        $this->_sections['detalle']['show'] = false;
} else
    $this->_sections['detalle']['total'] = 0;
if ($this->_sections['detalle']['show']):

            for ($this->_sections['detalle']['index'] = $this->_sections['detalle']['start'], $this->_sections['detalle']['iteration'] = 1;
                 $this->_sections['detalle']['iteration'] <= $this->_sections['detalle']['total'];
                 $this->_sections['detalle']['index'] += $this->_sections['detalle']['step'], $this->_sections['detalle']['iteration']++):
$this->_sections['detalle']['rownum'] = $this->_sections['detalle']['iteration'];
$this->_sections['detalle']['index_prev'] = $this->_sections['detalle']['index'] - $this->_sections['detalle']['step'];
$this->_sections['detalle']['index_next'] = $this->_sections['detalle']['index'] + $this->_sections['detalle']['step'];
$this->_sections['detalle']['first']      = ($this->_sections['detalle']['iteration'] == 1);
$this->_sections['detalle']['last']       = ($this->_sections['detalle']['iteration'] == $this->_sections['detalle']['total']);
?>
					<?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr'] == $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['ncorr'] )): ?>
						<tr> 
							<td colspan='4' class="grilla-tab-fila-campo-pequenio"></td>
							<td class="grilla-tab-fila-campo-pequenio" align='right'><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['codigo']; ?>
</td>
							<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='left'><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['descripcion']; ?>
</td>
							<td class="grilla-tab-fila-campo-pequenio" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['cantidad'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
							<td class="grilla-tab-fila-campo-pequenio" align='center'><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['nu']; ?>
</td>
						</tr>
					<?php endif; ?>
				<?php endfor; endif; ?>
			</table>
		</td>
	</tr>
	-->
	
	<tr>
		<td colspan='14'  class="grilla-tab-fila-campo"></td>
	</tr>
		
<?php endfor; endif; ?>

<!--
<tr>
	<td colspan='3' class="grilla-tab-fila-campo" align='right'><b>Total Artículos:</b></td>
	<td colspan='11' class="grilla-tab-fila-campo" align='left'><b><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_ARTICULOS'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</b></td>
</tr>
<tr>
	<td colspan='3' class="grilla-tab-fila-campo" align='right'><b>Total Tarjetas:</b></td>
	<td colspan='11' class="grilla-tab-fila-campo" align='left'><b><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_TARJETAS'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</b></td>
</tr>
<tr>
	<td colspan='3' class="grilla-tab-fila-campo" align='right'><b>Total Ventas:</b></td>
	<td colspan='11' class="grilla-tab-fila-campo" align='left'><b><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_VENTAS'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</b></td>
</tr>
-->

<tr>
	<td colspan='14' class="grilla-tab-fila-titulo">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divresultado');">
		<input type="button" name="btnImprimir" value="Imprimir Formulario Carga" class="boton" onclick="ImprimeDiv('divresultadocarga');">
		<!--<input type="button" name="btnExportar" value="Exportar a Excel" class="boton" onclick="enviaPivotExcel('Form1');">!-->
	</td>
</tr>

</table>
</div>