<?php /* Smarty version 2.6.18, created on 2014-07-15 12:56:49
         compiled from sg_ventas_revisar_preventas_informe_hv_articulos_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'sg_ventas_revisar_preventas_informe_hv_articulos_list.tpl', 26, false),)), $this); ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='7' class="grilla-tab-fila-campo-pequenio" align='center'><b>Artículos de la Cuenta</b></td>
</tr>

<tr>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Item</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Código</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Descripción</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>N/U</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Cantidad</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Precio</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Total</td>
</tr>

<?php unset($this->_sections['productos']);
$this->_sections['productos']['name'] = 'productos';
$this->_sections['productos']['loop'] = is_array($_loop=$this->_tpl_vars['arrProductos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['productos']['show'] = true;
$this->_sections['productos']['max'] = $this->_sections['productos']['loop'];
$this->_sections['productos']['step'] = 1;
$this->_sections['productos']['start'] = $this->_sections['productos']['step'] > 0 ? 0 : $this->_sections['productos']['loop']-1;
if ($this->_sections['productos']['show']) {
    $this->_sections['productos']['total'] = $this->_sections['productos']['loop'];
    if ($this->_sections['productos']['total'] == 0)
        $this->_sections['productos']['show'] = false;
} else
    $this->_sections['productos']['total'] = 0;
if ($this->_sections['productos']['show']):

            for ($this->_sections['productos']['index'] = $this->_sections['productos']['start'], $this->_sections['productos']['iteration'] = 1;
                 $this->_sections['productos']['iteration'] <= $this->_sections['productos']['total'];
                 $this->_sections['productos']['index'] += $this->_sections['productos']['step'], $this->_sections['productos']['iteration']++):
$this->_sections['productos']['rownum'] = $this->_sections['productos']['iteration'];
$this->_sections['productos']['index_prev'] = $this->_sections['productos']['index'] - $this->_sections['productos']['step'];
$this->_sections['productos']['index_next'] = $this->_sections['productos']['index'] + $this->_sections['productos']['step'];
$this->_sections['productos']['first']      = ($this->_sections['productos']['iteration'] == 1);
$this->_sections['productos']['last']       = ($this->_sections['productos']['iteration'] == $this->_sections['productos']['total']);
?>
	<tr>
		<td class="grilla-tab-fila-campo-pequenio" align='center'><?php echo $this->_tpl_vars['arrProductos'][$this->_sections['productos']['index']]['item']; ?>
</td>
		<td class="grilla-tab-fila-campo-pequenio"><?php echo $this->_tpl_vars['arrProductos'][$this->_sections['productos']['index']]['codigo']; ?>
</td>
		<td class="grilla-tab-fila-campo-pequenio">
			<INPUT type="text" id="<?php echo $this->_tpl_vars['arrProductos'][$this->_sections['productos']['index']]['ncorr']; ?>
txtDesc" name="<?php echo $this->_tpl_vars['arrProductos'][$this->_sections['productos']['index']]['ncorr']; ?>
txtDesc" value='<?php echo $this->_tpl_vars['arrProductos'][$this->_sections['productos']['index']]['descripcion']; ?>
' maxLength="100" style="WIDTH: 98%;">
		</td>
		<td class="grilla-tab-fila-campo-pequenio" align='center'><?php echo $this->_tpl_vars['arrProductos'][$this->_sections['productos']['index']]['nu']; ?>
</td>
		<td class="grilla-tab-fila-campo-pequenio" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrProductos'][$this->_sections['productos']['index']]['cantidad'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-pequenio" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrProductos'][$this->_sections['productos']['index']]['precio'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-pequenio" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrProductos'][$this->_sections['productos']['index']]['total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	</tr>
<?php endfor; endif; ?>

</table>
</div>


