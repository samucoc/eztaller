<?php /* Smarty version 2.6.18, created on 2018-09-16 15:01:07
         compiled from sg_cobranza_alumnos_morosos_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'sg_cobranza_alumnos_morosos_list.tpl', 32, false),)), $this); ?>
<div id='pivot'>

	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

   	<tr>

        <td class="grilla-tab-fila-titulo-pequenio" align="center">Alumno</td>

        <td class="grilla-tab-fila-titulo-pequenio" align="center">Curso</td>

        <td class="grilla-tab-fila-titulo-pequenio" align="center">

            <a href="#" onclick="xajax_OrdenarRevision(xajax.getFormValues('Form1'),'saldo');">Saldo</a>

        </td>

        <td class="grilla-tab-fila-titulo-pequenio" align="center">

            <a href="#" onclick="xajax_OrdenarRevision(xajax.getFormValues('Form1'),'da');">

            Dias de Atraso

            </a>

        </td>

        <td class="grilla-tab-fila-titulo-pequenio" align="center">Matriculado</td>

        <td class="grilla-tab-fila-titulo" align="right">

            <input type="checkbox" name="todos"  id="todos" value='1' onchange="cambiar()"/>

            Cobranza

        </td>

        <td class="grilla-tab-fila-titulo" align="right">

            Cobranza Pre-Judicial

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

            <td class='grilla-tab-fila-campo-pequenio' align='left'>

                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['alumno']; ?>
</a>

            </td>

            <td class='grilla-tab-fila-campo-pequenio' align='center'>

                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['curso']; ?>
</a>

            </td>

            <td class='grilla-tab-fila-campo-pequenio' align='right'>

                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>
');"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['saldo'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>
</a>

            </td>

            <td class='grilla-tab-fila-campo-pequenio' align='center'>

                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>
');"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['da']; ?>
</a>

            </td>

            <td class='grilla-tab-fila-campo-pequenio' align='center'>

                <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_retirado'] == 'NO' )): ?>

                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>
');">

                    <img src='../images/tick.png' width='24' title='Matriculado' />

                </a>

                <?php else: ?>

                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>
');">

                    <img src='../images/stop.png' width='24' title='Retirado' />

                </a>

                <?php endif; ?>

            </td>

            

            <td class="grilla-tab-fila-campo" align="right">

                <input type="checkbox" name="seleccion[]" id="<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>
" value='<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>
' />

                <a href="#" target="_self">

                    <img src="../../sgadministrativo/images/basicos/imprimir.png" border=0 title="Imprimir  Carta Cobranza"

                        onclick="xajax_ImprimePDF(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>
','<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_buscar']; ?>
');"

                        width="32">

                </a>

                <a href="#" target="_self">

                    <img src="../../sgadministrativo/images/basicos/email2.png" border=0 title="Enviar Carta Cobranza"

                        onclick="xajax_EnviarPDF(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>
','<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_buscar']; ?>
');"

                        width="32">

                </a>

            </td>

            <td class="grilla-tab-fila-campo" align="right">

                <a href="#" target="_self">

                    <img src="../../sgadministrativo/images/basicos/imprimir.png" border=0 title="Imprime Carta Cobranza Pre-judicial" 

                        onclick="xajax_ImprimePDF_2(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>
','<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_buscar']; ?>
');"

                        width="32">

                </a>

                <a href="#" target="_self">

                    <img src="../../sgadministrativo/images/basicos/email2.png" border=0 title="Enviar Carta Cobranza Pre-Judicial" 

                        onclick="xajax_EnviarPDF_2(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['rut_alumno']; ?>
','<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_buscar']; ?>
');"

                        width="32">

                </a>

            </td>

	    </tr>

    <?php endfor; endif; ?>

    <tr>

        <td colspan='16' class="grilla-tab-fila-titulo">

            <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>

                <a href="#" target="_self">

                    <img src="../../sgadministrativo/images/basicos/imprimir.png" border=0 title="Imprimir Informe Seleccionados" 

                        onclick="xajax_ImprimePDFSeleccionados(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_buscar']; ?>
');"

                        width="32">

                </a>            

            <a href="#" target="_self" style="cursor: hand;"><img src="../../sgadministrativo/images/basicos/email2.png" border=0 title="Enviar Correo Seleccionados" onclick="xajax_EnviarCorreoSeleccionados(xajax.getFormValues('Form1'),'<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha_buscar']; ?>
');" width="32"></a>

        </td>

    </tr>

    </table>

</div>