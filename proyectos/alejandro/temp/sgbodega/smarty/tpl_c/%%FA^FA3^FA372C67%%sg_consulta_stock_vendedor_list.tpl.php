<?php /* Smarty version 2.6.18, created on 2014-02-17 11:49:56
         compiled from sg_consulta_stock_vendedor_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_consulta_stock_vendedor_list.tpl', 5, false),array('modifier', 'number_format', 'sg_consulta_stock_vendedor_list.tpl', 57, false),)), $this); ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='18' class="grilla-tab-fila-titulo" align='center'><b>Consulta Stock Vendedor al <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</b></td>
</tr>

<tr>
	<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Empresa:</td>
	<td colspan='17' class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['EMPRESA']; ?>
</td>
</tr>
<tr>
	<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Vendedor:</td>
	<td colspan='17' class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['COBRADOR']; ?>
</td>
</tr>

<tr>
	<td colspan='4' class="grilla-tab-fila-titulo" align='center'></td>
	<td colspan='2' class="grilla-tab-fila-titulo" align='center'>Valor</td>
	<td colspan='2' class="grilla-tab-fila-titulo" align='center'>Inicial</td>
	<td colspan='2' class="grilla-tab-fila-titulo" align='center'>Aumentos</td>
	<td colspan='2' class="grilla-tab-fila-titulo" align='center'>Ventas</td>
	<td colspan='2' class="grilla-tab-fila-titulo" align='center'>Rebajas</td>
	<td colspan='2' class="grilla-tab-fila-titulo" align='center'>Nulas</td>
	<td colspan='2' class="grilla-tab-fila-titulo" align='center'><b>Stock Actual</b></td>

	
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'familia');">Familia</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'subfamilia');">SubFamilia</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'codigo');">Código</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'descripcion');">Descripción</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'valor_n');">N</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'valor_u');">U</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'inicial_n');">N</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'inicial_u');">U</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'aumentos_n');">N</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'aumentos_u');">U</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'ventas_n');">N</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'ventas_u');">U</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'rebajas_n');">N</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'rebajas_u');">U</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'nulas_n');">N</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'nulas_u');">U</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'actual_n');">N</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'actual_u');">U</a></td>
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
		
		<td class="grilla-tab-fila-campo-rev" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['familia']; ?>
</td>
		<td class="grilla-tab-fila-campo-rev" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['subfamilia']; ?>
</td>
		<td class="grilla-tab-fila-campo-rev" align='right'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['codigo']; ?>
</td>
		<td class="grilla-tab-fila-campo-rev" align='left'><a href="#" style="cursor: hand;" onclick="xajax_LlamaDetalle(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['codigo']; ?>
', '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['descripcion']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['descripcion']; ?>
</a></td>
		<td class="grilla-tab-fila-campo-rev" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['valor_n'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-rev" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['valor_u'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-rev" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['inicial_n'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-rev" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['inicial_u'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-rev" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['aumentos_n'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-rev" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['aumentos_u'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-rev" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ventas_n'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-rev" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ventas_u'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-rev" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rebajas_n'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-rev" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rebajas_u'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-rev" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nulas_n'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-rev" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nulas_u'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-rev" align='right'><b><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['actual_n'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</b></td>
		<td class="grilla-tab-fila-campo-rev" align='right'><b><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['actual_u'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</b></td>
		
	</tr>
		
<?php endfor; endif; ?>
<tr>
	<td colspan='6' class="grilla-tab-fila-titulo" align='right'><B>Totales:</B></td>
	<td class="grilla-tab-fila-campo" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_INICIAL_N'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	<td class="grilla-tab-fila-campo" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_INICIAL_U'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	<td class="grilla-tab-fila-campo" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_AUMENTOS_N'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	<td class="grilla-tab-fila-campo" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_AUMENTOS_U'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	<td class="grilla-tab-fila-campo" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_VENTAS_N'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	<td class="grilla-tab-fila-campo" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_VENTAS_U'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	<td class="grilla-tab-fila-campo" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_REBAJAS_N'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	<td class="grilla-tab-fila-campo" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_REBAJAS_U'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	<td class="grilla-tab-fila-campo" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_NULAS_N'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	<td class="grilla-tab-fila-campo" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_NULAS_U'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	<td class="grilla-tab-fila-campo" align='right'><b><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_ACTUAL_N'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</b></td>
	<td class="grilla-tab-fila-campo" align='right'><b><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_ACTUAL_U'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</b></td>
</tr>

<tr>
	<td colspan='18' class="grilla-tab-fila-titulo">
		<input type="button" name="btnImprimir" value="Imprimir Listado" class="boton" onclick="ImprimeDiv('divabonos');">
		<input type="button" name="btnImprimir" value="Imprimir Listado P/Revisión" class="boton" onclick="ImprimeDiv('divrevision');">
	</td>
</tr>
</table>
</div>


