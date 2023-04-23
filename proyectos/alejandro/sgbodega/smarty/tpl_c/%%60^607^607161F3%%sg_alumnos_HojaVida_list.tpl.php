<?php /* Smarty version 2.6.18, created on 2017-06-13 21:15:13
         compiled from sg_alumnos_HojaVida_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_alumnos_HojaVida_list.tpl', 32, false),)), $this); ?>
<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
        <td class="grilla-tab-fila-titulo" align="left">Alumno</td>
        <td class="grilla-tab-fila-titulo" colspan="4" align="left" style="font-weight: bold"><?php echo $this->_tpl_vars['nombre_alumno']; ?>
</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align="left">Curso</td>
        <td class="grilla-tab-fila-titulo" colspan="4" align="left" style="font-weight: bold"><?php echo $this->_tpl_vars['nombre_curso']; ?>
</td>
    </tr>
        <tr >
            <td class='grilla-tab-fila-campo' align='center'>
                Fecha
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Asignatura
            </td>
            <td class="grilla-tab-fila-campo" align="center">
                Tipo Anotaci&oacute;n
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Motivo
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Descripci&oacute;n
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
                <?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaHojaVida'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>

            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ramo']; ?>

            </td>
            <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre'] == 'Positiva'): ?>
                <td class="grilla-tab-fila-campo" align="center">
                    <a href="#"><img src='../images/cara_verde.jpg' title='Positiva' width="24" /></a>
                </td>
            <?php else: ?>  
                <td class="grilla-tab-fila-campo" align="center">
                    <a href="#"><img src='../images/cara_roja.jpg' title='Negativa' width="24" /></a>
                </td>
            <?php endif; ?>
            <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['DescripcionMotivo']; ?>

            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['DescripcionHojaVida']; ?>

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