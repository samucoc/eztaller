<?php /* Smarty version 2.6.18, created on 2012-02-08 11:08:36
         compiled from sg_busqueda_depositos_list.tpl */ ?>
<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-titulo-pequenio">Cód.</td>
	
	<!--
	<td class="grilla-tab-fila-titulo-pequenio">Empresa</td>
	<td class="grilla-tab-fila-titulo-pequenio">Sector</td>
	<td class="grilla-tab-fila-titulo-pequenio">Cobrador</td>
	-->
	
	<td class="grilla-tab-fila-titulo-pequenio">Tipo</td>
	<td class="grilla-tab-fila-titulo-pequenio">Banco</td>
	<td class="grilla-tab-fila-titulo-pequenio">Sucursal</td>
	<td class="grilla-tab-fila-titulo-pequenio">Cta.</td>
	<td class="grilla-tab-fila-titulo-pequenio">Fecha Cob.</td>
	<td class="grilla-tab-fila-titulo-pequenio">Fecha Dep.</td>
	<td class="grilla-tab-fila-titulo-pequenio">Transac.</td>
	<td class="grilla-tab-fila-titulo-pequenio">Monto</td>
	<td class="grilla-tab-fila-titulo-pequenio">Usuario</td>
	<td class="grilla-tab-fila-titulo-pequenio"></td>
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
	<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
		
		<td class='grilla-tab-fila-campo-pequenio' align='right'>
			<INPUT style='text-align: right; font-size:9px; width: 90%;' type="text" id="<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['codigo']; ?>
" name="<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['codigo']; ?>
" size='2' value='<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['codigo']; ?>
' readonly>
		</td>
		<!--
		<td class='grilla-tab-fila-campo-pequenio' align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['empresa']; ?>
</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['sector']; ?>
</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cobrador']; ?>
</td>
		-->
		
		<td class='grilla-tab-fila-campo-pequenio' align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo']; ?>
</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['banco']; ?>
</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['sucursal']; ?>
</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cta']; ?>
</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fechacob']; ?>
</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fechadep']; ?>
</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['transac']; ?>
</td>
		<td class='grilla-tab-fila-campo-pequenio' align='right'><b><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto']; ?>
</b></td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['usuario']; ?>
</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center'>
			<input type='button' name='btnOK' value='OK' class='botondestaca' onclick="xajax_Confirmar('<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');">
		</td>

	</tr>
<?php endfor; endif; ?>



</table>