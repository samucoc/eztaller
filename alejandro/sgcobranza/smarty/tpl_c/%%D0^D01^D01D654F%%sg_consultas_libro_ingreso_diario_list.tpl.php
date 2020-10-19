<?php /* Smarty version 2.6.18, created on 2018-12-21 19:10:05
         compiled from sg_consultas_libro_ingreso_diario_list.tpl */ ?>
<div id="pivot">										

<table id="tabla_00" class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo" align='center' colspan="16">Libro de ingresos diarios</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align='center'>Periodo</td>
        <td class="grilla-tab-fila-titulo" align='center' id="periodo_td" name="periodo_td"></td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align='center'>Dia</td>
        <td class="grilla-tab-fila-titulo" align='center'>Desde</td>
        <td class="grilla-tab-fila-titulo" align='center'>Hasta</td>
        <td class="grilla-tab-fila-titulo" align='center'>Matricula</td>
        <td class="grilla-tab-fila-titulo" align='center'>Escolaridad</td>
        <td class="grilla-tab-fila-titulo" align='center'>Donaciones</td>
        <td class="grilla-tab-fila-titulo" align='center'>Exenciones</td>
        <td class="grilla-tab-fila-titulo" align='center'>Intereses</td>
        <td class="grilla-tab-fila-titulo" align='center'>Total</td>
        <td class="grilla-tab-fila-titulo" align='center'>Observaciones</td>
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
                <td class="grilla-tab-fila-campo" align='right'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['dia']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['minimo']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['maximo']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='right'>0</td>
                <td class="grilla-tab-fila-campo" align='right'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['valor']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='right'>0</td>
                <td class="grilla-tab-fila-campo" align='right'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['exenciones']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='right'>0</td>
                <td class="grilla-tab-fila-campo" align='right'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['valor']; ?>
</td>
                <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nulas']; ?>
</td>
            </tr>
    <?php endfor; endif; ?>
</table>
</div>