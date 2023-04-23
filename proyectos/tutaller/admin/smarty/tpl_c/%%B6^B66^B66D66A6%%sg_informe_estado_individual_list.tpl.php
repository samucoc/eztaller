<?php /* Smarty version 2.6.18, created on 2016-03-31 13:52:37
         compiled from sg_informe_estado_individual_list.tpl */ ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Trabajador</td>
	<td class="grilla-tab-fila-campo" align='center' colspan="<?php echo $this->_tpl_vars['total_meses']; ?>
" ><?php echo $this->_tpl_vars['trabajador']; ?>
</td>

</tr>

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Mes</td>
	<?php unset($this->_sections['mes']);
$this->_sections['mes']['name'] = 'mes';
$this->_sections['mes']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros_mes']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mes']['show'] = true;
$this->_sections['mes']['max'] = $this->_sections['mes']['loop'];
$this->_sections['mes']['step'] = 1;
$this->_sections['mes']['start'] = $this->_sections['mes']['step'] > 0 ? 0 : $this->_sections['mes']['loop']-1;
if ($this->_sections['mes']['show']) {
    $this->_sections['mes']['total'] = $this->_sections['mes']['loop'];
    if ($this->_sections['mes']['total'] == 0)
        $this->_sections['mes']['show'] = false;
} else
    $this->_sections['mes']['total'] = 0;
if ($this->_sections['mes']['show']):

            for ($this->_sections['mes']['index'] = $this->_sections['mes']['start'], $this->_sections['mes']['iteration'] = 1;
                 $this->_sections['mes']['iteration'] <= $this->_sections['mes']['total'];
                 $this->_sections['mes']['index'] += $this->_sections['mes']['step'], $this->_sections['mes']['iteration']++):
$this->_sections['mes']['rownum'] = $this->_sections['mes']['iteration'];
$this->_sections['mes']['index_prev'] = $this->_sections['mes']['index'] - $this->_sections['mes']['step'];
$this->_sections['mes']['index_next'] = $this->_sections['mes']['index'] + $this->_sections['mes']['step'];
$this->_sections['mes']['first']      = ($this->_sections['mes']['iteration'] == 1);
$this->_sections['mes']['last']       = ($this->_sections['mes']['iteration'] == $this->_sections['mes']['total']);
?>	
		<td class="grilla-tab-fila-campo" align='center' ><?php echo $this->_tpl_vars['arrRegistros_mes'][$this->_sections['mes']['index']]['mes']; ?>
</td>
	<?php endfor; endif; ?>	
</tr>

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Provision normal Mensual</td>
	<?php unset($this->_sections['si']);
$this->_sections['si']['name'] = 'si';
$this->_sections['si']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros_asig']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['si']['show'] = true;
$this->_sections['si']['max'] = $this->_sections['si']['loop'];
$this->_sections['si']['step'] = 1;
$this->_sections['si']['start'] = $this->_sections['si']['step'] > 0 ? 0 : $this->_sections['si']['loop']-1;
if ($this->_sections['si']['show']) {
    $this->_sections['si']['total'] = $this->_sections['si']['loop'];
    if ($this->_sections['si']['total'] == 0)
        $this->_sections['si']['show'] = false;
} else
    $this->_sections['si']['total'] = 0;
if ($this->_sections['si']['show']):

            for ($this->_sections['si']['index'] = $this->_sections['si']['start'], $this->_sections['si']['iteration'] = 1;
                 $this->_sections['si']['iteration'] <= $this->_sections['si']['total'];
                 $this->_sections['si']['index'] += $this->_sections['si']['step'], $this->_sections['si']['iteration']++):
$this->_sections['si']['rownum'] = $this->_sections['si']['iteration'];
$this->_sections['si']['index_prev'] = $this->_sections['si']['index'] - $this->_sections['si']['step'];
$this->_sections['si']['index_next'] = $this->_sections['si']['index'] + $this->_sections['si']['step'];
$this->_sections['si']['first']      = ($this->_sections['si']['iteration'] == 1);
$this->_sections['si']['last']       = ($this->_sections['si']['iteration'] == $this->_sections['si']['total']);
?>	
		<td class="grilla-tab-fila-campo" align='center' ><?php echo $this->_tpl_vars['arrRegistros_asig'][$this->_sections['si']['index']]['asignacion']; ?>
