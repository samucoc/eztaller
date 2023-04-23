<?php /* Smarty version 2.6.18, created on 2017-06-13 21:12:01
         compiled from sg_alumnos_notas_list.tpl */ ?>
<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
    	<td class="grilla-tab-fila-titulo" align="left">Alumno</td>
    	<td class="grilla-tab-fila-titulo" colspan="<?php echo $this->_tpl_vars['notas_ingresadas']+1; ?>
" align="left" style="font-weight: bold"><?php echo $this->_tpl_vars['nombre_alumno']; ?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align="left">Curso</td>
        <td class="grilla-tab-fila-titulo" colspan="<?php echo $this->_tpl_vars['notas_ingresadas']+1; ?>
" align="left" style="font-weight: bold"><?php echo $this->_tpl_vars['nombre_curso']; ?>
</td>
    </tr>
       	<tr>
    	<td class="grilla-tab-fila-titulo" align="left">Semestre</td>
    	<td class="grilla-tab-fila-titulo" colspan="<?php echo $this->_tpl_vars['notas_ingresadas']+1; ?>
"  align="center" style="font-weight: bold"><?php echo $this->_tpl_vars['nombre_semestre']; ?>
</td>
    </tr>
    
    <tr>
        <td class="grilla-tab-fila-titulo"  align="left">Asignatura</td>
        <?php unset($this->_sections['cu']);
$this->_sections['cu']['name'] = 'cu';
$this->_sections['cu']['start'] = (int)0;
$this->_sections['cu']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['cu']['loop'] = is_array($_loop=$this->_tpl_vars['notas_ingresadas']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['cu']['show'] = true;
$this->_sections['cu']['max'] = $this->_sections['cu']['loop'];
if ($this->_sections['cu']['start'] < 0)
    $this->_sections['cu']['start'] = max($this->_sections['cu']['step'] > 0 ? 0 : -1, $this->_sections['cu']['loop'] + $this->_sections['cu']['start']);
else
    $this->_sections['cu']['start'] = min($this->_sections['cu']['start'], $this->_sections['cu']['step'] > 0 ? $this->_sections['cu']['loop'] : $this->_sections['cu']['loop']-1);
if ($this->_sections['cu']['show']) {
    $this->_sections['cu']['total'] = min(ceil(($this->_sections['cu']['step'] > 0 ? $this->_sections['cu']['loop'] - $this->_sections['cu']['start'] : $this->_sections['cu']['start']+1)/abs($this->_sections['cu']['step'])), $this->_sections['cu']['max']);
    if ($this->_sections['cu']['total'] == 0)
        $this->_sections['cu']['show'] = false;
} else
    $this->_sections['cu']['total'] = 0;
if ($this->_sections['cu']['show']):

            for ($this->_sections['cu']['index'] = $this->_sections['cu']['start'], $this->_sections['cu']['iteration'] = 1;
                 $this->_sections['cu']['iteration'] <= $this->_sections['cu']['total'];
                 $this->_sections['cu']['index'] += $this->_sections['cu']['step'], $this->_sections['cu']['iteration']++):
$this->_sections['cu']['rownum'] = $this->_sections['cu']['iteration'];
$this->_sections['cu']['index_prev'] = $this->_sections['cu']['index'] - $this->_sections['cu']['step'];
$this->_sections['cu']['index_next'] = $this->_sections['cu']['index'] + $this->_sections['cu']['step'];
$this->_sections['cu']['first']      = ($this->_sections['cu']['iteration'] == 1);
$this->_sections['cu']['last']       = ($this->_sections['cu']['iteration'] == $this->_sections['cu']['total']);
?>
		   	<td class="grilla-tab-fila-titulo" align="center">
				N-<?php echo $this->_sections['cu']['index']+1; ?>

            </td>
        <?php endfor; endif; ?>
        <td class="grilla-tab-fila-titulo" align="center">
				Promedio
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
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre_asignatura']; ?>

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
                <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['codigo_asignatura'] == $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['codigo_asignatura']): ?>
                        <td class='grilla-tab-fila-campo' align='center' >
                        	<?php if ($this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['nota'] < 4): ?>
                            <div style="color:#FF0000">                
                                <?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['nota']; ?>

                            </div>
                            <?php else: ?>
                                <?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['nota']; ?>

                            <?php endif; ?>
                        </td>
                <?php endif; ?>
            <?php endfor; endif; ?>
        </tr>
    <?php endfor; endif; ?>
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
    
        </td>
    </tr>
    </table>
</div>