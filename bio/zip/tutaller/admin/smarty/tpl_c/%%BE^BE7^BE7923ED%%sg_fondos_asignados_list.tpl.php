<?php /* Smarty version 2.6.18, created on 2011-01-23 01:55:52
         compiled from sg_fondos_asignados_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_fondos_asignados_list.tpl', 5, false),array('modifier', 'number_format', 'sg_fondos_asignados_list.tpl', 32, false),)), $this); ?>
<br>
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td colspan='7' class="grilla-tab-fila-titulo" align='center'><b>Listado de Fondos Asignados al <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</b></td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo"><b>Rango:</b></td>
	<td colspan='6' class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['RANGO']; ?>
</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo"><b>Trabajador:</b></td>
	<td colspan='6' class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['TRABAJADOR']; ?>
</td>
</tr>

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Empresa</td>
	<td class="grilla-tab-fila-titulo" align='center'>Sector</td>
	<td class="grilla-tab-fila-titulo" align='center'>Trabajador</td>
	<td class="grilla-tab-fila-titulo" align='center'>Rut</td>
	<td class="grilla-tab-fila-titulo" align='center'>Monto</td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
	<td class="grilla-tab-fila-titulo" align='center'></td>
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
		<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['empresa']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='right'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['sector']; ?>
</td>
		<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['trabajador']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['dv']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha']; ?>
</td>
		<td class="grilla-tab-fila-campo">
			<a href="#" style="cursor: hand;"><img src="../images/cross.png" border=0 title="Eliminar" onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"></a>
		</td>
	</tr>
		
<?php endfor; endif; ?>

<tr>
	<td colspan='4' class="grilla-tab-fila-campo" align='right'><b>Total:</b></td>
	<td class="grilla-tab-fila-campo" align='right'><b><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_ASIGNADO'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</b></td>
	<td class="grilla-tab-fila-campo" align='center'></td>
</tr>
<tr>
	<td colspan='7' class="grilla-tab-fila-titulo">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divresultado');">
	</td>
</tr>
</table>



