<?php /* Smarty version 2.6.18, created on 2017-04-26 15:32:02
         compiled from sg_bodega_toma_inventario_total_TI_list.tpl */ ?>
<div id="pivot">										
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Codigo Barra</td>
	<td class="grilla-tab-fila-titulo" align='center'>Codigo</td>
	<td class="grilla-tab-fila-titulo" align='center'>Descripción</td>
	<td class="grilla-tab-fila-titulo" align='center'>Cantidad</td>
	<td class="grilla-tab-fila-titulo" align='center'>Contado</td>
	<td class="grilla-tab-fila-titulo" align='center'>Diferencias</td>
	<td class="grilla-tab-fila-titulo" align='center'>Observacion</td>
	
</tr>

<?php unset($this->_sections['registrosTI']);
$this->_sections['registrosTI']['name'] = 'registrosTI';
$this->_sections['registrosTI']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistrosTI']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['registrosTI']['show'] = true;
$this->_sections['registrosTI']['max'] = $this->_sections['registrosTI']['loop'];
$this->_sections['registrosTI']['step'] = 1;
$this->_sections['registrosTI']['start'] = $this->_sections['registrosTI']['step'] > 0 ? 0 : $this->_sections['registrosTI']['loop']-1;
if ($this->_sections['registrosTI']['show']) {
    $this->_sections['registrosTI']['total'] = $this->_sections['registrosTI']['loop'];
    if ($this->_sections['registrosTI']['total'] == 0)
        $this->_sections['registrosTI']['show'] = false;
} else
    $this->_sections['registrosTI']['total'] = 0;
if ($this->_sections['registrosTI']['show']):

            for ($this->_sections['registrosTI']['index'] = $this->_sections['registrosTI']['start'], $this->_sections['registrosTI']['iteration'] = 1;
                 $this->_sections['registrosTI']['iteration'] <= $this->_sections['registrosTI']['total'];
                 $this->_sections['registrosTI']['index'] += $this->_sections['registrosTI']['step'], $this->_sections['registrosTI']['iteration']++):
$this->_sections['registrosTI']['rownum'] = $this->_sections['registrosTI']['iteration'];
$this->_sections['registrosTI']['index_prev'] = $this->_sections['registrosTI']['index'] - $this->_sections['registrosTI']['step'];
$this->_sections['registrosTI']['index_next'] = $this->_sections['registrosTI']['index'] + $this->_sections['registrosTI']['step'];
$this->_sections['registrosTI']['first']      = ($this->_sections['registrosTI']['iteration'] == 1);
$this->_sections['registrosTI']['last']       = ($this->_sections['registrosTI']['iteration'] == $this->_sections['registrosTI']['total']);
?>
	<tr>
		<td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistrosTI'][$this->_sections['registrosTI']['index']]['codigo_barra']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistrosTI'][$this->_sections['registrosTI']['index']]['codigo']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistrosTI'][$this->_sections['registrosTI']['index']]['descripcion']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='right'><?php echo $this->_tpl_vars['arrRegistrosTI'][$this->_sections['registrosTI']['index']]['cantidad']; ?>
</td>
	</tr>
		
<?php endfor; endif; ?>

</table>
</div>


