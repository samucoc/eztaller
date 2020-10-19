<div id="pivot">

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='11' class="grilla-tab-fila-titulo" align='center'><b>Historial al {$smarty.now|date_format:"%d/%m/%Y"}</b></td>
</tr>
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Folio</td>
		<td class="grilla-tab-fila-titulo" align='center'>Codigo</td>
		<td class="grilla-tab-fila-titulo" align='center'>Transaccion</td>
		<td class="grilla-tab-fila-titulo" align='center'>Fecha Estado</td>
		<td class="grilla-tab-fila-titulo" align='center'>Fecha Digitacion</td>
		<td class="grilla-tab-fila-titulo" align='center'>Usuario</td>
	</tr>
{section name=registros loop=$arrRegistros}
	<tr>
		
		<td class="grilla-tab-fila-campo" align='center'><b>{$arrRegistros[registros].folio}</b></td>
		<td class="grilla-tab-fila-campo" align='right'><b>{$arrRegistros[registros].codigo} {$arrRegistros[registros].descripcion} </b></td>
		<td class="grilla-tab-fila-campo" align='right'><b>{$arrRegistros[registros].transaccion}</b></td>
		<td class="grilla-tab-fila-campo" align='right'><b>{$arrRegistros[registros].fecha_estado|date_format:"%d/%m/%Y"}</b></td>
		<td class="grilla-tab-fila-campo" align='right'><b>{$arrRegistros[registros].fecha_dig|date_format:"%d/%m/%Y %H:%M:%S"}</b></td>
		<td colspan='6' class="grilla-tab-fila-campo" align='left'><b>{$arrRegistros[registros].usuario}</b></td>
	</tr>
	
		
{/section}

<tr>
	<td colspan='11' class="grilla-tab-fila-titulo">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
	</td>
</tr>

</table>
</div>
