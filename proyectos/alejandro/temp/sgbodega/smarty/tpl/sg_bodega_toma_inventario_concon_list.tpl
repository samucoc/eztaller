<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='16' class="grilla-tab-fila-titulo" align='center'><b>Toma de Inventario Con Con al {$smarty.now|date_format:"%d/%m/%Y"}</b></td>
</tr>

<tr>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'familia');">Familia</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'subfamilia');">SubFamilia</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'descripcion');">Descripción</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'codigo');">Código</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'codigo_antiguo');">Código Antiguo</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'stock_nuevo');">Stock Nuevo</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'stock_usa');">Stock Usado</a></td>
</tr>

{section name=registros loop=$arrRegistros}
	<tr>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].familia}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].subfamilia}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].descripcion}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].codigo}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].codigo_antiguo}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].stock_nuevo|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].stock_usa|number_format:0:',':'.'}</td>
	</tr>
		
{/section}

<tr>
	<td colspan='16' class="grilla-tab-fila-titulo">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
	</td>
</tr>
</table>
</div>



