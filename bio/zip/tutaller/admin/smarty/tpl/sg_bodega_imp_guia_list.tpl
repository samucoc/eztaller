<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%" style="font-size:8px !important;">

{section name=registros loop=$arrRegistros}
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Fecha:</td>
		<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'>{$arrRegistros[registros].fecha}</td>
	</tr>
	{if (($movim == '1') OR ($movim == '3'))}	
		<tr>
			<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Proveedor:</td>
			<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'>{$proveedor}</td>
		</tr>
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>OC:</td>
		<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'>{$oc}</td>
	</tr>
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Factura:</td>
		<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'>{$factura}</td>
	</tr>
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Guia Despacho:</td>
		<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'>{$guia_despacho}</td>
	</tr>
	
	{/if}
    <tr>
		<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Gu�a:</td>
		<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'>{$arrRegistros[registros].guia}</td>
	</tr>	
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Movimiento:</td>
		<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'>{$arrRegistros[registros].movimiento}</td>
	</tr>
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Bodega:</td>
		<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'>{$bodega}</td>
	</tr>
	{if ($movim == '9')}	
		<tr>
			<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Trabajador:</td>
			<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'>{$trabajador}</td>
		</tr>
	{/if}
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Observaci�n:</td>
		<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'>{$arrRegistros[registros].obs}</td>
	</tr>
	
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Usuario:</td>
		<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'>{$arrRegistros[registros].usuario}</td>
	</tr>
	<tr>	
		<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Empresa:</td>
		<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'>{$arrRegistros[registros].empresa}</td>
	</tr>
	{if (($movim == '2') OR ($movim == '4') OR ($movim == '6'))}	
		<tr>
			<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Trabajador:</td>
			<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'>{$vendedor}</td>
		</tr>
		<tr>
			<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Patente:</td>
			<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'>{$vendedor}</td>
		</tr>
		{/if}
	{if ($movim == '6')}	
		<tr>
			<td colspan='1' class="grilla-tab-fila-titulo-pequenio" align='left'>Folio:</td>
			<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'>{$folio}</td>
		</tr>
	{/if}
	
	
	</tr>

<tr>
	<td class="grilla-tab-fila-titulo-pequenio" align='center'>Codigo</td>
	<td class="grilla-tab-fila-titulo-pequenio" align='center'>Descripcion</td>
	<td class="grilla-tab-fila-titulo-pequenio" align='center'>Cantidad</td>
</tr>

{section name=registrosDet loop=$arrRegistrosDet}
	<tr>
		<td class="grilla-tab-fila-campo-pequenio" align='left'>{$arrRegistrosDet[registrosDet].codigo}</td>
		<td class="grilla-tab-fila-campo-pequenio" align='left'>{$arrRegistrosDet[registrosDet].descripcion}</td>
		<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrRegistrosDet[registrosDet].cantidad|number_format:0:',':'.'}</td>
	
	</tr>
		
{/section}

<tr>
	<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='right'><b>Totales:</b></td>
	<td class="grilla-tab-fila-campo-pequenio" align='right'><b>{$TOTAL_CANTIDAD|number_format:0:',':'.'}</b></td>
</tr>
</table>

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td style="padding-top:50px" colspan='1' class="grilla-tab-fila-campo-pequenio" align="center">______________________</td>
	<td style="padding-top:50px" colspan='1' class="grilla-tab-fila-campo-pequenio" align="center">______________________</td>
	<td style="padding-top:50px" colspan='1' class="grilla-tab-fila-campo-pequenio" align="center">______________________</td>
	<td style="padding-top:50px" colspan='1' class="grilla-tab-fila-campo-pequenio" align="center">______________________</td>
</tr>
<tr>
	<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='center'>{$arrRegistros[registros].usuario}</td>
	<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='left'>Nombre :</td>
	<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='left'>Nombre :</td>
	<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='left'>Nombre :</td>
</tr>
<tr>
	<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='center'>Firma Emisor</td>
	<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='center'>Firma Revisor</td>
	<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='center'>Firma Receptor</td>
	<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='center'>Firma Chofer</td>
</tr>

<tr>
	<td colspan='8' class="grilla-tab-fila-titulo-pequenio">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
	</td>
</tr>
{/section}

</table>
</div>