</td>
	<?php endfor; endif; ?>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Saldo Inicial</td>
	<?php unset($this->_sections['si']);
$this->_sections['si']['name'] = 'si';
$this->_sections['si']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros_si']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['si']['show'] = true;
$this->_sections['si']['max'] = $this->_sections['si']['loop'];
$this->_sections['si']['step'] = 1;
$this->_sections['si']['start'] = $this->_sections['si']['step'] > 0 ? 0 : $this->_sections['si']['loop']-1;
if ($this->_sections['si']['show']) {
    $this->_sections['si']['total'] = $this->_sections['si']['loop'];
    if ($this->_sections['si']['total'] == 0)
        $this->_sections['si']['show'] = false;
} else
    $this->_sections['si']['total'] = 0;
if ($this->_sections['si']['show']):

            for ($this->_sections['si']['index'] = $this->_sections['si']['start'], $this->_sections['si']['iteration'] = 1;
                 $this->_sections['si']['iteration'] <= $this->_sections['si']['total'];
                 $this->_sections['si']['index'] += $this->_sections['si']['step'], $this->_sections['si']['iteration']++):
$this->_sections['si']['rownum'] = $this->_sections['si']['iteration'];
$this->_sections['si']['index_prev'] = $this->_sections['si']['index'] - $this->_sections['si']['step'];
$this->_sections['si']['index_next'] = $this->_sections['si']['index'] + $this->_sections['si']['step'];
$this->_sections['si']['first']      = ($this->_sections['si']['iteration'] == 1);
$this->_sections['si']['last']       = ($this->_sections['si']['iteration'] == $this->_sections['si']['total']);
?>	
		<td class="grilla-tab-fila-campo" align='center' ><?php echo $this->_tpl_vars['arrRegistros_si'][$this->_sections['si']['index']]['saldo_inicial']; ?>
</td>
	<?php endfor; endif; ?>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Cargas Normales</td>
	<?php unset($this->_sections['cn']);
$this->_sections['cn']['name'] = 'cn';
$this->_sections['cn']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros_cn']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['cn']['show'] = true;
$this->_sections['cn']['max'] = $this->_sections['cn']['loop'];
$this->_sections['cn']['step'] = 1;
$this->_sections['cn']['start'] = $this->_sections['cn']['step'] > 0 ? 0 : $this->_sections['cn']['loop']-1;
if ($this->_sections['cn']['show']) {
    $this->_sections['cn']['total'] = $this->_sections['cn']['loop'];
    if ($this->_sections['cn']['total'] == 0)
        $this->_sections['cn']['show'] = false;
} else
    $this->_sections['cn']['total'] = 0;
if ($this->_sections['cn']['show']):

            for ($this->_sections['cn']['index'] = $this->_sections['cn']['start'], $this->_sections['cn']['iteration'] = 1;
                 $this->_sections['cn']['iteration'] <= $this->_sections['cn']['total'];
                 $this->_sections['cn']['index'] += $this->_sections['cn']['step'], $this->_sections['cn']['iteration']++):
$this->_sections['cn']['rownum'] = $this->_sections['cn']['iteration'];
$this->_sections['cn']['index_prev'] = $this->_sections['cn']['index'] - $this->_sections['cn']['step'];
$this->_sections['cn']['index_next'] = $this->_sections['cn']['index'] + $this->_sections['cn']['step'];
$this->_sections['cn']['first']      = ($this->_sections['cn']['iteration'] == 1);
$this->_sections['cn']['last']       = ($this->_sections['cn']['iteration'] == $this->_sections['cn']['total']);
?>
		<td class="grilla-tab-fila-campo" align='center' ><?php echo $this->_tpl_vars['arrRegistros_cn'][$this->_sections['cn']['index']]['carga_normal']; ?>
</td>		
	<?php endfor; endif; ?>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Reversa de Consumo</td>
	<?php unset($this->_sections['devo_carga']);
