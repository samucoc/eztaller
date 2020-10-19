<?php /* Smarty version 2.6.18, created on 2017-07-26 16:26:47
         compiled from sg_inasistencias_ingresar_list.tpl */ ?>
<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
			Periodo
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' colspan="100">
			<?php echo $this->_tpl_vars['periodo']; ?>

		</td>
	</tr>
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left' >
			Curso
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' colspan="100">
			<?php echo $this->_tpl_vars['curso']; ?>

		</td>
	</tr>
	<tr>
		<td class='grilla-tab-fila-campo-pequenio' align='left' >
			Mes
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' colspan="100">
			<?php echo $this->_tpl_vars['mes']; ?>

		</td>
	</tr>
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
		<td class='grilla-tab-fila-campo-pequenio' align='left' width="10%">
			<?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_retiro'] != '0000-00-00'): ?>
				<strike>
				<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['numero_lista']; ?>

				</strike>
			<?php else: ?>
				<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['numero_lista']; ?>

			<?php endif; ?>
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left' width="20%">
			<?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_retiro'] != '0000-00-00'): ?>
				<strike>
				<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre_alumno']; ?>

				</strike>
			<?php else: ?>
				<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre_alumno']; ?>

			<?php endif; ?>
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
        	<?php if (( $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['rut_alumno'] == $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno'] ) && ( $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['nro_lista'] == $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['numero_lista'] )): ?>
                <?php if ($this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['domingo'] == 'SI' || $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['festivo'] == 'SI'): ?>
					<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" style="background-color:#ffcccc">
                    </td>
                <?php else: ?>
                    <?php if ($this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['atraso'] == 'SI'): ?>
                    	<?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_retiro'] != '0000-00-00'): ?>
							<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" >
		                		<strike>
		                    	X
		                    	</strike>
		                    </td>
						<?php else: ?>
							<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px"  onclick="xajax_EliminarInasistencia(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['rut_alumno']; ?>
','<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['fecha']; ?>
');" >
		                    	X
		                    </td>
						<?php endif; ?>
                    <?php else: ?>
	                    <?php if ($this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['cont_atraso'] > 0): ?>
	                    <td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px">
	                    	<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['cont_atraso']; ?>

	                    </td>
	                    <?php else: ?>
	                    	<?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_retiro'] != '0000-00-00'): ?>
								<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" >
	                    		</td>							
	                    	<?php else: ?>
								<td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px" onclick="xajax_ConfirmarInasistencia(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['rut_alumno']; ?>
','<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['fecha']; ?>
');">
			                    </td>
	                    	<?php endif; ?>
	                    
	                    <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endfor; endif; ?>
        <td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px">
			<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['contador']; ?>

        </td>
        <td class='grilla-tab-fila-campo-pequenio' align='center' width="10px" height="10px">
			<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['porcentaje']; ?>

        </td>
		<td class="grilla-tab-fila-campo-pequenio" align='center' width="10px" height="10px">
			<?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno'] == '0000000'): ?>
			<?php else: ?>
				<?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['porcentaje'] < '85'): ?>
					<img src='../../sgcobranza/images/cara_roja.jpg' width='24'/>
				<?php elseif (( ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['porcentaje'] >= '85' ) && ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['porcentaje'] <= '90' ) )): ?>
					<img src='../../sgcobranza/images/cara_amarilla.jpg' width='24'/>
				<?php else: ?>
					<img src='../../sgcobranza/images/cara_verde.jpg' width='24'/>
				<?php endif; ?>
			<?php endif; ?>
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
		<td class='grilla-tab-fila-campo-pequenio' align='center'>
			<?php echo $this->_tpl_vars['arrDias'][$this->_sections['dias']['index']]['nro_dia']; ?>

		</td>
        <?php endfor; endif; ?>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>
        </td>
    </tr>
	<tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>Total Presentes</td>
		<?php unset($this->_sections['presente']);
$this->_sections['presente']['name'] = 'presente';
$this->_sections['presente']['loop'] = is_array($_loop=$this->_tpl_vars['arrPresentes']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['presente']['show'] = true;
$this->_sections['presente']['max'] = $this->_sections['presente']['loop'];
$this->_sections['presente']['step'] = 1;
$this->_sections['presente']['start'] = $this->_sections['presente']['step'] > 0 ? 0 : $this->_sections['presente']['loop']-1;
if ($this->_sections['presente']['show']) {
    $this->_sections['presente']['total'] = $this->_sections['presente']['loop'];
    if ($this->_sections['presente']['total'] == 0)
        $this->_sections['presente']['show'] = false;
} else
    $this->_sections['presente']['total'] = 0;
if ($this->_sections['presente']['show']):

            for ($this->_sections['presente']['index'] = $this->_sections['presente']['start'], $this->_sections['presente']['iteration'] = 1;
                 $this->_sections['presente']['iteration'] <= $this->_sections['presente']['total'];
                 $this->_sections['presente']['index'] += $this->_sections['presente']['step'], $this->_sections['presente']['iteration']++):
$this->_sections['presente']['rownum'] = $this->_sections['presente']['iteration'];
$this->_sections['presente']['index_prev'] = $this->_sections['presente']['index'] - $this->_sections['presente']['step'];
$this->_sections['presente']['index_next'] = $this->_sections['presente']['index'] + $this->_sections['presente']['step'];
$this->_sections['presente']['first']      = ($this->_sections['presente']['iteration'] == 1);
$this->_sections['presente']['last']       = ($this->_sections['presente']['iteration'] == $this->_sections['presente']['total']);
?>
		<td class='grilla-tab-fila-campo-pequenio' align='center'>
			<?php echo $this->_tpl_vars['arrPresentes'][$this->_sections['presente']['index']]['cantidad']; ?>

		</td>
        <?php endfor; endif; ?>
	</tr>
	<tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>Total Ausentes</td>
		<?php unset($this->_sections['ausente']);
$this->_sections['ausente']['name'] = 'ausente';
$this->_sections['ausente']['loop'] = is_array($_loop=$this->_tpl_vars['arrAusentes']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['ausente']['show'] = true;
$this->_sections['ausente']['max'] = $this->_sections['ausente']['loop'];
$this->_sections['ausente']['step'] = 1;
$this->_sections['ausente']['start'] = $this->_sections['ausente']['step'] > 0 ? 0 : $this->_sections['ausente']['loop']-1;
if ($this->_sections['ausente']['show']) {
    $this->_sections['ausente']['total'] = $this->_sections['ausente']['loop'];
    if ($this->_sections['ausente']['total'] == 0)
        $this->_sections['ausente']['show'] = false;
} else
    $this->_sections['ausente']['total'] = 0;
if ($this->_sections['ausente']['show']):

            for ($this->_sections['ausente']['index'] = $this->_sections['ausente']['start'], $this->_sections['ausente']['iteration'] = 1;
                 $this->_sections['ausente']['iteration'] <= $this->_sections['ausente']['total'];
                 $this->_sections['ausente']['index'] += $this->_sections['ausente']['step'], $this->_sections['ausente']['iteration']++):
$this->_sections['ausente']['rownum'] = $this->_sections['ausente']['iteration'];
$this->_sections['ausente']['index_prev'] = $this->_sections['ausente']['index'] - $this->_sections['ausente']['step'];
$this->_sections['ausente']['index_next'] = $this->_sections['ausente']['index'] + $this->_sections['ausente']['step'];
$this->_sections['ausente']['first']      = ($this->_sections['ausente']['iteration'] == 1);
$this->_sections['ausente']['last']       = ($this->_sections['ausente']['iteration'] == $this->_sections['ausente']['total']);
?>
		<td class='grilla-tab-fila-campo-pequenio' align='center'>
			<?php echo $this->_tpl_vars['arrAusentes'][$this->_sections['ausente']['index']]['cantidad']; ?>

		</td>
        <?php endfor; endif; ?>
	</tr>
	<tr>
    	<td class='grilla-tab-fila-campo-pequenio' align='left'>
		</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>Total Matricula</td>
		<?php unset($this->_sections['matricula']);
$this->_sections['matricula']['name'] = 'matricula';
$this->_sections['matricula']['loop'] = is_array($_loop=$this->_tpl_vars['arrMatricula']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['matricula']['show'] = true;
$this->_sections['matricula']['max'] = $this->_sections['matricula']['loop'];
$this->_sections['matricula']['step'] = 1;
$this->_sections['matricula']['start'] = $this->_sections['matricula']['step'] > 0 ? 0 : $this->_sections['matricula']['loop']-1;
if ($this->_sections['matricula']['show']) {
    $this->_sections['matricula']['total'] = $this->_sections['matricula']['loop'];
    if ($this->_sections['matricula']['total'] == 0)
        $this->_sections['matricula']['show'] = false;
} else
    $this->_sections['matricula']['total'] = 0;
if ($this->_sections['matricula']['show']):

            for ($this->_sections['matricula']['index'] = $this->_sections['matricula']['start'], $this->_sections['matricula']['iteration'] = 1;
                 $this->_sections['matricula']['iteration'] <= $this->_sections['matricula']['total'];
                 $this->_sections['matricula']['index'] += $this->_sections['matricula']['step'], $this->_sections['matricula']['iteration']++):
$this->_sections['matricula']['rownum'] = $this->_sections['matricula']['iteration'];
$this->_sections['matricula']['index_prev'] = $this->_sections['matricula']['index'] - $this->_sections['matricula']['step'];
$this->_sections['matricula']['index_next'] = $this->_sections['matricula']['index'] + $this->_sections['matricula']['step'];
$this->_sections['matricula']['first']      = ($this->_sections['matricula']['iteration'] == 1);
$this->_sections['matricula']['last']       = ($this->_sections['matricula']['iteration'] == $this->_sections['matricula']['total']);
?>
		<td class='grilla-tab-fila-campo-pequenio' align='center'>
			<?php echo $this->_tpl_vars['arrMatricula'][$this->_sections['matricula']['index']]['cantidad']; ?>

		</td>
        <?php endfor; endif; ?>
	</tr>
    
<tr>
	<td colspan="<?php echo $this->_tpl_vars['cant_dias']+5; ?>
" class="grilla-tab-fila-titulo">
        <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
     
	</td>
</tr>
</table>