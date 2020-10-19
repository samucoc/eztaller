<?php /* Smarty version 2.6.18, created on 2014-02-17 12:09:19
         compiled from sg_informe_movimientos_fecha_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_informe_movimientos_fecha_list.tpl', 5, false),array('modifier', 'number_format', 'sg_informe_movimientos_fecha_list.tpl', 47, false),)), $this); ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='13' class="grilla-tab-fila-titulo" align='center'><b>Informe Movimientos al <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</b></td>
</tr>
<tr>
	<td colspan='3' class="grilla-tab-fila-titulo" align='left'>Periodo:</td>
	<td colspan='10' class="grilla-tab-fila-campo" align='left'>Desde: <?php echo $this->_tpl_vars['DESDE']; ?>
 Hasta: <?php echo $this->_tpl_vars['HASTA']; ?>
</td>
</tr>
<tr>
	<td colspan='3' class="grilla-tab-fila-titulo" align='left'>Tipo de Movimiento:</td>
	<td colspan='10' class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['NOMBRE_MOVIMIENTO']; ?>
</td>
</tr>
<tr>
	<td colspan='3' class="grilla-tab-fila-titulo" align='left'>Bodega:</td>
	<td colspan='10' class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['BODEGA']; ?>
</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'item');">Item</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'fecha');">Fecha</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'guia');">Guía</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'empresa');">Empresa</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'tipo_movim');">Tipo de Movimiento</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'det_mpvim');">Det Movimiento</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'cantidad');">Cantidad</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'factura');">Documento</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'usuario');">Usuario</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'fecha_dig');">Fecha Dig.</a></td>
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
		<td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['item']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='right'><a href='#' onclick="xajax_ImprimeGuia(xajax.getFormValues('Form1'), <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['guia']; ?>
);"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['guia']; ?>
</a></td>
        <td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['empresa']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo_movim']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['det_movim']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='right'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cantidad']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='right'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['factura']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['usuario']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_dig']; ?>
</td>
	</tr>
<?php endfor; endif; ?>
<tr>
	<td colspan='3' class="grilla-tab-fila-titulo" align='left'>Total:</td>
	<td colspan='10' class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
</tr>
<tr>
	<td colspan='13' class="grilla-tab-fila-titulo">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
	</td>
</tr>

</table>
</div>