$this->_sections['devo_carga']['name'] = 'devo_carga';
$this->_sections['devo_carga']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros_devo_carga']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['devo_carga']['show'] = true;
$this->_sections['devo_carga']['max'] = $this->_sections['devo_carga']['loop'];
$this->_sections['devo_carga']['step'] = 1;
$this->_sections['devo_carga']['start'] = $this->_sections['devo_carga']['step'] > 0 ? 0 : $this->_sections['devo_carga']['loop']-1;
if ($this->_sections['devo_carga']['show']) {
    $this->_sections['devo_carga']['total'] = $this->_sections['devo_carga']['loop'];
    if ($this->_sections['devo_carga']['total'] == 0)
        $this->_sections['devo_carga']['show'] = false;
} else
    $this->_sections['devo_carga']['total'] = 0;
if ($this->_sections['devo_carga']['show']):

            for ($this->_sections['devo_carga']['index'] = $this->_sections['devo_carga']['start'], $this->_sections['devo_carga']['iteration'] = 1;
                 $this->_sections['devo_carga']['iteration'] <= $this->_sections['devo_carga']['total'];
                 $this->_sections['devo_carga']['index'] += $this->_sections['devo_carga']['step'], $this->_sections['devo_carga']['iteration']++):
$this->_sections['devo_carga']['rownum'] = $this->_sections['devo_carga']['iteration'];
$this->_sections['devo_carga']['index_prev'] = $this->_sections['devo_carga']['index'] - $this->_sections['devo_carga']['step'];
$this->_sections['devo_carga']['index_next'] = $this->_sections['devo_carga']['index'] + $this->_sections['devo_carga']['step'];
$this->_sections['devo_carga']['first']      = ($this->_sections['devo_carga']['iteration'] == 1);
$this->_sections['devo_carga']['last']       = ($this->_sections['devo_carga']['iteration'] == $this->_sections['devo_carga']['total']);
?>	
		<td class="grilla-tab-fila-campo" align='center' ><?php echo $this->_tpl_vars['arrRegistros_devo_carga'][$this->_sections['devo_carga']['index']]['devo_carga']; ?>
</td>
	<?php endfor; endif; ?>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Reversa de Asignacion</td>
	<?php unset($this->_sections['devo_carga']);
$this->_sections['devo_carga']['name'] = 'devo_carga';
$this->_sections['devo_carga']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros_devo_carga']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['devo_carga']['show'] = true;
$this->_sections['devo_carga']['max'] = $this->_sections['devo_carga']['loop'];
$this->_sections['devo_carga']['step'] = 1;
$this->_sections['devo_carga']['start'] = $this->_sections['devo_carga']['step'] > 0 ? 0 : $this->_sections['devo_carga']['loop']-1;
if ($this->_sections['devo_carga']['show']) {
    $this->_sections['devo_carga']['total'] = $this->_sections['devo_carga']['loop'];
    if ($this->_sections['devo_carga']['total'] == 0)
        $this->_sections['devo_carga']['show'] = false;
} else
    $this->_sections['devo_carga']['total'] = 0;
if ($this->_sections['devo_carga']['show']):

            for ($this->_sections['devo_carga']['index'] = $this->_sections['devo_carga']['start'], $this->_sections['devo_carga']['iteration'] = 1;
                 $this->_sections['devo_carga']['iteration'] <= $this->_sections['devo_carga']['total'];
                 $this->_sections['devo_carga']['index'] += $this->_sections['devo_carga']['step'], $this->_sections['devo_carga']['iteration']++):
$this->_sections['devo_carga']['rownum'] = $this->_sections['devo_carga']['iteration'];
$this->_sections['devo_carga']['index_prev'] = $this->_sections['devo_carga']['index'] - $this->_sections['devo_carga']['step'];
$this->_sections['devo_carga']['index_next'] = $this->_sections['devo_carga']['index'] + $this->_sections['devo_carga']['step'];
$this->_sections['devo_carga']['first']      = ($this->_sections['devo_carga']['iteration'] == 1);
$this->_sections['devo_carga']['last']       = ($this->_sections['devo_carga']['iteration'] == $this->_sections['devo_carga']['total']);
?>	
		<td class="grilla-tab-fila-campo" align='center' ><?php echo $this->_tpl_vars['arrRegistros_rev_asig'][$this->_sections['devo_carga']['index']]['rev_asig']; ?>
</td>
	<?php endfor; endif; ?>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Devoluciones de Asignacion</td>
	<?php unset($this->_sections['devo_asig']);
