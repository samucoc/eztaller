<?php /* Smarty version 2.6.18, created on 2011-01-24 00:09:10
         compiled from sg_gastos_ingreso_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'sg_gastos_ingreso_list.tpl', 75, false),)), $this); ?>
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td class="grilla-tab-fila-campo-pequenio" style="width: 15%" align='center'>Cuenta
		<a href="#" style="cursor: hand;"><img  src="../images/magnify.png" border=0 title="Click para Buscar" onclick="showPopWin('sg_busqueda_tbl.php?tbl=tipos_gastos', 'Cuentas', 500, 350, null);"></a>
	</td>
	<td class="grilla-tab-fila-campo-pequenio" style="width: 15%" align='center'>Sub Cuenta
		<a href="#" style="cursor: hand;"><img  src="../images/magnify.png" border=0 title="Click para Buscar" onclick="xajax_LlamaSubCuentas(xajax.getFormValues('Form1'));"></a>
	</td>
	<td class="grilla-tab-fila-campo-pequenio" style="width: 10%" align='center'>Obs.</td>
	<td class="grilla-tab-fila-campo-pequenio" style="width: 15%" align='center'>Tipo Doc.
		<a href="#" style="cursor: hand;"><img  src="../images/magnify.png" border=0 title="Click para Buscar" onclick="showPopWin('sg_busqueda_tbl.php?tbl=tipos_documentos', 'Tipos de Documentos', 500, 350, null);"></a>
	</td>
	<td class="grilla-tab-fila-campo-pequenio" style="width: 15%" align='center'>Proveedor
		<a href="#" style="cursor: hand;"><img  src="../images/magnify.png" border=0 title="Click para Buscar" onclick="showPopWin('sg_busqueda_tbl.php?tbl=sgbodega.proveedor', 'Proveedores', 500, 350, null);"></a>
	</td>
	<td class="grilla-tab-fila-campo-pequenio" style="width: 5%" align='center'>Nº Doc</td>
	<td class="grilla-tab-fila-campo-pequenio" style="width: 8%" align='center'>Fecha Doc.</td>
	<td class="grilla-tab-fila-campo-pequenio" style="width: 6%" align='center'>Neto</td>
	<td class="grilla-tab-fila-campo-pequenio" style="width: 5" align='center'>Iva</td>
	<td class="grilla-tab-fila-campo-pequenio" style="width: 6%" align='center'>Total</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'></td>
</tr>								
<tr>
	<td class="grilla-tab-fila-campo-pequenio" style="width: 15%" align='left'>
		<INPUT type="text" id="OBLItxtCodGasto" name="OBLItxtCodGasto" onKeyPress="return SoloNumeros(this, event, 1)" onchange="xajax_CargaDesc(xajax.getFormValues('Form1'),'tipos_gastos', 'tgas_ncorr', 'tgas_desc', 'OBLItxtCodGasto', 'OBLItxtDescGasto', '1');" value='' maxLength="10" style="width: 17%; font-size:10px;">
		<INPUT type="text" id="OBLItxtDescGasto" name="OBLItxtDescGasto" readonly value='' maxLength="100" style="width: 70%; font-size:10px;">
	</td>
	<td class="grilla-tab-fila-campo-pequenio" style="width: 15%" align='left'>
		<INPUT type="text" id="OBLItxtCodSubGasto" name="OBLItxtCodSubGasto" onKeyPress="return SoloNumeros(this, event, 1)" onchange="xajax_CargaDesc(xajax.getFormValues('Form1'),'tipos_subgastos', 'tsga_ncorr', 'tsga_desc', 'OBLItxtCodSubGasto', 'OBLItxtDescSubGasto', '1');" value='' maxLength="10" style="width: 17%; font-size:10px;">
		<INPUT type="text" id="OBLItxtDescSubGasto" name="OBLItxtDescSubGasto" readonly value='' maxLength="100" style="width: 70%; font-size:10px;">
	</td>
	<td class="grilla-tab-fila-campo-pequenio" style="width: 10%" align='left'>
		<INPUT type="text" id="txtObs" name="txtObs" value='' onKeyPress="return Tabula(this, event, 0)" maxLength="100" style="width: 94%; font-size:10px;">
	</td>
	<td class="grilla-tab-fila-campo-pequenio" style="width: 15%" align='left'>
		<INPUT type="text" id="OBLItxtCodDoc" name="OBLItxtCodDoc" onKeyPress="return SoloNumeros(this, event, 1)" onchange="xajax_CargaDesc(xajax.getFormValues('Form1'),'tipos_documentos', 'tdoc_ncorr', 'tdoc_desc', 'OBLItxtCodDoc', 'OBLItxtDescDoc', '1');" value='' maxLength="10" style="width: 17%; font-size:10px;">
		<INPUT type="text" id="OBLItxtDescDoc" name="OBLItxtDescDoc" readonly value='' maxLength="100" style="width: 70%; font-size:10px;">
	</td>
	<td class="grilla-tab-fila-campo-pequenio" style="width: 15%" align='left'>
		<INPUT type="text" id="txtCodProv" name="txtCodProv" onKeyPress="return SoloNumeros(this, event, 1)" onchange="xajax_CargaDesc(xajax.getFormValues('Form1'),'sgbodega.proveedor', 'pr_ncorr', 'pr_razon', 'txtCodProv', 'txtDescProv', '1');" value='' maxLength="10" style="width: 17%; font-size:10px;">
		<INPUT type="text" id="txtDescProv" name="txtDescProv" readonly value='' maxLength="100" style="width: 70%; font-size:10px;">
	</td>
	<td class="grilla-tab-fila-campo-pequenio" style="width: 5%" align='center'>
		<INPUT type="text" style="width: 85%; font-size:10px;" id="OBLItxtNumDoc" name="OBLItxtNumDoc" onKeyPress="return SoloNumeros(this, event, 0)" value='' maxLength="10">
	</td>
	<td class="grilla-tab-fila-campo-pequenio" style="width: 8%" align='center'>
		<INPUT type="text" style="width: 90%; font-size:10px;" id="OBLItxtFechaDoc" name="OBLItxtFechaDoc" value='' onKeyPress="return SoloNumeros(this, event, 0)" maxLength="10">
	</td>
	<td class="grilla-tab-fila-campo-pequenio" style="width: 6%" align='center'>
		<INPUT type="text" style="width: 88%; font-size:10px;" id="OBLItxtNeto" name="OBLItxtNeto" onKeyPress="return SoloNumeros(this, event, 1)" onchange="xajax_CalculaIva(xajax.getFormValues('Form1'), '1');" value='' maxLength="10">
	</td>
	<td class="grilla-tab-fila-campo-pequenio" style="width: 5%" align='center'>
		<INPUT type="text" style="width: 86%; font-size:10px;" id="OBLItxtIva" name="OBLItxtIva" onKeyPress="return SoloNumeros(this, event, 0)" value='' readonly maxLength="10">
	</td>
	<td class="grilla-tab-fila-campo-pequenio" style="width: 6%" align='center'>
		<INPUT type="text" style="width: 88%; font-size:10px;" id="OBLItxtTotal" name="OBLItxtTotal" onKeyPress="return SoloNumeros(this, event, 0)" onchange="xajax_CalculaIva(xajax.getFormValues('Form1'), '2');" value='' maxLength="10">
	</td>
	
	
	<td class="grilla-tab-fila-campo-pequenio" align='center'>
		<input type="button" name="btnAgregar" value=" + " class="boton" onclick="javascript: ValidaFormularioMantenedor();"> 
	</td>
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
		<td class="grilla-tab-fila-campo-pequenio" style="width: 15%"><a href='#'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo_gasto']; ?>
</a></td>
		<td class="grilla-tab-fila-campo-pequenio" style="width: 15%"><a href='#'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo_subgasto']; ?>
</a></td>
		<td class="grilla-tab-fila-campo-pequenio" style="width: 10%"><a href='#'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['obs']; ?>
</a></td>
		<td class="grilla-tab-fila-campo-pequenio" style="width: 15%"><a href='#'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo_doc']; ?>
</a></td>
		<td class="grilla-tab-fila-campo-pequenio" style="width: 15%"><a href='#'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['proveedor']; ?>
</a></td>
		<td class="grilla-tab-fila-campo-pequenio" style="width: 5%" align='right'><a href='#'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['numdoc']; ?>
</a></td>
		<td class="grilla-tab-fila-campo-pequenio" style="width: 8%"><a href='#'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fechadoc']; ?>
</a></td>
		<td class="grilla-tab-fila-campo-pequenio" style="width: 6%" align='right'><a href='#'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['neto'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</a></td>
		<td class="grilla-tab-fila-campo-pequenio" style="width: 5%" align='right'><a href='#'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['iva'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</a></td>
		<td class="grilla-tab-fila-campo-pequenio" style="width: 6%" align='right'><a href='#'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</a></td>
		<td class="grilla-tab-fila-campo-pequenio">
			<a href="#" style="cursor: hand;"><img src="../images/cross.png" border=0 title="Eliminar" onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"></a>
		</td>
	</tr>
		
<?php endfor; endif; ?>

</table>


