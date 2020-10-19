<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='7' class="grilla-tab-fila-titulo" align='center'><b>Consulta Movimientos al {$smarty.now|date_format:"%d/%m/%Y"}</b></td>
</tr>
<tr>
	<td colspan='2' class="grilla-tab-fila-titulo" align='left'>Periodo:</td>
	<td colspan='5' class="grilla-tab-fila-campo" align='left'>Desde: {$DESDE} Hasta: {$HASTA}</td>
</tr>
<tr>
	<td colspan='2' class="grilla-tab-fila-titulo" align='left'>Movimiento:</td>
	<td colspan='5' class="grilla-tab-fila-campo" align='left'>{$MOVIMIENTO}</td>
</tr>

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Item</td>
	<td class="grilla-tab-fila-titulo" align='center'>Guía</td>
	<td class="grilla-tab-fila-titulo" align='center'>Movimiento</td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
	<td class="grilla-tab-fila-titulo" align='center'>Observación</td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha Dig.</td>
	<td class="grilla-tab-fila-titulo" align='center'>Usuario</td>
</tr>

{section name=registros loop=$arrRegistros}
	<tr>
		<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].item}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].guia}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].movimiento}</td>
		<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].fecha}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].obs}</td>
		<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].fecha_dig}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].usuario}</td>
	</tr>
		
{/section}
<tr>
	<td colspan='2' class="grilla-tab-fila-titulo" align='left'>Total Movimientos:</td>
	<td colspan='5' class="grilla-tab-fila-campo" align='left'>{$TOTAL_MOVIM|number_format:0:',':'.'}</td>
</tr>
<tr>
	<td colspan='7' class="grilla-tab-fila-titulo">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
	</td>
</tr>

</table>
</div>



