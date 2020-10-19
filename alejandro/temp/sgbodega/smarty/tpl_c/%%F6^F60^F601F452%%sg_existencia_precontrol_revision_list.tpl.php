<?php /* Smarty version 2.6.18, created on 2014-02-04 13:49:51
         compiled from sg_existencia_precontrol_revision_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_existencia_precontrol_revision_list.tpl', 5, false),array('modifier', 'number_format', 'sg_existencia_precontrol_revision_list.tpl', 35, false),)), $this); ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='18' class="grilla-tab-fila-titulo" align='center'><b>Consulta Stock Vendedor P/Revisión al <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
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
	<td class="grilla-tab-fila-titulo" style="width: 10%" align='center'>Código</td>
	<td class="grilla-tab-fila-titulo" style="width: 30%" align='center'>Descripción del Producto</td>
	<td class="grilla-tab-fila-titulo" style="width: 8%" align='center'>Valor</td>
	<td class="grilla-tab-fila-titulo" style="width: 8%" align='center'>Stock Nuevo</td>
	<td class="grilla-tab-fila-titulo" style="width: 5%" align='center'>Cor</td>
	<td class="grilla-tab-fila-titulo" style="width: 5%" align='center'>S/F</td>
	<td class="grilla-tab-fila-titulo" style="width: 8%" align='center'>DV</td>
	<td class="grilla-tab-fila-titulo" style="width: 8%" align='center'>Stock Usado</td>
	<td class="grilla-tab-fila-titulo" style="width: 5%" align='center'>Cor</td>
	<td class="grilla-tab-fila-titulo" style="width: 5%" align='center'>S/F</td>
	<td class="grilla-tab-fila-titulo" style="width: 8%" align='center'>DV</td>
</tr>

<?php unset($this->_sections['registros']);
$this->_sections['registros']['name'] = 'registros';
$this->_sections['registros']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistrosRev']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		<td class="grilla-tab-fila-campo-rev" style="width: 10%" align='right'><?php echo $this->_tpl_vars['arrRegistrosRev'][$this->_sections['registros']['index']]['codigo']; ?>
</td>
		<td class="grilla-tab-fila-campo-rev" style="width: 30%" align='left'><?php echo $this->_tpl_vars['arrRegistrosRev'][$this->_sections['registros']['index']]['descripcion']; ?>
</td>
		<td class="grilla-tab-fila-campo-rev" style="width: 8%" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistrosRev'][$this->_sections['registros']['index']]['valor'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-rev" style="width: 8%" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistrosRev'][$this->_sections['registros']['index']]['stock_nuevo'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-rev" style="width: 5%" align='center'><label class="requerido">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></td>
		<td class="grilla-tab-fila-campo-rev" style="width: 5%" align='center'><label class="requerido">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></td>
		<td class="grilla-tab-fila-campo-rev" style="width: 8%" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistrosRev'][$this->_sections['registros']['index']]['dv_nuevo'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-rev" style="width: 8%" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistrosRev'][$this->_sections['registros']['index']]['stock_usado'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo-rev" style="width: 5%" align='center'><label class="requerido">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></td>
		<td class="grilla-tab-fila-campo-rev" style="width: 5%" align='center'><label class="requerido">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></td>
		<td class="grilla-tab-fila-campo-rev" style="width: 8%" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistrosRev'][$this->_sections['registros']['index']]['dv_usado'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
	</tr>
		
<?php endfor; endif; ?>


</table>
</div>


