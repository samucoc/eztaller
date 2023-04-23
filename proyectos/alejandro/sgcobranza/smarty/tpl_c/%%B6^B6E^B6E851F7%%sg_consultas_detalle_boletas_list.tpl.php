<?php /* Smarty version 2.6.18, created on 2019-03-13 17:12:18
         compiled from sg_consultas_detalle_boletas_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'sg_consultas_detalle_boletas_list.tpl', 30, false),)), $this); ?>
<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" colspan="17">Detalle de Boletas</td>
    </tr>
    <tr> 
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Numero Rut Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">DV Rut Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Numero Boleta</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Fecha Boleta</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Valor Pagado</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Estado Boleta</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Periodo Boleta</td>
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
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NumeroRutAlumno']; ?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['dv']; ?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NumeroBoleta']; ?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaBoleta']; ?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='right'>
                <?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ValorPagado'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['EstadoBoleta']; ?>

            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['Periodo']; ?>

            </td>
	    </tr>
    <?php endfor; endif; ?>

    </table>
</div>