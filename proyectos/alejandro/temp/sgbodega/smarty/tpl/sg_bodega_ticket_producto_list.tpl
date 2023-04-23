<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
{section name=registros loop=$arrRegistros}
	<tr>
		<td class="grilla-tab-fila-campo" align='left' style="padding-bottom:40px">
        	{$arrRegistros[registros].codigo}<br />
        	{$arrRegistros[registros].descripcion}<br />
        	{$arrRegistros[registros].precio|number_format:0:',':'.'}
        </td>
		<td class="grilla-tab-fila-campo" align='left' style="padding-bottom:40px; padding-left:80px">
        	{$arrRegistros[registros].codigo}<br />
        	{$arrRegistros[registros].descripcion}<br />	
        	{$arrRegistros[registros].precio|number_format:0:',':'.'}
        </td>
	</tr>
	<tr>
		<td class="grilla-tab-fila-campo" align='left' style="padding-bottom:40px">
        	{$arrRegistros[registros].codigo}<br />
        	{$arrRegistros[registros].descripcion}<br />
        	{$arrRegistros[registros].precio|number_format:0:',':'.'}
        </td>
		<td class="grilla-tab-fila-campo" align='left' style="padding-bottom:40px; padding-left:80px">
        	{$arrRegistros[registros].codigo}<br />
        	{$arrRegistros[registros].descripcion}<br />	
        	{$arrRegistros[registros].precio|number_format:0:',':'.'}
        </td>
	</tr>
	
{/section}

<tr>
	<td colspan='16' class="grilla-tab-fila-titulo">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">
	</td>
</tr>
</table>
</div>



