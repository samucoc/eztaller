<?php /* Smarty version 2.6.18, created on 2018-04-03 20:38:05
         compiled from sg_informe_resumen_matriculas_list_2.tpl */ ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important;  font-weight: bold" colspan="6">INFORME RESUMEN MATRICULAS VIGENTES</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important">Nombre Curso</td>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important">Capacidad</td>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important">Alumnos Antiguos</td>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important">Alumnos Nuevos</td>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important">Cantidad de Alumnos</td>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important">Vacantes</td>
    </tr>
</table>
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%" style="overflow: scroll; height: 600px !important;">

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
            <tr <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Totales Matricula Antiguos' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Totales Matricula Nuevos' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Total General' )): ?> 
                    style="background-color: #1B4978 !important;"
                <?php else: ?> 
                    onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'
                <?php endif; ?>>
                <td class="grilla-tab-fila-campo" align='left' style="width: 10% !important;
                     <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Totales Matricula Antiguos' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Totales Matricula Nuevos' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Total General' )): ?> 
                     color: white;
                     <?php endif; ?>
                "><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 10% !important;
                     <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Totales Matricula Antiguos' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Totales Matricula Nuevos' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Total General' )): ?> 
                     color: white;
                     <?php endif; ?>
                "><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['Capacidad']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 10% !important;
                    <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Totales Matricula Antiguos' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Totales Matricula Nuevos' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Total General' )): ?> 
                     color: white;
                     <?php endif; ?>"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['anio_actual']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 10% !important;
                    <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Totales Matricula Antiguos' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Totales Matricula Nuevos' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Total General' )): ?> 
                     color: white;
                    <?php endif; ?>"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['anio_siguiente']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 10% !important;
                    <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Totales Matricula Antiguos' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Totales Matricula Nuevos' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Total General' )): ?> 
                     color: white;
                    <?php endif; ?>"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cantidad_alumnos']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 10% !important;
                    <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Totales Matricula Antiguos' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Totales Matricula Nuevos' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso'] == 'Total General' )): ?> 
                     color: white;
                    <?php endif; ?>"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['disponible']; ?>
</td>
            </tr>
    <?php endfor; endif; ?>
<tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
             <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divresultado');" width="32"></a>
    
        </td>
    </tr>
</table>
</div>