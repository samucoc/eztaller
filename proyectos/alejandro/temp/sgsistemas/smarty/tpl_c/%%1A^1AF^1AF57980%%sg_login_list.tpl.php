<?php /* Smarty version 2.6.18, created on 2014-11-10 17:20:33
         compiled from sg_login_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_login_list.tpl', 6, false),)), $this); ?>
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
	<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
		<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['accion']; ?>
</td>
		<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['descripcion']; ?>
</td>
		<td class="grilla-tab-fila-campo"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y %H:%M:%S") : smarty_modifier_date_format($_tmp, "%d-%m-%Y %H:%M:%S")); ?>
</td>
		<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['usuario']; ?>
</td>
		</tr>
<?php endfor; endif; ?>

</table>