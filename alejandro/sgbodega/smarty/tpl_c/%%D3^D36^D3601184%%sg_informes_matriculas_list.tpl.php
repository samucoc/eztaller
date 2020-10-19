<?php /* Smarty version 2.6.18, created on 2017-05-16 21:38:21
         compiled from sg_informes_matriculas_list.tpl */ ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo" colspan="16" align='left' style="font-size: 8px !important; border: 0px"><?php echo $this->_tpl_vars['nombre']; ?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" colspan="16" align='left' style="font-size: 8px !important; border: 0px"><?php echo $this->_tpl_vars['rut']; ?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" colspan="16" align='left' style="font-size: 8px !important; border: 0px"><?php echo $this->_tpl_vars['direccion']; ?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" colspan="16" align='left' style="font-size: 8px !important; border: 0px"><?php echo $this->_tpl_vars['ciudad']; ?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" colspan="16" align='center' style="font-size: 8px !important; border: 0px">REGISTRO MATRICULA DE ALUMNOS PERIODO <?php echo $this->_tpl_vars['anio']; ?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Numero de Matricula</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">R.U.N.</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Identificacion del alumno</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Sexo</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Fecha de Nacimiento</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important; width:5%" >Curso</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Local Escolar</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Fecha de matricula</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Domicilio del alumno</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Nombre de los Padres y/o Apoderados</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Telefono Apoderado</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Fecha Retiro</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Motivo Retiro - Observacion</td>
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
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important; width:5%"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NroMatricula']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important; width:5%"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NumeroRutAlumno']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['alumno']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['SexoAlumno']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaNacimiento']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='center' style="font-size: 8px !important"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important">Principal</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['Fecha']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['DireccionParticularAlumno']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['apoderado']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['TelefonoParticularApoderado']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important">
                    <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaRetiro'] == '00/00/0000'): ?>
                    <?php else: ?>
                        <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaRetiro']; ?>

                    <?php endif; ?>
                </td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['MotivoRetiro']; ?>
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