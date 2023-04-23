<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Patente</td>
	<td class="grilla-tab-fila-titulo" align='center'>Tipo de Vehiculo</td>
	<td class="grilla-tab-fila-titulo" align='center'>Trabajador</td>
	

{section name=registros loop=$arrRegistros}
        <tr>
            <td class="grilla-tab-fila-campo" align='center'>
                <a href="#" onclick="xajax_TraeValores(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}','{$arrRegistros[registros].patente}','{$arrRegistros[registros].rut}')">{$arrRegistros[registros].patente}</a>
            </td>
            <td class="grilla-tab-fila-campo" align='center'>
                <a href="#" onclick="xajax_TraeValores(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}','{$arrRegistros[registros].patente}','{$arrRegistros[registros].rut}')">{$arrRegistros[registros].tipo_veh}</a>
            </td>
            <td class="grilla-tab-fila-campo" align='center'>
                <a href="#" onclick="xajax_TraeValores(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}','{$arrRegistros[registros].patente}','{$arrRegistros[registros].rut}')">{$arrRegistros[registros].rut}</a>
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



