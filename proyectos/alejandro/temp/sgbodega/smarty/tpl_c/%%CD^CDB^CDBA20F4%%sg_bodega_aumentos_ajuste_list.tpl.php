<?php /* Smarty version 2.6.18, created on 2013-12-04 17:48:35
         compiled from sg_bodega_aumentos_ajuste_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'sg_bodega_aumentos_ajuste_list.tpl', 10, false),)), $this); ?>
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
		<td class="grilla-tab-fila-campo" style="width: 7%"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['codigo']; ?>
</td>
		<td class="grilla-tab-fila-campo" style="width: 38%"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['descripcion']; ?>
</td>
		<td class="grilla-tab-fila-campo" style="width: 7%" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cantidad'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo">
			<a href="#" style="cursor: hand;"><img src="../images/cross.png" border=0 title="Eliminar" onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"></a>
		</td>
	</tr>
		
<?php endfor; endif; ?>

</table>
</div>


