<?php /* Smarty version 2.6.18, created on 2017-06-09 16:58:49
         compiled from sg_orden_compra_precio_costo_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_orden_compra_precio_costo_list.tpl', 21, false),)), $this); ?>
<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

	<tr>
		<td >
			<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

				<tr>
					<td class="grilla-tab-fila-titulo-pequenio">Codigo</td>
					<td class="grilla-tab-fila-titulo-pequenio">Descripcion</td>
					<td class="grilla-tab-fila-titulo-pequenio">Precio Costo Nuevo</td>
					<td class="grilla-tab-fila-titulo-pequenio">Usuario</td>
					<td class="grilla-tab-fila-titulo-pequenio">Fecha Digitacion</td>
				</tr>

				<?php unset($this->_sections['pcn']);
$this->_sections['pcn']['name'] = 'pcn';
$this->_sections['pcn']['loop'] = is_array($_loop=$this->_tpl_vars['arrpcn']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['pcn']['show'] = true;
$this->_sections['pcn']['max'] = $this->_sections['pcn']['loop'];
$this->_sections['pcn']['step'] = 1;
$this->_sections['pcn']['start'] = $this->_sections['pcn']['step'] > 0 ? 0 : $this->_sections['pcn']['loop']-1;
if ($this->_sections['pcn']['show']) {
    $this->_sections['pcn']['total'] = $this->_sections['pcn']['loop'];
    if ($this->_sections['pcn']['total'] == 0)
        $this->_sections['pcn']['show'] = false;
} else
    $this->_sections['pcn']['total'] = 0;
if ($this->_sections['pcn']['show']):

            for ($this->_sections['pcn']['index'] = $this->_sections['pcn']['start'], $this->_sections['pcn']['iteration'] = 1;
                 $this->_sections['pcn']['iteration'] <= $this->_sections['pcn']['total'];
                 $this->_sections['pcn']['index'] += $this->_sections['pcn']['step'], $this->_sections['pcn']['iteration']++):
$this->_sections['pcn']['rownum'] = $this->_sections['pcn']['iteration'];
$this->_sections['pcn']['index_prev'] = $this->_sections['pcn']['index'] - $this->_sections['pcn']['step'];
$this->_sections['pcn']['index_next'] = $this->_sections['pcn']['index'] + $this->_sections['pcn']['step'];
$this->_sections['pcn']['first']      = ($this->_sections['pcn']['iteration'] == 1);
$this->_sections['pcn']['last']       = ($this->_sections['pcn']['iteration'] == $this->_sections['pcn']['total']);
?>
					<tr >
						<td class='grilla-tab-fila-campo-pequenio' align='left'><?php echo $this->_tpl_vars['arrpcn'][$this->_sections['pcn']['index']]['codigo']; ?>
</td>
						<td class='grilla-tab-fila-campo-pequenio' align='left'><?php echo $this->_tpl_vars['arrpcn'][$this->_sections['pcn']['index']]['descr']; ?>
</td>
						<td class='grilla-tab-fila-campo-pequenio' align='left'><?php echo $this->_tpl_vars['arrpcn'][$this->_sections['pcn']['index']]['precio_neto']; ?>
</td>
						<td class='grilla-tab-fila-campo-pequenio' align='left'><?php echo $this->_tpl_vars['arrpcn'][$this->_sections['pcn']['index']]['usuario']; ?>
</td>
						<td class='grilla-tab-fila-campo-pequenio' align='center'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrpcn'][$this->_sections['pcn']['index']]['fecha_dig'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</td>
					</tr>
				<?php endfor; endif; ?>
			</table>
		</td>
		<td >
			<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

				<tr>
					<td class="grilla-tab-fila-titulo-pequenio">Codigo</td>
					<td class="grilla-tab-fila-titulo-pequenio">Descripcion</td>
					<td class="grilla-tab-fila-titulo-pequenio">Precio Costo Usado</td>
					<td class="grilla-tab-fila-titulo-pequenio">Usuario</td>
					<td class="grilla-tab-fila-titulo-pequenio">Fecha Digitacion</td>
				</tr>
				<?php unset($this->_sections['pcu']);
$this->_sections['pcu']['name'] = 'pcu';
$this->_sections['pcu']['loop'] = is_array($_loop=$this->_tpl_vars['arrpcu']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['pcu']['show'] = true;
$this->_sections['pcu']['max'] = $this->_sections['pcu']['loop'];
$this->_sections['pcu']['step'] = 1;
$this->_sections['pcu']['start'] = $this->_sections['pcu']['step'] > 0 ? 0 : $this->_sections['pcu']['loop']-1;
if ($this->_sections['pcu']['show']) {
    $this->_sections['pcu']['total'] = $this->_sections['pcu']['loop'];
    if ($this->_sections['pcu']['total'] == 0)
        $this->_sections['pcu']['show'] = false;
} else
    $this->_sections['pcu']['total'] = 0;
if ($this->_sections['pcu']['show']):

            for ($this->_sections['pcu']['index'] = $this->_sections['pcu']['start'], $this->_sections['pcu']['iteration'] = 1;
                 $this->_sections['pcu']['iteration'] <= $this->_sections['pcu']['total'];
                 $this->_sections['pcu']['index'] += $this->_sections['pcu']['step'], $this->_sections['pcu']['iteration']++):
$this->_sections['pcu']['rownum'] = $this->_sections['pcu']['iteration'];
$this->_sections['pcu']['index_prev'] = $this->_sections['pcu']['index'] - $this->_sections['pcu']['step'];
$this->_sections['pcu']['index_next'] = $this->_sections['pcu']['index'] + $this->_sections['pcu']['step'];
$this->_sections['pcu']['first']      = ($this->_sections['pcu']['iteration'] == 1);
$this->_sections['pcu']['last']       = ($this->_sections['pcu']['iteration'] == $this->_sections['pcu']['total']);
?>
					<tr >
						<td class='grilla-tab-fila-campo-pequenio' align='left'><?php echo $this->_tpl_vars['arrpcu'][$this->_sections['pcu']['index']]['codigo']; ?>
</td>
						<td class='grilla-tab-fila-campo-pequenio' align='left'><?php echo $this->_tpl_vars['arrpcu'][$this->_sections['pcu']['index']]['descr']; ?>
</td>
						<td class='grilla-tab-fila-campo-pequenio' align='left'><?php echo $this->_tpl_vars['arrpcu'][$this->_sections['pcu']['index']]['precio_neto']; ?>
</td>
						<td class='grilla-tab-fila-campo-pequenio' align='left'><?php echo $this->_tpl_vars['arrpcu'][$this->_sections['pcu']['index']]['usuario']; ?>
</td>
						<td class='grilla-tab-fila-campo-pequenio' align='center'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrpcu'][$this->_sections['pcu']['index']]['fecha_dig'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</td>
					</tr>
				<?php endfor; endif; ?>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan='16' class="grilla-tab-fila-titulo">
			<!--<input type="button" name="btnSeleccionar" value="Volver" class="boton" onclick="xajax_Volver(xajax.getFormValues('Form1'));">-->
	        <input type="button" class='boton' value="Imprimir" onClick="ImprimeDiv('divabonos');">
		</td>
	</tr>
</table>

