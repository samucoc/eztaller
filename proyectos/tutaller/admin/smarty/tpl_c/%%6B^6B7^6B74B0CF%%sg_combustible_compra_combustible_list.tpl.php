<?php /* Smarty version 2.6.18, created on 2013-02-04 13:38:26
         compiled from sg_combustible_compra_combustible_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_combustible_compra_combustible_list.tpl', 16, false),)), $this); ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
	<td class="grilla-tab-fila-titulo" align='center'>Empresa</td>
	<td class="grilla-tab-fila-titulo" align='center'>Tipo Combustible</td>
	<td class="grilla-tab-fila-titulo" align='center'>Monto</td>
	<td class="grilla-tab-fila-titulo" align='center'></td>
	

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
		<td class="grilla-tab-fila-campo" align='left'>
        	<?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>

            <input type="hidden" name="fecha[]" value='<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha']; ?>
'/>
        </td>
		<td class="grilla-tab-fila-campo" align='left'>
        	<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['empresa']; ?>

            <input type="hidden" name="empresa[]" value='<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['empresa']; ?>
'/>
        </td>
		<td class="grilla-tab-fila-campo" align='left'>
        	<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo_com']; ?>

            <input type="hidden" name="tipo_com[]" value='<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo_com']; ?>
'/>
        </td>
		<td class="grilla-tab-fila-campo" align='left'>
        	<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto']; ?>

            <input type="hidden" name="monto[]" value='<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto']; ?>
'/>
        </td>
		<td class="grilla-tab-fila-campo" align='left'>
        	<a href="#" onclick="xajax_Eliminar(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
'))">Eliminar</a>
        </td>
        </tr>
<?php endfor; endif; ?>

</table>
</div>


