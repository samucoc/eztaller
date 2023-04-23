<?php /* Smarty version 2.6.18, created on 2018-08-24 17:18:10
         compiled from sg_becas_todas_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'sg_becas_todas_list.tpl', 55, false),)), $this); ?>
<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
         <td class='grilla-tab-fila-titulo-pequenio' align='left'>
               Curso:
            </td>
         <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $this->_tpl_vars['nombre_curso']; ?>

            </td>
    </tr>
    <tr>
            <td class='grilla-tab-fila-titulo-pequenio' align='left'>
                Profesor:
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                <?php echo $this->_tpl_vars['nombre_profe']; ?>

            </td>
    </tr>
    </table>
    <table id='tabla_1' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Curso</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Rut Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nombre Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Tipo Beca</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Arancel Cuota Inicial</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Beca Cuota Inicial</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">% Beca Cuota Inicial</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Arancel Colegiatura</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Beca Colegiatura</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">% Beca Colegiatura</td>
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
        <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['con_beca'] != '' ) && ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['con_beca'] != 'Sin Beca' )): ?>
            <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
                <td class='grilla-tab-fila-campo-pequenio' align='left'>
                    <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['curso']; ?>

                </td>
                <td class='grilla-tab-fila-campo-pequenio' align='left'>
                    <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>

                </td>
                <td class='grilla-tab-fila-campo-pequenio' align='left'>
                    <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nombre_alumno']; ?>

                </td>
                <td class='grilla-tab-fila-campo-pequenio' align='center'>
                <?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_lista'] != 'Totales'): ?>
                    <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['con_beca'] == '' ) || ( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['con_beca'] == 'Sin Beca' )): ?>
                
                    <?php else: ?>
                        <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['con_beca']; ?>

                    <?php endif; ?>
                <?php endif; ?>
                </td>
                <td class='grilla-tab-fila-campo-pequenio' align='right'>
                    <?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ArancelIncorporacion'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>

                </td>
                <td class='grilla-tab-fila-campo-pequenio' align='right'>
                    <?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['IncorporacionTipoBeca'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>

                </td>
                <td class='grilla-tab-fila-campo-pequenio' align='right'>
                    <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['PorcBecaIncorporacion']; ?>
 %
                </td>
                <td class='grilla-tab-fila-campo-pequenio' align='right'>
                    <?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ArancelColegiatura'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>

                </td>
                <td class='grilla-tab-fila-campo-pequenio' align='right'>
                    <?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ColegiaturaTipoBeca'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>

                </td>
                <td class='grilla-tab-fila-campo-pequenio' align='right'>
                    <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['PorcBecaColegiatura']; ?>
 %
                </td>                
            </tr>
         <?php endif; ?>
    <?php endfor; endif; ?>
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
            <a href="#" style="cursor: hand;" id="btnExport" name="btnExport" onclick='ExportToExcel()'><img src="../images/basicos/imprimir.png" border=0 title="Exportar Excel" width="32"></a>

        </td>
    </tr>
    </table>
</div>