<?php /* Smarty version 2.6.18, created on 2011-01-20 11:00:26
         compiled from sg_gastos_autorizacion_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'sg_gastos_autorizacion_list.tpl', 48, false),)), $this); ?>
<br>
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

	<tr>
		<td class="grilla-tab-fila-titulo-pequenio" align='center'>
			<?php echo '
				<input type="checkbox" id="check1" name="check1" 
				onclick="if(this.checked == true){xajax_SeleccionaTodos(xajax.getFormValues(\'Form1\'))}else{xajax_DeseleccionaTodos(xajax.getFormValues(\'Form1\'))}">
			'; ?>

		</td>
		
		<td class="grilla-tab-fila-titulo-pequenio" align='center'>Empresa</td>
		<td class="grilla-tab-fila-titulo-pequenio" align='center'>Sec</td>
		<td class="grilla-tab-fila-titulo-pequenio" align='center'>Trabajador</td>
		<td class="grilla-tab-fila-titulo-pequenio" align='center'>Ing</td>
		<td class="grilla-tab-fila-titulo-pequenio" align='center'>Fecha</td>
		<td class="grilla-tab-fila-titulo-pequenio" align='center'>Cuenta</td>
		<td class="grilla-tab-fila-titulo-pequenio" align='center'>Sub Cuenta</td>
		<td class="grilla-tab-fila-titulo-pequenio" align='center'>Obs.</td>
		<!--<td class="grilla-tab-fila-titulo-pequenio" align='center'>D</td>-->
		<td class="grilla-tab-fila-titulo-pequenio" align='center'>Proveedor</td>
		<td class="grilla-tab-fila-titulo-pequenio" align='center'>Doc.</td>
		<!--<td class="grilla-tab-fila-titulo-pequenio" align='center'>Fecha Doc.</td>-->
		<td class="grilla-tab-fila-titulo-pequenio" align='center'>Neto</td>
		<td class="grilla-tab-fila-titulo-pequenio" align='center'>Iva</td>
		<td class="grilla-tab-fila-titulo-pequenio" align='center'>Total</td>
		<td class="grilla-tab-fila-titulo-pequenio" align='center'></td>
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
		<td class="grilla-tab-fila-campo-pequenio" align='left' style="width: 2%">
			<input type="checkbox" name="seleccion[]" value='<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
'>
		</td>
		<td class="grilla-tab-fila-campo-pequenio"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['empresa']; ?>
</td>
		<td class="grilla-tab-fila-campo-pequenio" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['sector']; ?>
</td>
		<td class="grilla-tab-fila-campo-pequenio"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['trabajador']; ?>
</td>
		<td class="grilla-tab-fila-campo-pequenio" align='right'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['num_ingreso']; ?>
</td>
		<td class="grilla-tab-fila-campo-pequenio" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_ingreso']; ?>
</td>
		<td class="grilla-tab-fila-campo-pequenio"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo_gasto']; ?>
</td>
		<td class="grilla-tab-fila-campo-pequenio"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo_subgasto']; ?>
</td>
		<td class="grilla-tab-fila-campo-pequenio"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['obs']; ?>
</td>
		<!--<td class="grilla-tab-fila-campo-pequenio" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo_doc']; ?>
</td>-->
		<td class="grilla-tab-fila-campo-pequenio"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['proveedor']; ?>
</td>
		<td class="grilla-tab-fila-campo-pequenio" align='right'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo_doc']; ?>
:&nbsp;<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['numdoc']; ?>
</td>
		<!--<td class="grilla-tab-fila-campo-pequenio"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fechadoc']; ?>
</td>-->
		<td class="grilla-tab-fila-campo-pequenio" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['neto'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-pequenio" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['iva'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-pequenio" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-pequenio">
			<a href="#" style="cursor: hand;"><img src="../images/cross.png" border=0 title="Eliminar" onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"></a>
		</td>
	</tr>
		
<?php endfor; endif; ?>

<tr>
	<td colspan='11' class="grilla-tab-fila-campo" align='right'><b>Totales:</b></td>
	<td class="grilla-tab-fila-campo" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_NETO'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	<td class="grilla-tab-fila-campo" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_IVA'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	<td class="grilla-tab-fila-campo" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_TOTAL'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
</tr>
</table>



