<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
{section name=registros loop=$arrRegistros}

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Trabajador</td>
	<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].trabajador}</td>
	<td class="grilla-tab-fila-titulo" align='center' width="25%">Patente</td>
	<td class="grilla-tab-fila-campo" align='center' width="25%">{$arrRegistros[registros].patente}</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Nro Correlativo</td>
	<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].ncorr}</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Mecanico</td>
	<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].mecanico}</td>
    <td class="grilla-tab-fila-titulo" align='center'>Fecha Reparacion</td>
	<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].fecha_repara|date_format:"%d/%m/%Y"}</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Documento</td>
	<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].documento}</td>
	<td class="grilla-tab-fila-titulo" align='center'>Cheque</td>
	<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].cheque}</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Repuesto</td>
	<td class="grilla-tab-fila-titulo" align='center'>Precio Unitario</td>
	<td class="grilla-tab-fila-titulo" align='center'>Cantidad</td>
	<td class="grilla-tab-fila-titulo" align='center'>Valor Total</td>
</tr>	
    {section name=detalle loop=$arrRegDetalle}
	    {if $arrRegDetalle[detalle].repara_ncorr == $arrRegistros[registros].ncorr}
            <tr>
            <td class="grilla-tab-fila-campo" align='left'>{$arrRegDetalle[detalle].repuesto}</td>
            <td class="grilla-tab-fila-campo" align='left'>{$arrRegDetalle[detalle].pu|number_format:0:',':'.'}</td>
            <td class="grilla-tab-fila-campo" align='left'>{$arrRegDetalle[detalle].cant}</td>
            <td class="grilla-tab-fila-campo" align='left'>{$arrRegDetalle[detalle].vt|number_format:0:',':'.'}</td>
            </tr>
    	{/if}
    {/section}
<tr>
	<td class="grilla-tab-fila-titulo" align='RIGHT' colspan="1">Observacion</td>
	<td class="grilla-tab-fila-campo" align='center' colspan="3">{$arrRegistros[registros].observa}</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='RIGHT' colspan="3">Suma</td>
	<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].suma_total|number_format:0:',':'.'}</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='RIGHT' colspan="4"></td>
</tr>
{/section}
<tr>
	<td class="grilla-tab-fila-titulo" align='RIGHT' colspan="3">Suma Total</td>
	<td class="grilla-tab-fila-campo" align='center'>{$suma|number_format:0:',':'.'}</td>
</tr>
<tr>
	<td colspan='16' class="grilla-tab-fila-titulo">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>
</table>
</div>



