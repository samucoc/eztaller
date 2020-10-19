<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
	<td class="grilla-tab-fila-titulo" align='center'>Código</td>
	<td class="grilla-tab-fila-titulo" align='center'>Descripción</td>
	<td class="grilla-tab-fila-titulo" align='center'>N/U</td>
	<td class="grilla-tab-fila-titulo" align='center'>Guía</td>
	<td class="grilla-tab-fila-titulo" align='center'>Tarjeta</td>
	<td class="grilla-tab-fila-titulo" align='center'>Movimiento</td>
	<td class="grilla-tab-fila-titulo" align='center'>Cantidad</td>
	<td class="grilla-tab-fila-titulo" align='center'>Usuario</td>

</tr>

{section name=registros loop=$arrRegistros}
	<tr>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].fecha}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].codigo}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].descripcion}</td>
		<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].nu}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].guia|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].tarjeta}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].movim}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].cantidad|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].usuario}</td>
		
	</tr>
		
{/section}

<tr>
	<td colspan='7' class="grilla-tab-fila-campo" align='right'><b>Total N:</b></td>
	<td colspan='1' class="grilla-tab-fila-campo" align='right'><b>{$TOTAL_N|number_format:0:',':'.'}</b></td>
</tr>
<tr>
	<td colspan='7' class="grilla-tab-fila-campo" align='right'><b>Total U:</b></td>
	<td colspan='1' class="grilla-tab-fila-campo" align='right'><b>{$TOTAL_U|number_format:0:',':'.'}</b></td>
</tr>
<tr>
	<td colspan='7' class="grilla-tab-fila-campo" align='right'><b>Total:</b></td>
	<td colspan='1' class="grilla-tab-fila-campo" align='right'><b>{$TOTAL|number_format:0:',':'.'}</b></td>
</tr>

<tr>
	<td colspan='16' class="grilla-tab-fila-titulo">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
	</td>
</tr>
</table>
</div>



