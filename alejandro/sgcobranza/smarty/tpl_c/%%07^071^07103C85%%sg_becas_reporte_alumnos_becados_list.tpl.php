<?php /* Smarty version 2.6.18, created on 2017-12-14 11:33:35
         compiled from sg_becas_reporte_alumnos_becados_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'sg_becas_reporte_alumnos_becados_list.tpl', 36, false),)), $this); ?>
<div id="pivot">										
<table id='tabla_0' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-campo-pequenio" align="left">
            <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td class="grilla-tab-fila-campo-pequenio" align="left">
                    <h2><?php echo $this->_tpl_vars['nombre_establecimiento']; ?>
</h2>
                    <p><?php echo $this->_tpl_vars['direccion_establecimiento']; ?>
</p>
                    <p>R.D.B : <?php echo $this->_tpl_vars['rbd_establecimiento']; ?>
</p>
                </td>
            </tr>
            </table>
            <table class="grilla-tab" id="tabla_1" border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td class="grilla-tab-fila-titulo" align='center'>Rut Alumno</td>
                    <td class="grilla-tab-fila-titulo" align='center'>DV Alumno</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Apellido Paterno Alumno</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Apellido Materno Alumno</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Nombres Alumno</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Curso</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Nombre Tipo Beca</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Arancel Mensual</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Valor Beca</td>
                    <td class="grilla-tab-fila-titulo" align='center'>Aporte Apoderado</td>
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
                            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NumeroRutAlumno']; ?>
</td>
                            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['DVAlumno']; ?>
</td>
                            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['PaternoAlumno']; ?>
</td>
                            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['MaternoAlumno']; ?>
</td>
                            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombresAlumno']; ?>
</td>
                            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreCurso']; ?>
</td>
                            <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreTipoBeca']; ?>
</td>
                            <td class="grilla-tab-fila-campo" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['valor_mensual'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
                            <td class="grilla-tab-fila-campo" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['valor_beca'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
                            <td class="grilla-tab-fila-campo" align='right'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ap_apoderado'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</td>
                            
                        </tr>
                <?php endfor; endif; ?>
            <tr> 
                    <td class="grilla-tab-fila-campo" align='left' colspan="8">Sum. Valor Beca</td>
                    <td class="grilla-tab-fila-campo" align='right'><?php echo $this->_tpl_vars['sum_valor_beca']; ?></td>
            </tr>
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