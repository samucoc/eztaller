<?php /* Smarty version 2.6.18, created on 2014-10-10 15:30:17
         compiled from sg_informe_reparaciones_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_informe_reparaciones_list.tpl', 20, false),array('modifier', 'number_format', 'sg_informe_reparaciones_list.tpl', 38, false),)), $this); ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
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
	<td class="grilla-tab-fila-titulo" align='center'>Trabajador</td>
	<td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['trabajador']; ?>
</td>
	<td class="grilla-tab-fila-titulo" align='center' width="25%">Patente</td>
	<td class="grilla-tab-fila-campo" align='center' width="25%"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['patente']; ?>
</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Nro Correlativo</td>
	<td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Mecanico</td>
	<td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['mecanico']; ?>
</td>
    <td class="grilla-tab-fila-titulo" align='center'>Fecha Reparacion</td>
	<td class="grilla-tab-fila-campo" align='center'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_repara'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Documento</td>
	<td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['documento']; ?>
</td>
	<td class="grilla-tab-fila-titulo" align='center'>Cheque</td>
	<td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cheque']; ?>
</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Repuesto</td>
	<td class="grilla-tab-fila-titulo" align='center'>Precio Unitario</td>
	<td class="grilla-tab-fila-titulo" align='center'>Cantidad</td>
	<td class="grilla-tab-fila-titulo" align='center'>Valor Total</td>
</tr>	
    <?php unset($this->_sections['detalle']);
$this->_sections['detalle']['name'] = 'detalle';
$this->_sections['detalle']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegDetalle']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
	    <?php if ($this->_tpl_vars['arrRegDetalle'][$this->_sections['detalle']['index']]['repara_ncorr'] == $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']): ?>
            <tr>
            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegDetalle'][$this->_sections['detalle']['index']]['repuesto']; ?>
</td>
            <td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegDetalle'][$this->_sections['detalle']['index']]['pu'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegDetalle'][$this->_sections['detalle']['index']]['cant']; ?>
</td>
            <td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegDetalle'][$this->_sections['detalle']['index']]['vt'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
            </tr>
    	<?php endif; ?>
    <?php endfor; endif; ?>
<tr>
	<td class="grilla-tab-fila-titulo" align='RIGHT' colspan="1">Observacion</td>
	<td class="grilla-tab-fila-campo" align='center' colspan="3"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['observa']; ?>
</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='RIGHT' colspan="3">Suma</td>
	<td class="grilla-tab-fila-campo" align='center'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['suma_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='RIGHT' colspan="4"></td>
</tr>
<?php endfor; endif; ?>
<tr>
	<td class="grilla-tab-fila-titulo" align='RIGHT' colspan="3">Suma Total</td>
	<td class="grilla-tab-fila-campo" align='center'><?php echo ((is_array($_tmp=$this->_tpl_vars['suma'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
</tr>
<tr>
	<td colspan='16' class="grilla-tab-fila-titulo">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>
</table>
</div>


