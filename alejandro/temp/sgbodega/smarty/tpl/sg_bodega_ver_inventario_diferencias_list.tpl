<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='16' class="grilla-tab-fila-titulo" align='center'><b>Toma de Inventario al {$fecha|date_format:"%d/%m/%Y"} con las diferencias encontradas</b></td>
</tr>
</table>

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td class="grilla-tab-fila-titulo" align='center'></td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
	<td class="grilla-tab-fila-titulo" align='center'>Codigo Barra</td>
	<td class="grilla-tab-fila-titulo" align='center'>Codigo</td>
	<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>
	<td class="grilla-tab-fila-titulo" align='center'>Cantidad</td>
	<td class="grilla-tab-fila-titulo" align='center'>Contado</td>
	<td class="grilla-tab-fila-titulo" align='center'>Diferencia</td>
	<td class="grilla-tab-fila-titulo" align='center'>Observacion</td>
	<td class="grilla-tab-fila-titulo" align='center'>Usuario</td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha Digitacion</td>
</tr>

{section name=registros loop=$arrRegistros}
	<tr>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].item}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].fecha|date_format:"%d/%m/%Y"}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].codigo_barra}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].codigo}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].deascripcion}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].cantidad|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].contado|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].diferencia|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].observacion}</td>
		<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].usuario}</td>
		<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].fecha_dig|date_format:"%d/%m/%Y %H:%m:%S"}</td>
	</tr>
		
{/section}

</table>
</div>



