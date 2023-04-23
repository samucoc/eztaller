<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo" align='left'>Patente</td>
        <td class="grilla-tab-fila-titulo" align='left'>Responsable</td>
        <td class="grilla-tab-fila-titulo" align='left'>Mes de caducidad</td>
        <td class="grilla-tab-fila-titulo" align='left'>Aseguradora</td>
        <td class="grilla-tab-fila-titulo" align='left'>Prima</td>
    </tr>
{section name=registros loop=$arrRegistros}
    <tr>
        <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].patente}</td>
        <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].responsable}</td>
        <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].mes_caduca}</td>
        <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].aseguradora}</td>
        <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].prima}</td>
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



