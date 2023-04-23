<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='10' class="grilla-tab-fila-titulo" align='center'><b>Informe Devoluciones de Vendedor al {$smarty.now|date_format:"%d/%m/%Y"}</b></td>
</tr>
<tr>
	<td colspan='3' class="grilla-tab-fila-titulo" align='left'>Periodo:</td>
	<td colspan='7' class="grilla-tab-fila-campo" align='left'>Desde: {$DESDE} Hasta: {$HASTA}</td>
</tr>
<tr>
	<td colspan='3' class="grilla-tab-fila-titulo" align='left'>Vendedor:</td>
	<td colspan='7' class="grilla-tab-fila-campo" align='left'>{$VENDEDOR}</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Item</td>
	<td class="grilla-tab-fila-titulo" align='center'>Empresa</td>
	<td class="grilla-tab-fila-titulo" align='center'>Guía</td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
	<td class="grilla-tab-fila-titulo" align='center'>Vendedor</td>
	<td class="grilla-tab-fila-titulo" align='center'>Total Articulos</td>
	<td class="grilla-tab-fila-titulo" align='center'>Observaciones</td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha Dig.</td>
	<td class="grilla-tab-fila-titulo" align='center'>Usuario</td>
	<td class="grilla-tab-fila-titulo" align='center'></td>
</tr>


{section name=registros loop=$arrRegistros}
	<tr>
		<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].item}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].empresa}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].guia}</td>
		<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].fecha}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].vendedor}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].total_articulos|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].obs}</td>
		<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].fecha_dig}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].usuario}</td>
		<td class="grilla-tab-fila-campo" align='center'>
			<a href="#" style="cursor: hand;"><img  src="../images/magnify.png" border=0 title="Detalle Movimiento" onclick="xajax_LlamaGuia(xajax.getFormValues('Form1'), '{$arrRegistros[registros].guia}');"></a>
		</td>
	
	</tr>
		
{/section}
<tr>
	<td colspan='3' class="grilla-tab-fila-titulo" align='left'>Total Movimientos:</td>
	<td colspan='7' class="grilla-tab-fila-campo" align='left'>{$TOTAL_MOVIM|number_format:0:',':'.'}</td>
</tr>
<tr>
	<td colspan='10' class="grilla-tab-fila-titulo">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
	</td>
</tr>

</table>
</div>