$this->_sections['devo_asig']['name'] = 'devo_asig';
$this->_sections['devo_asig']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros_devo_asig']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['devo_asig']['show'] = true;
$this->_sections['devo_asig']['max'] = $this->_sections['devo_asig']['loop'];
$this->_sections['devo_asig']['step'] = 1;
$this->_sections['devo_asig']['start'] = $this->_sections['devo_asig']['step'] > 0 ? 0 : $this->_sections['devo_asig']['loop']-1;
if ($this->_sections['devo_asig']['show']) {
    $this->_sections['devo_asig']['total'] = $this->_sections['devo_asig']['loop'];
    if ($this->_sections['devo_asig']['total'] == 0)
        $this->_sections['devo_asig']['show'] = false;
} else
    $this->_sections['devo_asig']['total'] = 0;
if ($this->_sections['devo_asig']['show']):

            for ($this->_sections['devo_asig']['index'] = $this->_sections['devo_asig']['start'], $this->_sections['devo_asig']['iteration'] = 1;
                 $this->_sections['devo_asig']['iteration'] <= $this->_sections['devo_asig']['total'];
                 $this->_sections['devo_asig']['index'] += $this->_sections['devo_asig']['step'], $this->_sections['devo_asig']['iteration']++):
$this->_sections['devo_asig']['rownum'] = $this->_sections['devo_asig']['iteration'];
$this->_sections['devo_asig']['index_prev'] = $this->_sections['devo_asig']['index'] - $this->_sections['devo_asig']['step'];
$this->_sections['devo_asig']['index_next'] = $this->_sections['devo_asig']['index'] + $this->_sections['devo_asig']['step'];
$this->_sections['devo_asig']['first']      = ($this->_sections['devo_asig']['iteration'] == 1);
$this->_sections['devo_asig']['last']       = ($this->_sections['devo_asig']['iteration'] == $this->_sections['devo_asig']['total']);
?>	
		<td class="grilla-tab-fila-campo" align='center' ><?php echo $this->_tpl_vars['arrRegistros_devo_asig'][$this->_sections['devo_asig']['index']]['devo_asig']; ?>
</td>
	<?php endfor; endif; ?>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Cargas Normales con Boleta</td>
	<?php unset($this->_sections['cn']);
$this->_sections['cn']['name'] = 'cn';
$this->_sections['cn']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros_cn_boleta']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['cn']['show'] = true;
$this->_sections['cn']['max'] = $this->_sections['cn']['loop'];
$this->_sections['cn']['step'] = 1;
$this->_sections['cn']['start'] = $this->_sections['cn']['step'] > 0 ? 0 : $this->_sections['cn']['loop']-1;
if ($this->_sections['cn']['show']) {
    $this->_sections['cn']['total'] = $this->_sections['cn']['loop'];
    if ($this->_sections['cn']['total'] == 0)
        $this->_sections['cn']['show'] = false;
} else
    $this->_sections['cn']['total'] = 0;
if ($this->_sections['cn']['show']):

            for ($this->_sections['cn']['index'] = $this->_sections['cn']['start'], $this->_sections['cn']['iteration'] = 1;
                 $this->_sections['cn']['iteration'] <= $this->_sections['cn']['total'];
                 $this->_sections['cn']['index'] += $this->_sections['cn']['step'], $this->_sections['cn']['iteration']++):
$this->_sections['cn']['rownum'] = $this->_sections['cn']['iteration'];
$this->_sections['cn']['index_prev'] = $this->_sections['cn']['index'] - $this->_sections['cn']['step'];
$this->_sections['cn']['index_next'] = $this->_sections['cn']['index'] + $this->_sections['cn']['step'];
$this->_sections['cn']['first']      = ($this->_sections['cn']['iteration'] == 1);
$this->_sections['cn']['last']       = ($this->_sections['cn']['iteration'] == $this->_sections['cn']['total']);
?>
		<td class="grilla-tab-fila-campo" align='center' ><?php echo $this->_tpl_vars['arrRegistros_cn_boleta'][$this->_sections['cn']['index']]['cn_boleta']; ?>
</td>		
	<?php endfor; endif; ?>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Disponible</td>
	<?php unset($this->_sections['disponible']);
