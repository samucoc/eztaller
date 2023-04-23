<?php /* Smarty version 2.6.18, created on 2017-07-28 20:45:40
         compiled from sg_cobranza_cheques_list.tpl */ ?>
<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
        <td class="grilla-tab-fila-titulo" align="center">Apoderado</td>
        <td class="grilla-tab-fila-titulo" align="center">Curso</td>
        <td class="grilla-tab-fila-titulo" align="center">Alumno</td>
        <td class="grilla-tab-fila-titulo" align="center">Nro Cheque</td>
        <td class="grilla-tab-fila-titulo" align="center">Banco</td>
        <td class="grilla-tab-fila-titulo" align="center">Valor</td>
        <td class="grilla-tab-fila-titulo" align="center">Fecha</td>
        <td class="grilla-tab-fila-titulo" align="center">Estado</td>
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
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cheque_ncorr']; ?>
);"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['apoderado']; ?>
</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cheque_ncorr']; ?>
);"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['curso']; ?>
</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cheque_ncorr']; ?>
);"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['alumno']; ?>
</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cheque_ncorr']; ?>
);"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NumeroCheque']; ?>
</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cheque_ncorr']; ?>
);"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NombreBanco']; ?>
</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cheque_ncorr']; ?>
);"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ValorCheque']; ?>
</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cheque_ncorr']; ?>
);"><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['FechaCheque']; ?>
</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['EstadoCheque'] == '0' )): ?>
                    <a href="#" onclick="xajax_PagarMov(xajax.getFormValues('Form1'),<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NumeroBoleta']; ?>
)">
                        <img src="../images/fin_comp/pago.png" title="Pagar Cheque" alt="Pagar Cheque" width="24" height="24"/>
                    </a>
                    <input type="hidden" name="cheque_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NumeroBoleta']; ?>
" id="cheque_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NumeroBoleta']; ?>
" value="<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['NumeroBoleta']; ?>
"/>
                <?php endif; ?>
                <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['EstadoCheque'] == '1' )): ?>
                    Cobrado
                <?php endif; ?>
                <?php if (( $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['EstadoCheque'] == '2' )): ?>
                    Anulado
                <?php endif; ?>
            </td>
	    </tr>
    <?php endfor; endif; ?>
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <a href="#" onclick="ImprimeDiv('divabonos');">
                <img src='../images/basicos/imprimir.png' title='Imprimir' width="32"/>
            </a>
        </td>
    </tr>
    </table>
</div>