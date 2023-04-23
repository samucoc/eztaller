<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

{section name=registros loop=$arrRegistros}
	<tr>
		<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Guía:</td>
		<td colspan='7' class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].guia}</td>
	</tr>	
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Movimiento:</td>
		<td colspan='7' class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].movimiento}</td>
	</tr>
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Fecha:</td>
		<td colspan='7' class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].fecha}</td>
	</tr>
	{if ($movim == '9')}	
		<tr>
			<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Trabajador:</td>
			<td colspan='7' class="grilla-tab-fila-campo" align='left'>{$trabajador}</td>
		</tr>
	{/if}
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Observación:</td>
		<td colspan='7' class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].obs}</td>
	</tr>
	
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Usuario:</td>
		<td colspan='7' class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].usuario}</td>
	</tr>
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Empresa:</td>
		<td colspan='7' class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].empresa}</td>
	</tr>
	
	{if (($movim == '1') OR ($movim == '3'))}	
		<tr>
			<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Proveedor:</td>
			<td colspan='7' class="grilla-tab-fila-campo" align='left'>{$proveedor}</td>
		</tr>
	{/if}
	{if (($movim == '2') OR ($movim == '4') OR ($movim == '6'))}	
		<tr>
			<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Vendedor:</td>
			<td colspan='7' class="grilla-tab-fila-campo" align='left'>{$vendedor}</td>
		</tr>
	{/if}
	{if ($movim == '6')}	
		<tr>
			<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Folio:</td>
			<td colspan='7' class="grilla-tab-fila-campo" align='left'>{$folio}</td>
		</tr>
	{/if}
	
	
	</tr>
		
{/section}

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Código</td>
	<td class="grilla-tab-fila-titulo" align='center'>Descripción</td>
	<td class="grilla-tab-fila-titulo" align='center'>N/U</td>
	<td class="grilla-tab-fila-titulo" align='center'>Cantidad</td>
	<td class="grilla-tab-fila-titulo" align='center'>Valor</td>
	<td class="grilla-tab-fila-titulo" align='center'>Subneto</td>
	<td class="grilla-tab-fila-titulo" align='center'>Descuento</td>
	<td class="grilla-tab-fila-titulo" align='center'>Subtotal</td>
</tr>

{section name=registros loop=$arrRegistrosDet}
	<tr>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistrosDet[registros].codigo}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistrosDet[registros].descripcion}</td>
		<td class="grilla-tab-fila-campo" align='center'>{$arrRegistrosDet[registros].nu}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistrosDet[registros].cantidad|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistrosDet[registros].valor|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistrosDet[registros].subneto|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistrosDet[registros].descuento|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistrosDet[registros].subtotal|number_format:0:',':'.'}</td>
	</tr>
		
{/section}

<tr>
	<td colspan='3' class="grilla-tab-fila-campo" align='right'><b>Totales:</b></td>
	<td class="grilla-tab-fila-campo" align='right'><b>{$TOTAL_CANTIDAD|number_format:0:',':'.'}</b></td>
	<td class="grilla-tab-fila-campo" align='right'><b>{$TOTAL_VALOR|number_format:0:',':'.'}</b></td>
	<td class="grilla-tab-fila-campo" align='right'><b>{$TOTAL_SUBNETO|number_format:0:',':'.'}</b></td>
	<td class="grilla-tab-fila-campo" align='right'><b>{$TOTAL_DESCUENTO|number_format:0:',':'.'}</b></td>
	<td class="grilla-tab-fila-campo" align='right'><b>{$TOTAL_SUBTOTAL|number_format:0:',':'.'}</b></td>
</tr>
<tr>
	<td colspan='8' class="grilla-tab-fila-titulo">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
	</td>
</tr>

</table>
</div>



