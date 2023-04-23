<?php /* Smarty version 2.6.18, created on 2013-08-21 14:57:35
         compiled from sg_bodega_cuentas_personales_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_bodega_cuentas_personales_list.tpl', 5, false),array('modifier', 'number_format', 'sg_bodega_cuentas_personales_list.tpl', 25, false),)), $this); ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='10' class="grilla-tab-fila-titulo" align='center'><b>Listado de Cuentas Personales al <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</b></td>
</tr>

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha Cuenta Personal</td>
	<td class="grilla-tab-fila-titulo" align='center'>Nro Cuenta Personal</td>
	<td class="grilla-tab-fila-titulo" align='center'>Código</td>
	<td class="grilla-tab-fila-titulo" align='center'>Descripción</td>
	<td class="grilla-tab-fila-titulo" align='center'>Cantidad</td>
	<td class="grilla-tab-fila-titulo" align='center'>Usuario</td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha Dig.</td>
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
		<td class="grilla-tab-fila-campo" align='center'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</td>
		<td class="grilla-tab-fila-campo" align='right'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['guia']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='right'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['codigo']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['descripcion']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cantidad'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
		<td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['usuario']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='center'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_dig'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y %H:%M:%S") : smarty_modifier_date_format($_tmp, "%d/%m/%Y %H:%M:%S")); ?>
</td>
		<td class="grilla-tab-fila-campo" align='center'>
			<input type="button" name="btnConfirmar" value="Confirmar" class="boton" onclick="xajax_Grabar(xajax.getFormValues('Form1'),<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['mdet_ncorr']; ?>
);">
		</td>
	</tr>
		
<?php endfor; endif; ?>

<!--
<tr>
	<td colspan='2' class="grilla-tab-fila-titulo" align='left'>Total:</td>
	<td colspan='6' class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['TOTAL_FOLIOS'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
</tr>
!-->

<tr>
	<td colspan='10' class="grilla-tab-fila-titulo">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
	</td>
</tr>
</table>
</div>


