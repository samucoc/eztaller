<?php /* Smarty version 2.6.18, created on 2016-11-28 21:49:51
         compiled from sg_informes_autorizados_no_matriculados_list.tpl */ ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo" colspan="16" align='center' style="font-size: 8px !important; border: 0px">REGISTRO ALUMNOS AUTORIZADOS NO MATRICULADOS PERIODO <?php echo $this->_tpl_vars['anio']; ?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Numero de Orden</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Identificacion del alumno</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Curso</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Nombre de los Padres y/o Apoderados</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Telefono Apoderado</td>
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
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['alumno']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['apoderado']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['TelefonoParticularApoderado']; ?>
</td>
            </tr>
    <?php endfor; endif; ?>
<tr>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Total</td>
        <td colspan='16' class="grilla-tab-fila-campo">
            <?php echo $this->_tpl_vars['total_alumnos']; ?>

        </td>
    </tr>
<tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
             <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divresultado');" width="32"></a>
    
        </td>
    </tr>
</table>
</div>