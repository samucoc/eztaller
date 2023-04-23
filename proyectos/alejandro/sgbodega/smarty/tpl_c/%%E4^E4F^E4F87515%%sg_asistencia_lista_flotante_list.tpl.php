<?php /* Smarty version 2.6.18, created on 2017-03-31 20:52:09
         compiled from sg_asistencia_lista_flotante_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_asistencia_lista_flotante_list.tpl', 69, false),)), $this); ?>
<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="2"></td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="4">Lista Flotante Para Asistencia</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="2"></td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="2">Fecha</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center" colspan="2"><?php echo $this->_tpl_vars['nombre_curso']; ?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nro Lista</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nro Matricula</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Ingreso</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Retiro</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Rut Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nombre Alumno</td>
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
            <td class='grilla-tab-fila-campo-pequenio' align='center'
                <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['sexo_alumno'] == '0' )): ?> 
                    style="color: blue !important;"
                <?php else: ?>
                    style="color: red !important;"
                <?php endif; ?>
            >
                <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_lista'] == '0'): ?>

                <?php else: ?>
                    <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_retiro'] == '0000-00-00'): ?>
                        <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_lista']; ?>

                    <?php else: ?>
                        <strike>
                        <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_lista']; ?>

                        </strike>
                    <?php endif; ?>
                <?php endif; ?>
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'
                <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['sexo_alumno'] == '0' )): ?> 
                    style="color: blue !important;"
                <?php else: ?>
                    style="color: red !important;"
                <?php endif; ?>
            >
                <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_matricula'] == '0'): ?>

                <?php else: ?>
                    <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_retiro'] == '0000-00-00'): ?>
                        <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_matricula']; ?>

                    <?php else: ?>
                        <strike>
                            <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_matricula']; ?>

                        </strike>
                    <?php endif; ?>                    
                <?php endif; ?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'
                <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['sexo_alumno'] == '0' )): ?> 
                    style="color: blue !important;"
                <?php else: ?>
                    style="color: red !important;"
                <?php endif; ?>
            >
                    <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_retiro'] == '0000-00-00'): ?>
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_ingreso'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>

                    <?php else: ?>
                        <strike>
                            <?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_ingreso'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>

                        </strike>
                    <?php endif; ?>  
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_retiro'] == '0000-00-00'): ?>

                <?php else: ?>
                        <strike>
                            <?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_retiro'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>

                        </strike>
                <?php endif; ?>
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'
                <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['sexo_alumno'] == '0' )): ?> 
                    style="color: blue !important;"
                <?php else: ?>
                    style="color: red !important;"
                <?php endif; ?>
            >
                 <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_retiro'] == '0000-00-00'): ?>
                        <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>

                    <?php else: ?>
                        <strike>
                            <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>

                        </strike>
                    <?php endif; ?>  


            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'
                <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['sexo_alumno'] == '0' )): ?> 
                    style="color: blue !important;"
                <?php else: ?>
                    style="color: red !important;"
                <?php endif; ?>
            >
                 <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_retiro'] == '0000-00-00'): ?>
                         <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre_alumno']; ?>

                    <?php else: ?>
                        <strike>
                             <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre_alumno']; ?>

                        </strike>
                    <?php endif; ?>  
               
            </td>
        </tr>
    <?php endfor; endif; ?>
        <tr>
            <td class='grilla-tab-fila-campo-pequenio' align='left' colspan="2"></td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>Hombres</td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'><?php echo $this->_tpl_vars['hombre']; ?>
</td>
        </tr>
        <tr>
            <td class='grilla-tab-fila-campo-pequenio' align='left' colspan="2"></td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>Mujeres</td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'><?php echo $this->_tpl_vars['mujer']; ?>
</td>
        </tr>
        <tr>
            <td class='grilla-tab-fila-campo-pequenio' align='left' colspan="2"></td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>Total</td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'><?php echo $this->_tpl_vars['total']; ?>
</td>
        </tr>

    </table>
</div>