<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='13' class="grilla-tab-fila-titulo" align='center'><b>Informe Movimientos al {$smarty.now|date_format:"%d/%m/%Y"}</b></td>
</tr>
<tr>
	<td colspan='3' class="grilla-tab-fila-titulo" align='left'>Periodo:</td>
	<td colspan='10' class="grilla-tab-fila-campo" align='left'>Desde: {$DESDE} Hasta: {$HASTA}</td>
</tr>
<tr>
	<td colspan='3' class="grilla-tab-fila-titulo" align='left'>Tipo de Movimiento:</td>
	<td colspan='10' class="grilla-tab-fila-campo" align='left'>{$NOMBRE_MOVIMIENTO}</td>
</tr>
<tr>
	<td colspan='3' class="grilla-tab-fila-titulo" align='left'>Bodega:</td>
	<td colspan='10' class="grilla-tab-fila-campo" align='left'>{$BODEGA}</td>
</tr>
<tr>
	<td colspan='3' class="grilla-tab-fila-titulo" align='left'>Codigo:</td>
	<td colspan='10' class="grilla-tab-fila-campo" align='left'>{$CODIGO}</td>
</tr>
<tr>
	<td colspan='3' class="grilla-tab-fila-titulo" align='left'>Descripcion:</td>
	<td colspan='10' class="grilla-tab-fila-campo" align='left'>{$DESCRIPCION}</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'item');">Item</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'fecha');">Fecha</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'guia');">Guía</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'bodega');">Bodega</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'empresa');">Empresa</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'tipo_movim');">Tipo de Movimiento</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'det_mpvim');">Det Movimiento</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'cantidad');">Cantidad</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'factura');">Documento</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'usuario');">Usuario</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'fecha_dig');">Fecha Dig.</a></td>
</tr>
{section name=registros loop=$arrRegistros}
	<tr>
		<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].item}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].fecha|date_format:"%d/%m/%Y"}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].guia}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].bodega}</td>
		<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].empresa}</td>
		<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].tipo_movim}</td>
		<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].det_movim}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].cantidad}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].factura}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].usuario}</td>
		<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].fecha_dig}</td>
	</tr>
{/section}
<tr>
	<td colspan='3' class="grilla-tab-fila-titulo" align='left'>Totales:</td>
	<td colspan='2' class="grilla-tab-fila-campo" align='left'>{$TOTAL_1|number_format:0:',':'.'}</td>
	<td colspan='2' class="grilla-tab-fila-campo" align='left'>{$TOTAL_2|number_format:0:',':'.'}</td>
	<td colspan='2' class="grilla-tab-fila-campo" align='left'>{$TOTAL_3|number_format:0:',':'.'}</td>
	<td colspan='2' class="grilla-tab-fila-campo" align='left'>{$TOTAL_5|number_format:0:',':'.'}</td>
</tr>
<tr>
	<td colspan='13' class="grilla-tab-fila-titulo">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
	</td>
</tr>

</table>
</div>