$this->_sections['disponible']['name'] = 'disponible';
$this->_sections['disponible']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros_disponible']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['disponible']['show'] = true;
$this->_sections['disponible']['max'] = $this->_sections['disponible']['loop'];
$this->_sections['disponible']['step'] = 1;
$this->_sections['disponible']['start'] = $this->_sections['disponible']['step'] > 0 ? 0 : $this->_sections['disponible']['loop']-1;
if ($this->_sections['disponible']['show']) {
    $this->_sections['disponible']['total'] = $this->_sections['disponible']['loop'];
    if ($this->_sections['disponible']['total'] == 0)
        $this->_sections['disponible']['show'] = false;
} else
    $this->_sections['disponible']['total'] = 0;
if ($this->_sections['disponible']['show']):

            for ($this->_sections['disponible']['index'] = $this->_sections['disponible']['start'], $this->_sections['disponible']['iteration'] = 1;
                 $this->_sections['disponible']['iteration'] <= $this->_sections['disponible']['total'];
                 $this->_sections['disponible']['index'] += $this->_sections['disponible']['step'], $this->_sections['disponible']['iteration']++):
$this->_sections['disponible']['rownum'] = $this->_sections['disponible']['iteration'];
$this->_sections['disponible']['index_prev'] = $this->_sections['disponible']['index'] - $this->_sections['disponible']['step'];
$this->_sections['disponible']['index_next'] = $this->_sections['disponible']['index'] + $this->_sections['disponible']['step'];
$this->_sections['disponible']['first']      = ($this->_sections['disponible']['iteration'] == 1);
$this->_sections['disponible']['last']       = ($this->_sections['disponible']['iteration'] == $this->_sections['disponible']['total']);
?>	
		<td class="grilla-tab-fila-campo" align='center' ><?php echo $this->_tpl_vars['arrRegistros_disponible'][$this->_sections['disponible']['index']]['disponible']; ?>
</td>
	<?php endfor; endif; ?>
</tr>


<tr>
	<td class="grilla-tab-fila-titulo" align='center'></td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Extra</td>
	<?php unset($this->_sections['extra']);
$this->_sections['extra']['name'] = 'extra';
$this->_sections['extra']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros_extra']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['extra']['show'] = true;
$this->_sections['extra']['max'] = $this->_sections['extra']['loop'];
$this->_sections['extra']['step'] = 1;
$this->_sections['extra']['start'] = $this->_sections['extra']['step'] > 0 ? 0 : $this->_sections['extra']['loop']-1;
if ($this->_sections['extra']['show']) {
    $this->_sections['extra']['total'] = $this->_sections['extra']['loop'];
    if ($this->_sections['extra']['total'] == 0)
        $this->_sections['extra']['show'] = false;
} else
    $this->_sections['extra']['total'] = 0;
if ($this->_sections['extra']['show']):

            for ($this->_sections['extra']['index'] = $this->_sections['extra']['start'], $this->_sections['extra']['iteration'] = 1;
                 $this->_sections['extra']['iteration'] <= $this->_sections['extra']['total'];
                 $this->_sections['extra']['index'] += $this->_sections['extra']['step'], $this->_sections['extra']['iteration']++):
$this->_sections['extra']['rownum'] = $this->_sections['extra']['iteration'];
$this->_sections['extra']['index_prev'] = $this->_sections['extra']['index'] - $this->_sections['extra']['step'];
$this->_sections['extra']['index_next'] = $this->_sections['extra']['index'] + $this->_sections['extra']['step'];
$this->_sections['extra']['first']      = ($this->_sections['extra']['iteration'] == 1);
$this->_sections['extra']['last']       = ($this->_sections['extra']['iteration'] == $this->_sections['extra']['total']);
?>	
		<td class="grilla-tab-fila-campo" align='center' ><?php echo $this->_tpl_vars['arrRegistros_extra'][$this->_sections['extra']['index']]['extra']; ?>
</td>
	<?php endfor; endif; ?>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Extra con Boleta</td>
	<?php unset($this->_sections['extra_boleta']);
