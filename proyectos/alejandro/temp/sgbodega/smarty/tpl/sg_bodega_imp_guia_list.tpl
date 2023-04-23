<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%" style="font-size:8px !important;">

{section name=registros loop=$arrRegistros}
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Fecha:</td>
		<td colspan='2' class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].fecha}</td>
	</tr>
	{if (($movim == '1') OR ($movim == '3'))}	
		<tr>
			<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Proveedor:</td>
			<td colspan='2' class="grilla-tab-fila-campo" align='left'>{$proveedor}</td>
		</tr>
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo" align='left'>OC:</td>
		<td colspan='2' class="grilla-tab-fila-campo" align='left'>{$oc}</td>
	</tr>
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Factura:</td>
		<td colspan='2' class="grilla-tab-fila-campo" align='left'>{$factura}</td>
	</tr>
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Guia Despacho:</td>
		<td colspan='2' class="grilla-tab-fila-campo" align='left'>{$guia_despacho}</td>
	</tr>
	
	{/if}
    <tr>
		<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Guía:</td>
		<td colspan='2' class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].guia}</td>
	</tr>	
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Movimiento:</td>
		<td colspan='2' class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].movimiento}</td>
	</tr>
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Bodega:</td>
		<td colspan='2' class="grilla-tab-fila-campo" align='left'>{$bodega}</td>
	</tr>
	{if (($movim == '9'))}	
		<tr>
			<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Trabajador:</td>
			<td colspan='2' class="grilla-tab-fila-campo" align='left'>{$trabajador}</td>
		</tr>
	{/if}
	{if (($movim == '10'))}	
		<tr>
			<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Trabajador:</td>
			<td colspan='2' class="grilla-tab-fila-campo" align='left'>{$trabajador}</td>
		</tr>
	{/if}
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Observación:</td>
		<td colspan='2' class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].obs}</td>
	</tr>
	
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Usuario:</td>
		<td colspan='2' class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].usuario}</td>
	</tr>
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Empresa:</td>
		<td colspan='2' class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].empresa}</td>
	</tr>
	{if (($movim == '2') OR ($movim == '4') OR ($movim == '6'))}	
		<tr>
			<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Vendedor:</td>
			<td colspan='2' class="grilla-tab-fila-campo" align='left'>{$vendedor}</td>
		</tr>
	{/if}
	{if ($movim == '6')}	
		<tr>
			<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Folio:</td>
			<td colspan='2' class="grilla-tab-fila-campo" align='left'>{$folio}</td>
		</tr>
	{/if}
	
	
	</tr>

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Código</td>
	<td class="grilla-tab-fila-titulo" align='center'>Descripción</td>
	<td class="grilla-tab-fila-titulo" align='center'>Cantidad</td>
</tr>

{section name=registrosDet loop=$arrRegistrosDet}
	<tr>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistrosDet[registrosDet].codigo}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistrosDet[registrosDet].descripcion}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistrosDet[registrosDet].cantidad|number_format:0:',':'.'}</td>
	
	</tr>
		
{/section}

<tr>
	<td colspan='2' class="grilla-tab-fila-campo" align='right'><b>Totales:</b></td>
	<td class="grilla-tab-fila-campo" align='right'><b>{$TOTAL_CANTIDAD|number_format:0:',':'.'}</b></td>
</tr>
</table>

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td style="padding-top:50px" colspan='1' class="grilla-tab-fila-campo" align="center">______________________</td>
	<td style="padding-top:50px" colspan='1' class="grilla-tab-fila-campo" align="center">______________________</td>
	<td style="padding-top:50px" colspan='1' class="grilla-tab-fila-campo" align="center">______________________</td>
	<td style="padding-top:50px" colspan='1' class="grilla-tab-fila-campo" align="center">______________________</td>
</tr>
<tr>
	<td colspan='1' class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].usuario}</td>
	<td colspan='1' class="grilla-tab-fila-campo" align='left'>Nombre :</td>
	<td colspan='1' class="grilla-tab-fila-campo" align='left'>Nombre :</td>
	<td colspan='1' class="grilla-tab-fila-campo" align='left'>Nombre :</td>
</tr>
<tr>
	<td colspan='1' class="grilla-tab-fila-campo" align='center'>Firma Emisor</td>
	<td colspan='1' class="grilla-tab-fila-campo" align='center'>Firma Revisor</td>
	<td colspan='1' class="grilla-tab-fila-campo" align='center'>Firma Receptor</td>
	<td colspan='1' class="grilla-tab-fila-campo" align='center'>Firma Chofer</td>
</tr>

<tr>
	<td colspan='8' class="grilla-tab-fila-titulo">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
	</td>
</tr>
{/section}

</table>
</div>



