<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'persona');">Nro Orden Compra</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'monto');">Proveedor</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'monto');">Monto</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'estado');">Estado</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'monto');">Ver Orden Compra</a></td>
</tr>	

{section name=registros loop=$arrRegistros}
        <tr>
            <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].nro_oc}</td>
            <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].proveedor}</td>
            <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].monto}</td>
            <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].estado}</td>
            <td class="grilla-tab-fila-campo" align='left'>
            	<input type="button" name="btnBuscar" value="Ver Orden de Compra" class="boton" onclick="xajax_BuscarOc(xajax.getFormValues('Form1'), {$arrRegistros[registros].nro_oc});">
            </td>
        </tr>
{/section}

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



