<?php /* Smarty version 2.6.18, created on 2017-05-30 21:06:08
         compiled from sg_informe_consulta_calendario_planificacion_list.tpl */ ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td colspan="20" class="grilla-tab-fila-titulo" align='center'>
            Consulta y Seguimiento de Evaluaciones
        </td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align='center'>Curso</td>
        <td class="grilla-tab-fila-titulo" align='center'>Asignatura</td>
        <td class="grilla-tab-fila-titulo" align='center'>Profesor</td>
        <td class="grilla-tab-fila-titulo" align='center'>Nota</td>
        <td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
        <td class="grilla-tab-fila-titulo" align='center'>Descripci&oacute;n</td>
        <td class="grilla-tab-fila-titulo" align='center'>Tipo</td>
        <td class="grilla-tab-fila-titulo" align='center'>I</td>
        <td class="grilla-tab-fila-titulo" align='center'>S</td>
        <td class="grilla-tab-fila-titulo" align='center'>B</td>
        <td class="grilla-tab-fila-titulo" align='center'>MB</td>
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
                <td class="grilla-tab-fila-campo" align='left' ><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' ><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['Descripcion']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['profesor']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NumeroNota']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaPrueba']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['DescripcionPrueba']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['DescripcionPlazo']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 40px; color: white; background-color: #F01614"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['insuficiente']; ?>
 %</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 40px; color: black; background-color: orange"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['suficiente']; ?>
 %</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 40px; color: black; background-color: yellow"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['bueno']; ?>
 %</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 40px; color: black; background-color: #30C805"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['muy_bueno']; ?>
 %</td>
            </tr>
    <?php endfor; endif; ?>
<tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
             <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
    
        </td>
    </tr>
</table>
</div>