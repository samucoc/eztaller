<?php /* Smarty version 2.6.18, created on 2016-03-31 12:20:58
         compiled from sg_informe_saldo_individual_list.tpl */ ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<!--
<tr>
	<td class="grilla-tab-fila-titulo" align='center' >Quincena</td>
	<td class="grilla-tab-fila-titulo" align='center' ><?php echo $this->_tpl_vars['quincena']; ?>
</td>
</tr>
-->
<tr>
	<td class="grilla-tab-fila-titulo" align='center' >Trabajador</td>
	<td class="grilla-tab-fila-titulo" align='center' >Patente</td>
	<td class="grilla-tab-fila-titulo" align='center' >Empresa</td>
	<td class="grilla-tab-fila-titulo" align='center' >Departamento</td>
	<td class="grilla-tab-fila-titulo" align='center' >Producto</td>
	<td class="grilla-tab-fila-titulo" align='center' >Asignado</td>
	<td class="grilla-tab-fila-titulo" align='center' >Disponible Quincena</td>
</tr>
	<?php unset($this->_sections['mes']);
$this->_sections['mes']['name'] = 'mes';
$this->_sections['mes']['loop'] = is_array($_loop=$this->_tpl_vars['arrRegistros']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mes']['show'] = true;
$this->_sections['mes']['max'] = $this->_sections['mes']['loop'];
$this->_sections['mes']['step'] = 1;
$this->_sections['mes']['start'] = $this->_sections['mes']['step'] > 0 ? 0 : $this->_sections['mes']['loop']-1;
if ($this->_sections['mes']['show']) {
    $this->_sections['mes']['total'] = $this->_sections['mes']['loop'];
    if ($this->_sections['mes']['total'] == 0)
        $this->_sections['mes']['show'] = false;
} else
    $this->_sections['mes']['total'] = 0;
if ($this->_sections['mes']['show']):

            for ($this->_sections['mes']['index'] = $this->_sections['mes']['start'], $this->_sections['mes']['iteration'] = 1;
                 $this->_sections['mes']['iteration'] <= $this->_sections['mes']['total'];
                 $this->_sections['mes']['index'] += $this->_sections['mes']['step'], $this->_sections['mes']['iteration']++):
$this->_sections['mes']['rownum'] = $this->_sections['mes']['iteration'];
$this->_sections['mes']['index_prev'] = $this->_sections['mes']['index'] - $this->_sections['mes']['step'];
$this->_sections['mes']['index_next'] = $this->_sections['mes']['index'] + $this->_sections['mes']['step'];
$this->_sections['mes']['first']      = ($this->_sections['mes']['iteration'] == 1);
$this->_sections['mes']['last']       = ($this->_sections['mes']['iteration'] == $this->_sections['mes']['total']);
?>	
<tr>
	<td class="grilla-tab-fila-titulo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['mes']['index']]['trabajador']; ?>
</td>
	<td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['mes']['index']]['patente']; ?>
</td>
	<td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['mes']['index']]['empresa']; ?>
</td>
	<td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['mes']['index']]['depto']; ?>
</td>
	<td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['mes']['index']]['producto']; ?>
</td>
	<td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['mes']['index']]['asignacion']; ?>
</td>
	<td class="grilla-tab-fila-campo" align='center'><?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['mes']['index']]['disponible']; ?>
</td>

</tr>
	<?php endfor; endif; ?>	

<tr>
	<td colspan='2' class="grilla-tab-fila-titulo">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>
</table>
</div>