$this->_sections['extra_boleta']['name'] = 'extra_boleta';
$this->_sections['extra_boleta']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros_extra_boleta']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['extra_boleta']['show'] = true;
$this->_sections['extra_boleta']['max'] = $this->_sections['extra_boleta']['loop'];
$this->_sections['extra_boleta']['step'] = 1;
$this->_sections['extra_boleta']['start'] = $this->_sections['extra_boleta']['step'] > 0 ? 0 : $this->_sections['extra_boleta']['loop']-1;
if ($this->_sections['extra_boleta']['show']) {
    $this->_sections['extra_boleta']['total'] = $this->_sections['extra_boleta']['loop'];
    if ($this->_sections['extra_boleta']['total'] == 0)
        $this->_sections['extra_boleta']['show'] = false;
} else
    $this->_sections['extra_boleta']['total'] = 0;
if ($this->_sections['extra_boleta']['show']):

            for ($this->_sections['extra_boleta']['index'] = $this->_sections['extra_boleta']['start'], $this->_sections['extra_boleta']['iteration'] = 1;
                 $this->_sections['extra_boleta']['iteration'] <= $this->_sections['extra_boleta']['total'];
                 $this->_sections['extra_boleta']['index'] += $this->_sections['extra_boleta']['step'], $this->_sections['extra_boleta']['iteration']++):
$this->_sections['extra_boleta']['rownum'] = $this->_sections['extra_boleta']['iteration'];
$this->_sections['extra_boleta']['index_prev'] = $this->_sections['extra_boleta']['index'] - $this->_sections['extra_boleta']['step'];
$this->_sections['extra_boleta']['index_next'] = $this->_sections['extra_boleta']['index'] + $this->_sections['extra_boleta']['step'];
$this->_sections['extra_boleta']['first']      = ($this->_sections['extra_boleta']['iteration'] == 1);
$this->_sections['extra_boleta']['last']       = ($this->_sections['extra_boleta']['iteration'] == $this->_sections['extra_boleta']['total']);
?>	
		<td class="grilla-tab-fila-campo" align='center' ><?php echo $this->_tpl_vars['arrRegistros_extra_boleta'][$this->_sections['extra_boleta']['index']]['extra_boleta']; ?>
</td>
	<?php endfor; endif; ?>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Total Extras</td>
	<?php unset($this->_sections['total_extra']);
$this->_sections['total_extra']['name'] = 'total_extra';
$this->_sections['total_extra']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros_total_extra']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['total_extra']['show'] = true;
$this->_sections['total_extra']['max'] = $this->_sections['total_extra']['loop'];
$this->_sections['total_extra']['step'] = 1;
$this->_sections['total_extra']['start'] = $this->_sections['total_extra']['step'] > 0 ? 0 : $this->_sections['total_extra']['loop']-1;
if ($this->_sections['total_extra']['show']) {
    $this->_sections['total_extra']['total'] = $this->_sections['total_extra']['loop'];
    if ($this->_sections['total_extra']['total'] == 0)
        $this->_sections['total_extra']['show'] = false;
} else
    $this->_sections['total_extra']['total'] = 0;
if ($this->_sections['total_extra']['show']):

            for ($this->_sections['total_extra']['index'] = $this->_sections['total_extra']['start'], $this->_sections['total_extra']['iteration'] = 1;
                 $this->_sections['total_extra']['iteration'] <= $this->_sections['total_extra']['total'];
                 $this->_sections['total_extra']['index'] += $this->_sections['total_extra']['step'], $this->_sections['total_extra']['iteration']++):
$this->_sections['total_extra']['rownum'] = $this->_sections['total_extra']['iteration'];
$this->_sections['total_extra']['index_prev'] = $this->_sections['total_extra']['index'] - $this->_sections['total_extra']['step'];
$this->_sections['total_extra']['index_next'] = $this->_sections['total_extra']['index'] + $this->_sections['total_extra']['step'];
$this->_sections['total_extra']['first']      = ($this->_sections['total_extra']['iteration'] == 1);
$this->_sections['total_extra']['last']       = ($this->_sections['total_extra']['iteration'] == $this->_sections['total_extra']['total']);
?>	
		<td class="grilla-tab-fila-campo" align='center' ><?php echo $this->_tpl_vars['arrRegistros_total_extra'][$this->_sections['total_extra']['index']]['total_extra']; ?>
</td>
	<?php endfor; endif; ?>
</tr>

<tr>
	<td class="grilla-tab-fila-titulo" align='center'></td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Consumo Total Trabajador</td>
	<?php unset($this->_sections['extra']);
