<?php /* Smarty version 2.6.18, created on 2016-11-28 21:26:46
         compiled from sg_alumnos_matricula_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_alumnos_matricula_list.tpl', 77, false),)), $this); ?>
<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
         <td class='grilla-tab-fila-titulo' align='left'>
               Curso:
            </td>
         <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $this->_tpl_vars['nombre_curso']; ?>

            </td>
            <td class='grilla-tab-fila-titulo' align='left'>
                Profesor:
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $this->_tpl_vars['nombre_profe']; ?>

            </td>
    </tr>
    <tr>
            <td class='grilla-tab-fila-titulo' align='left'>
                Total de Alumnos:
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $this->_tpl_vars['total']; ?>

            </td>
    </tr>
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
            <td class='grilla-tab-fila-titulo' align='left' style="width: 16%">
                Matriculados:
            </td>
            <td class='grilla-tab-fila-campo' align='left' style="width: 16%">
                <?php echo $this->_tpl_vars['matriculados']; ?>

            </td>
            <td class='grilla-tab-fila-titulo' align='left' style="width: 16%">
                No Matriculados:
            </td>
            <td class='grilla-tab-fila-campo' align='left' style="width: 16%">
                <?php echo $this->_tpl_vars['no_matriculados']; ?>

            </td>
            <td class='grilla-tab-fila-titulo' align='left' style="width: 16%">
                Retirados:
            </td>
            <td class='grilla-tab-fila-campo' align='left' style="width: 16%">
                <?php echo $this->_tpl_vars['retirados']; ?>

            </td>
    </tr>
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo" align="center">Nro Lista</td>
        <td class="grilla-tab-fila-titulo" align="center">Rut Alumno</td>
        <td class="grilla-tab-fila-titulo" align="center">Nombre Alumno</td>
        <td class="grilla-tab-fila-titulo" align="center">Sexo</td>
        <td class="grilla-tab-fila-titulo" align="center">Fecha Nacimiento</td>
        <td class="grilla-tab-fila-titulo" align="center">Matriculado</td>
        <td class="grilla-tab-fila-titulo" align="center">Eliminar Matricular</td>
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
            <td class='grilla-tab-fila-campo' align='center'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_lista']; ?>

            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>

            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre_alumno']; ?>

            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['sexo_alumno'] == 0): ?>
					Masculino
				<?php else: ?>
					Femenino
				<?php endif; ?>
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                <?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_nacimiento'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>

            </td>
            <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['matriculado'] == '1'): ?> 
                <td class='grilla-tab-fila-campo' align='center'> 
                    <img src='../images/tick.png' width='24' title='Ver Cartola' onclick="xajax_Enviar(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>
','<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['matriculado']; ?>
')"/>
                </td>
                <td class='grilla-tab-fila-campo' align='center'>
                    <img src='../images/stop.png' width='24' title='Eliminar Matricular' onclick="xajax_VolverMatricular(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>
')"/>
                </td>
            <?php else: ?>
                <td class='grilla-tab-fila-campo' align='center'>
                    <img src='../images/stop.png' width='24' 
                        <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['matriculado'] == '2'): ?>
                            title='Retirado'
                        <?php else: ?>
                             title='No Matriculado'
                        <?php endif; ?>
                     onclick="xajax_Enviar(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>
','<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['matriculado']; ?>
')"/>
                    <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['condicional'] == '1'): ?>
                        ?
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['matriculado'] == '2'): ?>
                        !
                    <?php endif; ?>
                </td>
                <td class='grilla-tab-fila-campo' align='center'>
                        ----
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