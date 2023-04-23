<?php /* Smarty version 2.6.18, created on 2018-10-23 20:13:07
         compiled from sg_informe_asistencia_por_alumnos_list.tpl */ ?>
<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	  <tr>
        <td colspan='16' class="grilla-tab-fila-titulo" align="center">
            Inasistencias y Atrasos por Alumno
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
            <?php if (( ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaInasistencia'] == 'Inasistencias' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaInasistencia'] == 'Atrasos' ) )): ?>
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold; width: 15%" >
                        <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['item'] == 'Total Inasistencias' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['item'] == 'Total Atrasos' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['item'] == 'Total Dias Trabajados Nominal' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['item'] == '% Asistencia Nominal' )): ?>
                            <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['item']; ?>

                        <?php else: ?>
                            <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaInasistencia'] == 'Atrasos' || $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaInasistencia'] == 'Inasistencias'): ?>

                            <?php else: ?>
                                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['item']; ?>

                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaInasistencia']; ?>

                    </td>
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        Observaci&oacute;n
                    </td>
                <?php else: ?>
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['item'] == 'Total Inasistencias' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['item'] == 'Total Atrasos' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['item'] == 'Total Dias Trabajados Nominal' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['item'] == '% Asistencia Nominal' )): ?>
                            <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['item']; ?>

                        <?php else: ?>
                            <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaInasistencia'] == 'Atrasos' || $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaInasistencia'] == 'Inasistencias'): ?>

                            <?php else: ?>
                                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['item']; ?>

                            <?php endif; ?>
                        <?php endif; ?>
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
            <a href="#" style="cursor: hand;"><img src="../images/basicos/email2.png" border=0 title="Enviar Correo Apoderado" onclick="xajax_EnivarPDF(xajax.getFormValues('Form1'));" width="32"></a>
        </td>
    </tr>
    </table>
</div>