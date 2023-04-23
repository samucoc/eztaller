<?php /* Smarty version 2.6.18, created on 2013-04-03 09:56:28
         compiled from sg_informe_facturas_compras_periodo_fact_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_informe_facturas_compras_periodo_fact_list.tpl', 24, false),array('modifier', 'number_format', 'sg_informe_facturas_compras_periodo_fact_list.tpl', 27, false),)), $this); ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Empresa</td>
	<td class="grilla-tab-fila-titulo" align='center'>Tipo</td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
	<td class="grilla-tab-fila-titulo" align='center'>Proveedor</td>
	<td class="grilla-tab-fila-titulo" align='center'>Nro Factura</td>
	<td class="grilla-tab-fila-titulo" align='center'>Neto</td>
	<td class="grilla-tab-fila-titulo" align='center'>Iva</td>
	<td class="grilla-tab-fila-titulo" align='center'>Total</td>
	<td class="grilla-tab-fila-titulo" align='center'>Elegir</td>
	<td class="grilla-tab-fila-titulo" align='center'>Eliminar</td>

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
		<td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['empresa']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo_factura']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</td>
		<td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cliente']; ?>
</td>
        <td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_boleta']; ?>
</td>
		<td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['neto'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ".", ",") : number_format($_tmp, 0, ".", ",")); ?>
</td>
		<td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['iva'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ".", ",") : number_format($_tmp, 0, ".", ",")); ?>
</td>
		<td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ".", ",") : number_format($_tmp, 0, ".", ",")); ?>
</td>
		<td class="grilla-tab-fila-campo" align='left'>
        	<input type="checkbox" name="fact_elegida[]" id="<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_boleta']; ?>
" value="<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['tipo_factura']; ?>
_<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
"/>
        </td>
        <td class="grilla-tab-fila-campo" align='left'>
        	<?php if ($this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['cierre'] == 'SI'): ?>
            <a href="#" onclick="xajax_Eliminar(xajax.getFormValues('Form1'),<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['ncorr']; ?>
)">Eliminar</a>
            <?php else: ?>
            No Aplica
            <?php endif; ?>
        </td>
		</tr>
<?php endfor; endif; ?>
	<tr>
        <td class="grilla-tab-fila-titulo" >Periodo Contable:</td>
        <td class="grilla-tab-fila-campo" colspan="8">
            Mes:
            <SELECT id="cboMes" name="cboMes" onKeyPress="return Tabula(this, event, 0)">
                <option value=''>- - Seleccione - -</option>
                <option value='1'>Enero</option>
                <option value='2'>Febrero</option>
                <option value='3'>Marzo</option>
                <option value='4'>Abril</option>
                <option value='5'>Mayo</option>
                <option value='6'>Junio</option>
                <option value='7'>Julio</option>
                <option value='8'>Agosto</option>
                <option value='9'>Septiembre</option>
                <option value='10'>Octubre</option>
                <option value='11'>Noviembre</option>
                <option value='12'>Diciembre</option>
            </SELECT>
            &nbsp;&nbsp;
            A&ntilde;o:
            <SELECT id="cboAnio" name="cboAnio" onKeyPress="return Tabula(this, event, 0)">
                <option value=''>- - Seleccione - -</option>
                <option value='2010'>2010</option>
                <option value='2011'>2011</option>
                <option value='2012'>2012</option>
                <option value='2013'>2013</option>
                <option value='2014'>2014</option>
                <option value='2015'>2015</option>
            </SELECT>
            
        </td>
    </tr>
    <tr>
    	<td class="grilla-tab-fila-titulo" ><input type="button" class="boton" value="Asociar" name="btnAsociar" onclick="xajax_Asociar(xajax.getFormValues('Form1'));"/></td>
    </tr>
</table>
</div>


