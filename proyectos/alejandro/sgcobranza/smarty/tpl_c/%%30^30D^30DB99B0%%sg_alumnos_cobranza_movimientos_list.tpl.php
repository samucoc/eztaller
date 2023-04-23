<?php /* Smarty version 2.6.18, created on 2016-11-28 21:15:05
         compiled from sg_alumnos_cobranza_movimientos_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_alumnos_cobranza_movimientos_list.tpl', 19, false),array('modifier', 'number_format', 'sg_alumnos_cobranza_movimientos_list.tpl', 20, false),)), $this); ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Nro Boleta</td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
	<td class="grilla-tab-fila-titulo" align='center'>Valor</td>
	<td class="grilla-tab-fila-titulo" align='center'>Tipo de Pago</td>
	<td class="grilla-tab-fila-titulo" align='center'>Estado Pago</td>
	<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>

    </tr>
	

<?php unset($this->_sections['registros']);
$this->_sections['registros']['name'] = 'registros';
$this->_sections['registros']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistrosMov']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		<td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistrosMov'][$this->_sections['registros']['index']]['nro_boleta']; ?>
</td>
       	<td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistrosMov'][$this->_sections['registros']['index']]['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d/%m/%Y") : smarty_modifier_date_format($_tmp, "%d/%m/%Y")); ?>
</td>
		<td class="grilla-tab-fila-campo" align='left'><?php echo ((is_array($_tmp=$this->_tpl_vars['arrRegistrosMov'][$this->_sections['registros']['index']]['valor'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ".", ",") : number_format($_tmp, 0, ".", ",")); ?>
</td>
		<td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistrosMov'][$this->_sections['registros']['index']]['tipo_pago']; ?>
</td>
		<?php if ($this->_tpl_vars['arrRegistrosMov'][$this->_sections['registros']['index']]['valor'] == '0'): ?>
			<td class="grilla-tab-fila-campo" align='left'>NULA</td>
		<?php else: ?>
			<td class="grilla-tab-fila-campo" align='left'>VIGENTE</td>
		<?php endif; ?>
		<td class="grilla-tab-fila-campo" align='left'><?php echo $this->_tpl_vars['arrRegistrosMov'][$this->_sections['registros']['index']]['descripcion']; ?>
</td>
		</tr>
<?php endfor; endif; ?>

<tr>
	<tr>
    <td class="grilla-tab-fila-titulo" align='center'>Total</td>
    <td class="grilla-tab-fila-campo" align='right' colspan="6"><label id="total" name="total">0</label></td>
    </tr>
	<td colspan='16' class="grilla-tab-fila-titulo">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		         <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>
</table>
</div>


