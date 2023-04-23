<?php /* Smarty version 2.6.18, created on 2014-11-24 15:50:39
         compiled from sg_nylor_informe_precargas_2_simplificado_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_nylor_informe_precargas_2_simplificado_list.tpl', 5, false),array('modifier', 'number_format', 'sg_nylor_informe_precargas_2_simplificado_list.tpl', 43, false),)), $this); ?>
<div id="pivot">

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='14' class="grilla-tab-fila-titulo" align='center'><b>Informe de Precargas al <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</b></td>
</tr>
		
		<tr>
			<td colspan='3' class="grilla-tab-fila-titulo" align='left'>Producto:</td>
			<td colspan='11' class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['cod_producto']; ?>
 - <?php echo $this->_tpl_vars['descr_producto']; ?>
</td>
		</tr>

		<tr>
			<td class="grilla-tab-fila-titulo" align='center' >Empresa</td>
			<td class="grilla-tab-fila-titulo" align='center' >Folio</td>
			<td class="grilla-tab-fila-titulo" align='center' >Sector</td>
			<td class="grilla-tab-fila-titulo" align='center' >Fecha</td>
			<td class="grilla-tab-fila-titulo" align='center'>Cliente</td>
			<td class="grilla-tab-fila-titulo" align='center'>Código</td>
			<td class="grilla-tab-fila-titulo" align='center'>Descripción</td>
			<td class="grilla-tab-fila-titulo" align='center'>Observacion</td>
			<td class="grilla-tab-fila-titulo" align='center'>Cant.</td>
			<td class="grilla-tab-fila-titulo" align='center'>N/U</td>
			<td class="grilla-tab-fila-titulo" align='center'>Despachado</td>
			<td class="grilla-tab-fila-titulo" align='center'>Vendedor</td>
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
			<?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr'] == $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['folio'] )): ?>
		            <tr>
                        <td class="grilla-tab-fila-campo" align='right'><b><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['empresa']; ?>
</b></td>
                        <td class="grilla-tab-fila-campo" align='right'>
                            <b>
                                <a href="#" onclick="showPopWin('sg_ventas_revisar_preventas_informe_hv.php?folio=<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['folio']; ?>
', 'Revision', 800, 600, null);" ><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['folio']; ?>

                                </a>
                            </b></td>
                        <td class="grilla-tab-fila-campo" align='right'><b><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['sector']; ?>
</b></td>
                        <td class="grilla-tab-fila-campo" align='right'><b><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_tarjeta']; ?>
</b></td>
                        <td class="grilla-tab-fila-campo" align='left'><b><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cliente']; ?>
</b></td>
                        <td class="grilla-tab-fila-campo-pequenio" align='right'><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['codigo']; ?>
</td>
                        <td class="grilla-tab-fila-campo-pequenio" align='left'><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['descripcion']; ?>
</td>
                        <td class="grilla-tab-fila-campo-pequenio" align='right'><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['observacion']; ?>
</td>
                        <td class="grilla-tab-fila-campo-pequenio" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['cantidad'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
                        <td class="grilla-tab-fila-campo-pequenio" align='center'><?php echo $this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['nu']; ?>
</td>
                        <td class="grilla-tab-fila-campo-pequenio" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrDetalle'][$this->_sections['detalle']['index']]['despachado'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</td>
                        <td class="grilla-tab-fila-campo-pequenio" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cod_vendedor']; ?>
 -- <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre_vendedor']; ?>
</td>
    	   	<?php endif; ?>
		<?php endfor; endif; ?>
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
		<!--<input type="button" name="btnPdf" value="Generar PDF" class="boton" onclick="showPopWin('sg_nylor_informe_precargas_2_imprimir.php?VENDEDOR=<?php echo $this->_tpl_vars['VENDEDOR']; ?>
', 'Informe Precargas', 800, 600, null);">-->
		<input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
		<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('form1');" />
		<iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>

</table>
</div>