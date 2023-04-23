<?php /* Smarty version 2.6.18, created on 2018-10-23 20:30:51
         compiled from sg_inasistencias_apoderados_ingresar_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_inasistencias_apoderados_ingresar_list.tpl', 32, false),)), $this); ?>
<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Periodo
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' colspan="10">
			<?php echo $this->_tpl_vars['periodo']; ?>

		</td>
	</tr>
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left' >
			Curso
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' colspan="10">
			<?php echo $this->_tpl_vars['curso']; ?>

		</td>
	</tr>
		<?php unset($this->_sections['alumnos']);
$this->_sections['alumnos']['name'] = 'alumnos';
$this->_sections['alumnos']['loop'] = is_array($_loop=$this->_tpl_vars['arrAlumnos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['alumnos']['show'] = true;
$this->_sections['alumnos']['max'] = $this->_sections['alumnos']['loop'];
$this->_sections['alumnos']['step'] = 1;
$this->_sections['alumnos']['start'] = $this->_sections['alumnos']['step'] > 0 ? 0 : $this->_sections['alumnos']['loop']-1;
if ($this->_sections['alumnos']['show']) {
    $this->_sections['alumnos']['total'] = $this->_sections['alumnos']['loop'];
    if ($this->_sections['alumnos']['total'] == 0)
        $this->_sections['alumnos']['show'] = false;
} else
    $this->_sections['alumnos']['total'] = 0;
if ($this->_sections['alumnos']['show']):

            for ($this->_sections['alumnos']['index'] = $this->_sections['alumnos']['start'], $this->_sections['alumnos']['iteration'] = 1;
                 $this->_sections['alumnos']['iteration'] <= $this->_sections['alumnos']['total'];
                 $this->_sections['alumnos']['index'] += $this->_sections['alumnos']['step'], $this->_sections['alumnos']['iteration']++):
$this->_sections['alumnos']['rownum'] = $this->_sections['alumnos']['iteration'];
$this->_sections['alumnos']['index_prev'] = $this->_sections['alumnos']['index'] - $this->_sections['alumnos']['step'];
$this->_sections['alumnos']['index_next'] = $this->_sections['alumnos']['index'] + $this->_sections['alumnos']['step'];
$this->_sections['alumnos']['first']      = ($this->_sections['alumnos']['iteration'] == 1);
$this->_sections['alumnos']['last']       = ($this->_sections['alumnos']['iteration'] == $this->_sections['alumnos']['total']);
?>
		<tr>
       		<td class='grilla-tab-fila-campo-pequenio' align='left' style="width: 20%;">
       			<?php echo $this->_tpl_vars['arrAlumnos'][$this->_sections['alumnos']['index']]['nombre_alumno']; ?>

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
					<?php if (( $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['fecha'] == $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha'] ) && ( $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['rut_alumno'] == $this->_tpl_vars['arrAlumnos'][$this->_sections['alumnos']['index']]['rut_alumno'] )): ?>
						<?php if ($this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['rut_alumno'] == '-----'): ?>
						<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" >
							<?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha'] == 'promedio'): ?>
								Porc. Asistencia
							<?php else: ?>
								<a href="#" title="<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['title']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%d/%m/%Y') : smarty_modifier_date_format($_tmp, '%d/%m/%Y')); ?>
</a>
							<?php endif; ?>
	                    </td>
						<?php else: ?>
	             		<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" onclick="xajax_ConfirmarInasistencia(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['rut_alumno']; ?>
','<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['fecha']; ?>
');">
	             			<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['checked']; ?>

	                    </td>
	                    <?php endif; ?>
		            <?php endif; ?>
		        <?php endfor; endif; ?>
			<?php endfor; endif; ?>
		</tr>
		<?php endfor; endif; ?>
<tr>
	<td colspan="<?php echo $this->_tpl_vars['cant_dias']+5; ?>
" class="grilla-tab-fila-titulo">
        <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
     
	</td>
</tr>
</table>