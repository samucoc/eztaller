<?php /* Smarty version 2.6.18, created on 2019-06-11 20:00:09
         compiled from sg_consultas_compromisos_bitacora_list.tpl */ ?>
<div id="pivot">										
<table id='tabla_0' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-campo-pequenio" align="left">
            <table class="grilla-tab" id="tabla_1" border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td class="grilla-tab-fila-titulo" align='center'>Apoderado</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Direccion Apoderado</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Telefono Apoderado</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Email</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Alumno</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Fecha Compromiso</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Descripcion Compromiso</td>
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
                            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['apoderado']; ?>
</td>
                            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['direccion_apoderado']; ?>
</td>
                            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['telefono_apoderado']; ?>
</td>
                            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['email']; ?>
</td>
                            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['alumno']; ?>
</td>
                            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_compromiso']; ?>
</td>
                            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['descripcion_compromiso']; ?>
</td>
                        </tr>
                <?php endfor; endif; ?>
            <tr>
            	<td colspan='16' class="grilla-tab-fila-titulo">
                    <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
                    <a href="#" style="cursor: hand;" id="btnExport" name="btnExport" onclick="tableToExcel('tabla_0', 'Listado Becados')"><img src="../images/basicos/imprimir.png" border=0 title="Exportar Excel" width="32"></a>
                </td>
            </tr>
            </table>
        </td>
    </tr>
</table>
</div>