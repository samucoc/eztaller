<?php /* Smarty version 2.6.18, created on 2017-09-27 20:32:02
         compiled from sg_informe_cursos_pie_list.tpl */ ?>
<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
         <td class='grilla-tab-fila-titulo-pequenio' align='left' colspan="10">
               Apoyo a la Diversidad (Informaci&oacute;n reservada)
            </td>
    </tr>
    <tr>
         <td class='grilla-tab-fila-titulo-pequenio' align='left'>
               Curso:
            </td>
         <td class='grilla-tab-fila-campo-pequenio' align='left' colspan="10">
                <?php echo $this->_tpl_vars['nombre_curso']; ?>

            </td>
    </tr>
    <tr>
            <td class='grilla-tab-fila-titulo-pequenio' align='left'>
                Profesor:
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left' colspan="10">
                <?php echo $this->_tpl_vars['nombre_profe']; ?>

            </td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nro Lista</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Rut Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nombre Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Pie</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Observacion</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">E. Dif.</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Observacion</td>
        
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
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_lista']; ?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre_alumno']; ?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['PIE'] == '1'): ?>
                    SI
                <?php else: ?>
                     
                <?php endif; ?>
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['TextPIE']; ?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['EvaluacionDiferenciada'] == '1'): ?>
                   SI
                <?php else: ?>
                     
                <?php endif; ?>
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['TextEvaluacionDiferenciada']; ?>

            </td>
            
        </tr>
    <?php endfor; endif; ?>

    </table>
</div>