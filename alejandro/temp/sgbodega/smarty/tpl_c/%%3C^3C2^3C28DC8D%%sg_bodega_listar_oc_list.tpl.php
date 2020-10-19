<?php /* Smarty version 2.6.18, created on 2016-03-30 10:40:08
         compiled from sg_bodega_listar_oc_list.tpl */ ?>
<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'persona');">Nro Orden Compra</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'monto');">Proveedor</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'monto');">Monto</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'monto');">Ver Orden Compra</a></td>
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
            <td class="grilla-tab-fila-campo" align='left'>
            	<a href="#" onclick="xajax_EnviarPagina(xajax.getFormValues('Form1'), <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_oc']; ?>
)"> 
            	<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_oc']; ?>

                </a>
            </td>
            <td class="grilla-tab-fila-campo" align='left'>
            	<a href="#" onclick="xajax_EnviarPagina(xajax.getFormValues('Form1'), <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_oc']; ?>
)"> 
                <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['proveedor']; ?>

                </a>
                </td>
            <td class="grilla-tab-fila-campo" align='left'>
            	<a href="#" onclick="xajax_EnviarPagina(xajax.getFormValues('Form1'), <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_oc']; ?>
)"> 
            	<?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['monto']; ?>

                </a>
                </td>
            <td class="grilla-tab-fila-campo" align='left'>
            	<input type="button" name="btnBuscar" value="Ver Orden de Compra" class="boton" onclick="xajax_BuscarOc(xajax.getFormValues('Form1'), <?php echo $this->_tpl_vars['arrRegistros'][$this->_sections['registros']['index']]['nro_oc']; ?>
);">
            </td>
        </tr>
<?php endfor; endif; ?>

<tr>
	<td colspan='16' class="grilla-tab-fila-titulo">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">-->
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>
</table>
</div>


