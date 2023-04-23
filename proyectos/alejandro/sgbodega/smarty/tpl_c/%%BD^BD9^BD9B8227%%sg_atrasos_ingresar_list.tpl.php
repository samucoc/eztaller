<?php /* Smarty version 2.6.18, created on 2017-03-14 22:00:09
         compiled from sg_atrasos_ingresar_list.tpl */ ?>
<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Nro Lista
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Alumno
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' colspan="<?php echo $this->_tpl_vars['cant_dias']; ?>
">
			Fecha
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Total
		</td>
	</tr>
    <tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
        </td>
		<?php unset($this->_sections['dias']);
$this->_sections['dias']['name'] = 'dias';
$this->_sections['dias']['loop'] = is_array($_loop=$this->_tpl_vars['arrDias']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['dias']['show'] = true;
$this->_sections['dias']['max'] = $this->_sections['dias']['loop'];
$this->_sections['dias']['step'] = 1;
$this->_sections['dias']['start'] = $this->_sections['dias']['step'] > 0 ? 0 : $this->_sections['dias']['loop']-1;
if ($this->_sections['dias']['show']) {
    $this->_sections['dias']['total'] = $this->_sections['dias']['loop'];
    if ($this->_sections['dias']['total'] == 0)
        $this->_sections['dias']['show'] = false;
} else
    $this->_sections['dias']['total'] = 0;
if ($this->_sections['dias']['show']):

            for ($this->_sections['dias']['index'] = $this->_sections['dias']['start'], $this->_sections['dias']['iteration'] = 1;
                 $this->_sections['dias']['iteration'] <= $this->_sections['dias']['total'];
                 $this->_sections['dias']['index'] += $this->_sections['dias']['step'], $this->_sections['dias']['iteration']++):
$this->_sections['dias']['rownum'] = $this->_sections['dias']['iteration'];
$this->_sections['dias']['index_prev'] = $this->_sections['dias']['index'] - $this->_sections['dias']['step'];
$this->_sections['dias']['index_next'] = $this->_sections['dias']['index'] + $this->_sections['dias']['step'];
$this->_sections['dias']['first']      = ($this->_sections['dias']['iteration'] == 1);
$this->_sections['dias']['last']       = ($this->_sections['dias']['iteration'] == $this->_sections['dias']['total']);
?>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			<?php echo $this->_tpl_vars['arrDias'][$this->_sections['dias']['index']]['nro_dia']; ?>

		</td>
        <?php endfor; endif; ?>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
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
			<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['numero_lista']; ?>

		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre_alumno']; ?>

		</td>
		<?php unset($this->_sections['registrosDetalle']);
$this->_sections['registrosDetalle']['name'] = 'registrosDetalle';
$this->_sections['registrosDetalle']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistrosDetalle']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['registrosDetalle']['show'] = true;
$this->_sections['registrosDetalle']['max'] = $this->_sections['registrosDetalle']['loop'];
$this->_sections['registrosDetalle']['step'] = 1;
$this->_sections['registrosDetalle']['start'] = $this->_sections['registrosDetalle']['step'] > 0 ? 0 : $this->_sections['registrosDetalle']['loop']-1;
if ($this->_sections['registrosDetalle']['show']) {
    $this->_sections['registrosDetalle']['total'] = $this->_sections['registrosDetalle']['loop'];
    if ($this->_sections['registrosDetalle']['total'] == 0)
        $this->_sections['registrosDetalle']['show'] = false;
} else
    $this->_sections['registrosDetalle']['total'] = 0;
if ($this->_sections['registrosDetalle']['show']):

            for ($this->_sections['registrosDetalle']['index'] = $this->_sections['registrosDetalle']['start'], $this->_sections['registrosDetalle']['iteration'] = 1;
                 $this->_sections['registrosDetalle']['iteration'] <= $this->_sections['registrosDetalle']['total'];
                 $this->_sections['registrosDetalle']['index'] += $this->_sections['registrosDetalle']['step'], $this->_sections['registrosDetalle']['iteration']++):
$this->_sections['registrosDetalle']['rownum'] = $this->_sections['registrosDetalle']['iteration'];
$this->_sections['registrosDetalle']['index_prev'] = $this->_sections['registrosDetalle']['index'] - $this->_sections['registrosDetalle']['step'];
$this->_sections['registrosDetalle']['index_next'] = $this->_sections['registrosDetalle']['index'] + $this->_sections['registrosDetalle']['step'];
$this->_sections['registrosDetalle']['first']      = ($this->_sections['registrosDetalle']['iteration'] == 1);
$this->_sections['registrosDetalle']['last']       = ($this->_sections['registrosDetalle']['iteration'] == $this->_sections['registrosDetalle']['total']);
?>
        	<?php if ($this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['rut_alumno'] == $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']): ?>
                <?php if ($this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['domingo'] == 'SI' || $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['festivo'] == 'SI'): ?>
					<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" style="background-color:#F00">
                    </td>
                <?php else: ?>
                    <?php if ($this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['atraso'] == 'SI'): ?>
                    <td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" ondblclick="xajax_EliminarAtraso(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['rut_alumno']; ?>
','<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['fecha']; ?>
');" >
                    X
                    </td>
                    <?php else: ?>
                    <td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" ondblclick="xajax_ConfirmarAtraso(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['rut_alumno']; ?>
','<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['fecha']; ?>
');">
                    </td>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endfor; endif; ?>
        <td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px">
			<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['contador']; ?>

        </td>
	</tr>
<?php endfor; endif; ?>
    <tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
        </td>
		<?php unset($this->_sections['dias']);
$this->_sections['dias']['name'] = 'dias';
$this->_sections['dias']['loop'] = is_array($_loop=$this->_tpl_vars['arrDias']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['dias']['show'] = true;
$this->_sections['dias']['max'] = $this->_sections['dias']['loop'];
$this->_sections['dias']['step'] = 1;
$this->_sections['dias']['start'] = $this->_sections['dias']['step'] > 0 ? 0 : $this->_sections['dias']['loop']-1;
if ($this->_sections['dias']['show']) {
    $this->_sections['dias']['total'] = $this->_sections['dias']['loop'];
    if ($this->_sections['dias']['total'] == 0)
        $this->_sections['dias']['show'] = false;
} else
    $this->_sections['dias']['total'] = 0;
if ($this->_sections['dias']['show']):

            for ($this->_sections['dias']['index'] = $this->_sections['dias']['start'], $this->_sections['dias']['iteration'] = 1;
                 $this->_sections['dias']['iteration'] <= $this->_sections['dias']['total'];
                 $this->_sections['dias']['index'] += $this->_sections['dias']['step'], $this->_sections['dias']['iteration']++):
$this->_sections['dias']['rownum'] = $this->_sections['dias']['iteration'];
$this->_sections['dias']['index_prev'] = $this->_sections['dias']['index'] - $this->_sections['dias']['step'];
$this->_sections['dias']['index_next'] = $this->_sections['dias']['index'] + $this->_sections['dias']['step'];
$this->_sections['dias']['first']      = ($this->_sections['dias']['iteration'] == 1);
$this->_sections['dias']['last']       = ($this->_sections['dias']['iteration'] == $this->_sections['dias']['total']);
?>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			<?php echo $this->_tpl_vars['arrDias'][$this->_sections['dias']['index']]['nro_dia']; ?>

		</td>
        <?php endfor; endif; ?>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
        </td>
    </tr>
<tr>
	<td colspan="<?php echo $this->_tpl_vars['cant_dias']+3; ?>
" class="grilla-tab-fila-titulo">
        <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
    
	</td>
</tr>
</table>