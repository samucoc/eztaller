<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td colspan="13" class="grilla-tab-fila-titulo" align="center">Informe Libro Venta</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align="center">Fecha</td>
	<td class="grilla-tab-fila-titulo" align="center">Desde</td>
	<td class="grilla-tab-fila-titulo" align="center">Hasta</td>
	<td class="grilla-tab-fila-titulo" align="center">Total</td>
	<td class="grilla-tab-fila-titulo" align="center">Desde</td>
	<td class="grilla-tab-fila-titulo" align="center">Hasta</td>
	<td class="grilla-tab-fila-titulo" align="center">Total</td>
	<td class="grilla-tab-fila-titulo" align="center">Desde</td>
	<td class="grilla-tab-fila-titulo" align="center">Hasta</td>
	<td class="grilla-tab-fila-titulo" align="center">Total</td>
	<td class="grilla-tab-fila-titulo" align="center">Desde</td>
	<td class="grilla-tab-fila-titulo" align="center">Hasta</td>
	<td class="grilla-tab-fila-titulo" align="center">Total</td>
</tr>
	{section name=detalle loop=$arrDetalle}
        <tr>
                {if $arrDetalle[detalle].fecha == '----'}
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">
                    	Subtotales
                </td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">{$arrDetalle[detalle].inicio}</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">{$arrDetalle[detalle].fin}</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">{$arrDetalle[detalle].monto|number_format:0:",":"."}</td>
                
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">{$arrDetalle[detalle].inicio_1}</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">{$arrDetalle[detalle].fin_1}</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">{$arrDetalle[detalle].monto_1|number_format:0:",":"."}</td>
                
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">{$arrDetalle[detalle].inicio_2}</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">{$arrDetalle[detalle].fin_2}</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">{$arrDetalle[detalle].monto_2|number_format:0:",":"."}</td>
                
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">{$arrDetalle[detalle].inicio_3}</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">{$arrDetalle[detalle].fin_3}</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">{$arrDetalle[detalle].monto_3|number_format:0:",":"."}</td>
                {elseif $arrDetalle[detalle].fecha == 'xxxx'}
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">
                    	----
                </td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">                    	----
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">                    	----
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">                    	----
</td>
                
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">                    	----
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">                    	----
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">                    	----
</td>
                
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">                    	----
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">                    	----
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">                    	----
</td>
                
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">                    	----
</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">{$arrDetalle[detalle].fin_3}</td>
                <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder; color:#000; background-color:#447CAD">{$arrDetalle[detalle].monto_3|number_format:0:",":"."}</td>
                {else}
                <td class="grilla-tab-fila-titulo" align='left'>
	                	{$arrDetalle[detalle].fecha|date_format:"%d/%m/%Y"}
                </td>
                <td class="grilla-tab-fila-campo" align='left' >{$arrDetalle[detalle].inicio}</td>
                <td class="grilla-tab-fila-campo" align='left' >{$arrDetalle[detalle].fin}</td>
                <td class="grilla-tab-fila-campo" align='left' >{$arrDetalle[detalle].monto|number_format:0:",":"."}</td>
                
                <td class="grilla-tab-fila-campo" align='left' >{$arrDetalle[detalle].inicio_1}</td>
                <td class="grilla-tab-fila-campo" align='left' >{$arrDetalle[detalle].fin_1}</td>
                <td class="grilla-tab-fila-campo" align='left' >{$arrDetalle[detalle].monto_1|number_format:0:",":"."}</td>
                
                <td class="grilla-tab-fila-campo" align='left' >{$arrDetalle[detalle].inicio_2}</td>
                <td class="grilla-tab-fila-campo" align='left' >{$arrDetalle[detalle].fin_2}</td>
                <td class="grilla-tab-fila-campo" align='left' >{$arrDetalle[detalle].monto_2|number_format:0:",":"."}</td>
                
                <td class="grilla-tab-fila-campo" align='left' >{$arrDetalle[detalle].inicio_3}</td>
                <td class="grilla-tab-fila-campo" align='left' >{$arrDetalle[detalle].fin_3}</td>
                <td class="grilla-tab-fila-campo" align='left' >{$arrDetalle[detalle].monto_3|number_format:0:",":"."}</td>
				{/if}
                
        </tr>
    {/section}
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



