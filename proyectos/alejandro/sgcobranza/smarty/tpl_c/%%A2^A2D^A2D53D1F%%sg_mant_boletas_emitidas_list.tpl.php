<?php /* Smarty version 2.6.18, created on 2018-05-12 23:11:08
         compiled from sg_mant_boletas_emitidas_list.tpl */ ?>
<div id="pivot">
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Numero Boleta</td>
		<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
		<td class="grilla-tab-fila-titulo" align='center'>Alumno</td>
		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>
		<td class="grilla-tab-fila-titulo" align='center'>Valor</td>
		<td class="grilla-tab-fila-titulo" align='center'>Estado</td>
		<td class="grilla-tab-fila-titulo" align='center'>Tipo Pago</td>
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
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_boleta']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['alumno']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['descripcion']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['valor']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['estado']; ?>
</td>
			<td class="grilla-tab-fila-campo"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo_pago']; ?>
</td>
		</tr>
	<?php endfor; endif; ?>

	<tr>
	    <td colspan='16' class="grilla-tab-fila-titulo">
    		<a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divresultado');" width="32">
    	</td>
    </tr>
</table>
</div>