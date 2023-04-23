<?php /* Smarty version 2.6.18, created on 2016-04-19 20:44:47
         compiled from sg_informe_porcentaje_asistencia_list.tpl */ ?>
<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
    		Curso
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Porcentaje
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
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['curso']; ?>

		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['porcentaje']; ?>

		</td>
		<td class="grilla-tab-fila-campo-pequenio">
			<?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['porcentaje'] < '85'): ?>
				<img src='../../sgcobranza/images/cara_roja.jpg' width='24'/>
			<?php elseif (( ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['porcentaje'] >= '85' ) && ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['porcentaje'] <= '90' ) )): ?>
				<img src='../../sgcobranza/images/cara_amarilla.jpg' width='24'/>
			<?php else: ?>
				<img src='../../sgcobranza/images/cara_verde.jpg' width='24'/>
			<?php endif; ?>
		</td>
	</tr>
<?php endfor; endif; ?>
<tr>
	<td colspan="<?php echo $this->_tpl_vars['cant_dias']+3; ?>
" class="grilla-tab-fila-titulo">
        <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
        <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Grafico" onclick="showPopWin('sg_informe_porcentaje_asistencia_grafico.php?anio=<?php echo $this->_tpl_vars['anio']; ?>
&periodo=<?php echo $this->_tpl_vars['periodo']; ?>
', 'Grafico', 1200, 300, null);" width="32"></a>
	</td>
</tr>
</table>