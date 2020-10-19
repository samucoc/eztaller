<?php /* Smarty version 2.6.18, created on 2017-07-12 19:28:55
         compiled from sg_informe_relacion_apoderados_alumnos_list.tpl */ ?>
<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr >
            <td class='grilla-tab-fila-campo' align='center'>
                Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Telefono Particular Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Telefono Movil Apoderado
            </td>
           <td class='grilla-tab-fila-campo' align='center'>
                Alumno
            </td>
           <td class='grilla-tab-fila-campo' align='center'>
                Nombre Curso
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
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['apoderado']; ?>

            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['TelefonoParticularApoderado']; ?>

            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['TelefonoMovilApoderado']; ?>

            </td>
           <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['alumno']; ?>

            </td>
           <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso']; ?>

            </td>
           
	    </tr>
    <?php endfor; endif; ?>
    <tr>
        <td  class="grilla-tab-fila-titulo">
            Cantidad Apoderados
        </td>
        <td colspan="16" class="grilla-tab-fila-titulo">
            <?php echo $this->_tpl_vars['apoderados']; ?>

        </td>
    </tr>
    <tr>
        <td  class="grilla-tab-fila-titulo">
            Cantidad Alumnos
        </td>
        <td colspan="16" class="grilla-tab-fila-titulo">
            <?php echo $this->_tpl_vars['alumnos']; ?>

        </td>
    </tr>
    </table>
</div>