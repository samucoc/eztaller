<?php /* Smarty version 2.6.18, created on 2017-08-23 20:09:47
         compiled from sg_alumnos_Apoderado_list.tpl */ ?>
<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
    	<td class="grilla-tab-fila-titulo" align="left">Alumno</td>
    	<td class="grilla-tab-fila-titulo" colspan="5" align="left" style="font-weight: bold"><?php echo $this->_tpl_vars['nombre_alumno']; ?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align="left">Curso</td>
        <td class="grilla-tab-fila-titulo" colspan="5" align="left" style="font-weight: bold"><?php echo $this->_tpl_vars['nombre_curso']; ?>
</td>
    </tr>
    <tr >
            <td class='grilla-tab-fila-campo' align='center'>
                Nombre Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Tipo Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Direccion Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Tel&eacute;fono Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                M&oacute;vil Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Correo Apoderado
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
                <a href="#" style="cursor: hand;" onclick="xajax_TraerApoderado(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['RutApoderado']; ?>
', '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['RutAlumno']; ?>
');" ><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre_apoderado']; ?>
</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" style="cursor: hand;" onclick="xajax_TraerApoderado(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['RutApoderado']; ?>
', '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['RutAlumno']; ?>
');" ><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo_apoderado']; ?>
</a>

                
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" style="cursor: hand;" onclick="xajax_TraerApoderado(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['RutApoderado']; ?>
', '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['RutAlumno']; ?>
');" ><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['direcc_apoderado']; ?>
</a>
                
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" style="cursor: hand;" onclick="xajax_TraerApoderado(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['RutApoderado']; ?>
', '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['RutAlumno']; ?>
');" ><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['telefono_apoderado']; ?>
</a>
                
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" style="cursor: hand;" onclick="xajax_TraerApoderado(xajax.getFormValues('Form1'), '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['RutApoderado']; ?>
', '<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['RutAlumno']; ?>
');" ><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['movil_apoderado']; ?>
</a>
                
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="mailto:<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['correo_apoderado']; ?>
"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['correo_apoderado']; ?>
</a>
            </td>
	    </tr>
    <?php endfor; endif; ?>
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
    
        </td>
    </tr>
    </table>
</div>