$this->_sections['extra']['name'] = 'extra';
$this->_sections['extra']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros_ctt']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['extra']['show'] = true;
$this->_sections['extra']['max'] = $this->_sections['extra']['loop'];
$this->_sections['extra']['step'] = 1;
$this->_sections['extra']['start'] = $this->_sections['extra']['step'] > 0 ? 0 : $this->_sections['extra']['loop']-1;
if ($this->_sections['extra']['show']) {
    $this->_sections['extra']['total'] = $this->_sections['extra']['loop'];
    if ($this->_sections['extra']['total'] == 0)
        $this->_sections['extra']['show'] = false;
} else
    $this->_sections['extra']['total'] = 0;
if ($this->_sections['extra']['show']):

            for ($this->_sections['extra']['index'] = $this->_sections['extra']['start'], $this->_sections['extra']['iteration'] = 1;
                 $this->_sections['extra']['iteration'] <= $this->_sections['extra']['total'];
                 $this->_sections['extra']['index'] += $this->_sections['extra']['step'], $this->_sections['extra']['iteration']++):
$this->_sections['extra']['rownum'] = $this->_sections['extra']['iteration'];
$this->_sections['extra']['index_prev'] = $this->_sections['extra']['index'] - $this->_sections['extra']['step'];
$this->_sections['extra']['index_next'] = $this->_sections['extra']['index'] + $this->_sections['extra']['step'];
$this->_sections['extra']['first']      = ($this->_sections['extra']['iteration'] == 1);
$this->_sections['extra']['last']       = ($this->_sections['extra']['iteration'] == $this->_sections['extra']['total']);
?>	
		<td class="grilla-tab-fila-campo" align='center' ><?php echo $this->_tpl_vars['arrRegistros_ctt'][$this->_sections['extra']['index']]['tt']; ?>
</td>
	<?php endfor; endif; ?>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Total consumido por copec</td>
	<?php unset($this->_sections['extra_boleta']);
$this->_sections['extra_boleta']['name'] = 'extra_boleta';
$this->_sections['extra_boleta']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros_tct']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['extra_boleta']['show'] = true;
$this->_sections['extra_boleta']['max'] = $this->_sections['extra_boleta']['loop'];
$this->_sections['extra_boleta']['step'] = 1;
$this->_sections['extra_boleta']['start'] = $this->_sections['extra_boleta']['step'] > 0 ? 0 : $this->_sections['extra_boleta']['loop']-1;
if ($this->_sections['extra_boleta']['show']) {
    $this->_sections['extra_boleta']['total'] = $this->_sections['extra_boleta']['loop'];
    if ($this->_sections['extra_boleta']['total'] == 0)
        $this->_sections['extra_boleta']['show'] = false;
} else
    $this->_sections['extra_boleta']['total'] = 0;
if ($this->_sections['extra_boleta']['show']):

            for ($this->_sections['extra_boleta']['index'] = $this->_sections['extra_boleta']['start'], $this->_sections['extra_boleta']['iteration'] = 1;
                 $this->_sections['extra_boleta']['iteration'] <= $this->_sections['extra_boleta']['total'];
                 $this->_sections['extra_boleta']['index'] += $this->_sections['extra_boleta']['step'], $this->_sections['extra_boleta']['iteration']++):
$this->_sections['extra_boleta']['rownum'] = $this->_sections['extra_boleta']['iteration'];
$this->_sections['extra_boleta']['index_prev'] = $this->_sections['extra_boleta']['index'] - $this->_sections['extra_boleta']['step'];
$this->_sections['extra_boleta']['index_next'] = $this->_sections['extra_boleta']['index'] + $this->_sections['extra_boleta']['step'];
$this->_sections['extra_boleta']['first']      = ($this->_sections['extra_boleta']['iteration'] == 1);
$this->_sections['extra_boleta']['last']       = ($this->_sections['extra_boleta']['iteration'] == $this->_sections['extra_boleta']['total']);
?>	
		<td class="grilla-tab-fila-campo" align='center' ><?php echo $this->_tpl_vars['arrRegistros_tct'][$this->_sections['extra_boleta']['index']]['cc']; ?>
</td>
	<?php endfor; endif; ?>
</tr>

<tr>
	<td colspan='<?php echo $this->_tpl_vars['total_meses']+1; ?>
' class="grilla-tab-fila-titulo">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>
</table>
</div>


