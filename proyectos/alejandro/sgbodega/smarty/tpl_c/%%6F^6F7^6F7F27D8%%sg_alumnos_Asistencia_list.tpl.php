<?php /* Smarty version 2.6.18, created on 2019-06-18 19:21:53
         compiled from sg_alumnos_Asistencia_list.tpl */ ?>
<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
    	<td class="grilla-tab-fila-titulo" align="left">Alumno</td>
    	<td class="grilla-tab-fila-titulo" colspan="4" align="left" style="font-weight: bold; width: 80% !important"><?php echo $this->_tpl_vars['nombre_alumno']; ?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align="left">Curso</td>
        <td class="grilla-tab-fila-titulo" colspan="4" align="left" style="font-weight: bold"><?php echo $this->_tpl_vars['nombre_curso']; ?>
</td>
    </tr>
        <?php unset($this->_sections['registros1']);
$this->_sections['registros1']['name'] = 'registros1';
$this->_sections['registros1']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros1']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['registros1']['show'] = true;
$this->_sections['registros1']['max'] = $this->_sections['registros1']['loop'];
$this->_sections['registros1']['step'] = 1;
$this->_sections['registros1']['start'] = $this->_sections['registros1']['step'] > 0 ? 0 : $this->_sections['registros1']['loop']-1;
if ($this->_sections['registros1']['show']) {
    $this->_sections['registros1']['total'] = $this->_sections['registros1']['loop'];
    if ($this->_sections['registros1']['total'] == 0)
        $this->_sections['registros1']['show'] = false;
} else
    $this->_sections['registros1']['total'] = 0;
if ($this->_sections['registros1']['show']):

            for ($this->_sections['registros1']['index'] = $this->_sections['registros1']['start'], $this->_sections['registros1']['iteration'] = 1;
                 $this->_sections['registros1']['iteration'] <= $this->_sections['registros1']['total'];
                 $this->_sections['registros1']['index'] += $this->_sections['registros1']['step'], $this->_sections['registros1']['iteration']++):
$this->_sections['registros1']['rownum'] = $this->_sections['registros1']['iteration'];
$this->_sections['registros1']['index_prev'] = $this->_sections['registros1']['index'] - $this->_sections['registros1']['step'];
$this->_sections['registros1']['index_next'] = $this->_sections['registros1']['index'] + $this->_sections['registros1']['step'];
$this->_sections['registros1']['first']      = ($this->_sections['registros1']['iteration'] == 1);
$this->_sections['registros1']['last']       = ($this->_sections['registros1']['iteration'] == $this->_sections['registros1']['total']);
?>
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <?php if (( ( $this->_tpl_vars['arrRegistros1'][$this->_sections['registros1']['index']]['FechaInasistencia'] == 'Inasistencias' ) || ( $this->_tpl_vars['arrRegistros1'][$this->_sections['registros1']['index']]['FechaInasistencia'] == 'Atrasos' ) )): ?>
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        
                    </td>
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        <?php echo $this->_tpl_vars['arrRegistros1'][$this->_sections['registros1']['index']]['FechaInasistencia']; ?>

                    </td>
                <?php else: ?>
                    <td class='grilla-tab-fila-campo' align='left'>
                        <?php echo $this->_tpl_vars['arrRegistros1'][$this->_sections['registros1']['index']]['item']; ?>

                    </td>
                    <td class='grilla-tab-fila-campo' align='left'>
                        <?php echo $this->_tpl_vars['arrRegistros1'][$this->_sections['registros1']['index']]['FechaInasistencia']; ?>

                    </td>
                    <td class='grilla-tab-fila-campo' align='left'>
                        <?php echo $this->_tpl_vars['arrRegistros1'][$this->_sections['registros1']['index']]['Observacion']; ?>

                    </td>
                <?php endif; ?>
           
            </tr>
        <?php endfor; endif; ?>
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    
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
            <?php if (( ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaInasistencia'] == 'Inasistencias' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaInasistencia'] == 'Atrasos' ) )): ?>
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        
                    </td>
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaInasistencia']; ?>

                    </td>
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        Observaci&oacute;n
                    </td>
                <?php else: ?>
                    <td class='grilla-tab-fila-campo' align='left'>
                        <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['item']; ?>

                    </td>
                    <td class='grilla-tab-fila-campo' align='left'>
                        <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaInasistencia']; ?>

                    </td>
                    <td class='grilla-tab-fila-campo' align='left'>
                        <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['Observacion']; ?>

                    </td>
                <?php endif; ?>
           
            </tr>
    <?php endfor; endif; ?>
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
    
        </td>
    </tr>
    </table>
</div>