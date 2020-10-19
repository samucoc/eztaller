<?php /* Smarty version 2.6.18, created on 2010-08-27 22:15:09
         compiled from sg_listado_archivos_subidos_list.tpl */ ?>
<div id="pivot">
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">


<tr>
	<td colspan='2' class="grilla-tab-fila-titulo" align='center'><b>Listado de Archivos Asociados al Siniestro</b></td>

</tr>

<tr>
	<td class="grilla-tab-fila-titulo" align='center' style="WIDTH: 90%;">Archivo</td>
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
		<td class="grilla-tab-fila-campo">
			<a href="<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ruta']; ?>
" style="cursor: hand;"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['archivo']; ?>
</a>
		</td>
		<td class="grilla-tab-fila-campo">
			<a href="#" style="cursor: hand;"><img  src="../images/cross.png" border=0 title="Eliminar" onclick="xajax_Eliminar(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ruta']; ?>
');"></a>
		</td>
		
		<!--
		<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['descripcion']; ?>
</td>
		<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['abreviacion']; ?>
</td>
		<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['obs']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='center' style="WIDTH: 8%;">
			<a href="#" style="cursor: hand;"><img  src="../images/edit.png" border=0 title="Modificar" onclick="xajax_Modificar(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"></a>
			&nbsp;
			<a href="#" style="cursor: hand;"><img  src="../images/cross.png" border=0 title="Eliminar" onclick="xajax_Eliminar(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
');"></a>
		</td>
		-->
		
	</tr>
<?php endfor; endif; ?>

</table>
</div>