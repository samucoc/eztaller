<?php /* Smarty version 2.6.18, created on 2017-10-02 10:38:42
         compiled from sg_notas_actualizar_cm_list.tpl */ ?>
<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" width="5%">Nro Lista</td> 
        <td class="grilla-tab-fila-titulo-pequenio"  width="50%" align="center">Nombre Alumno</td>
        <td width="100" class="grilla-tab-fila-titulo-pequenio" align="center">Nota</td> 
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
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_lista_alumno']; ?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre_alumno']; ?>

       			<input type="hidden" name="seleccion[]" value="<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['asignatura']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['anio']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['curso']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['semestre']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['prueba']; ?>
" />	
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
                <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno'] == $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['rut_alumno'] )): ?>
                    <td class='grilla-tab-fila-campo-pequenio' align='center' >
                        <input type="text" name="nota_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['asignatura']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['anio']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['curso']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['semestre']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['prueba']; ?>
" onKeyPress="return SoloNumeros(this, event, 1)" size="5"   <?php if ($this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['nota'] == ''): ?>
                                                                    value=""
                                                                <?php else: ?>
                                                                    value="<?php echo $this->_tpl_vars['arrRegistrosDetalle'][$this->_sections['registrosDetalle']['index']]['nota']; ?>
"
                                                                <?php endif; ?>
                        onchange="xajax_ReconocerNro(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['asignatura']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['anio']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['curso']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['semestre']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['prueba']; ?>
')" />
                    </td>
                <?php endif; ?>
            <?php endfor; endif; ?>
            
        </tr>
    <?php endfor; endif; ?>
    </table>
</div>