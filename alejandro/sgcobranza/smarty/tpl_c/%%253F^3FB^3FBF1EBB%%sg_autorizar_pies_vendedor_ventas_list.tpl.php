<?php /* Smarty version 2.6.18, created on 2014-07-15 12:52:10
         compiled from sg_autorizar_pies_vendedor_ventas_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_autorizar_pies_vendedor_ventas_list.tpl', 5, false),array('modifier', 'number_format', 'sg_autorizar_pies_vendedor_ventas_list.tpl', 33, false),)), $this); ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='10' class="grilla-tab-fila-titulo" align='center'><b>Listado de autorizaciones de pie de vendedor de ventas por confirmar al <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</b></td>
</tr>

<tr>
    <td class="grilla-tab-fila-titulo" align='center'><input type="checkbox" name="selectall[]" id="selectall" onclick="checkAll(document.getElementById('Form1'), 'results1', this.checked);"></td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha de venta</td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha de vale</td>
	<td class="grilla-tab-fila-titulo" align='center'>Folio</td>
	<td class="grilla-tab-fila-titulo" align='center'>Monto</td>
	<td class="grilla-tab-fila-titulo" align='center'>Trabajador</td>
	<td class="grilla-tab-fila-titulo" align='center'>Usuario</td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha digitacion</td>
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
		<td class="grilla-tab-fila-campo" align='center'>
			<input type="checkbox" name="seleccion[]" class="results1" value='<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
'>
		</td>
		<td class="grilla-tab-fila-campo" align='center'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</td>
        <td class="grilla-tab-fila-campo" align='center'>
        	<input type="text" name="fecha_vale_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
" id="fecha_vale_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
" class="fecha_vale" onKeyPress="return SoloNumeros(this, event, 0)" onkeyup="mascara(this,'/',patron,true)" />
        </td>
		<td class="grilla-tab-fila-campo" align='center'>
        	<a href="#" onclick="xajax_LlamaVenta(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['folio']; ?>
');">
            	<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['folio']; ?>

            </a>
        </td>
		<td class="grilla-tab-fila-campo" align='center'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo" align='right'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['trabajador']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['usuario']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_digitacion'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y %H:%M:%S") : smarty_modifier_date_format($_tmp, "%d/%m/%Y %H:%M:%S")); ?>
</td>
	</tr>
		
<?php endfor; endif; ?>

<tr>
	<td colspan='2' class="grilla-tab-fila-titulo" align='left'>Total:</td>
	<td colspan='6' class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_FOLIOS'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
</tr>

<tr>
	<td colspan='10' class="grilla-tab-fila-titulo">
		<input type="button" name="btnConfirmar" value="Confirmar" class="boton" onclick="xajax_Grabar(xajax.getFormValues('Form1'));">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
	</td>
</tr>
</table>
</div>


