<div id="pivot">

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='14' class="grilla-tab-fila-titulo" align='center'><b>Informe de Precargas al {$smarty.now|date_format:"%d/%m/%Y"}</b></td>
</tr>
<tr>
	<td colspan='4' class="grilla-tab-fila-titulo" align='left'>Periodo:</td>
	<td colspan='10' class="grilla-tab-fila-campo" align='left'>Desde: {$DESDE} hasta {$HASTA}</td>
</tr>
<tr>
	<td colspan='4' class="grilla-tab-fila-titulo" align='left'>Vendedor:</td>
	<td colspan='10' class="grilla-tab-fila-campo" align='left'>{$VENDEDOR}</td>
</tr>

	<tr>
		<td class="grilla-tab-fila-titulo" align='center'></td>
		<td class="grilla-tab-fila-titulo" align='center' style="width: 5%">Item</td>
		<td class="grilla-tab-fila-titulo" align='center' style="width: 5%">Folio</td>
		<td class="grilla-tab-fila-titulo" align='center' style="width: 5%">Sector</td>
		<td class="grilla-tab-fila-titulo" align='center' style="width: 10%">Fecha</td>
		<td colspan='5' class="grilla-tab-fila-titulo" align='center' style="width: 75%">Cliente</td>
	</tr>
{section name=registros loop=$arrRegistros}
	<tr>
		
		{if ($arrRegistros[registros].estado_venta == 'POR APROBAR')}
			<td class="grilla-tab-fila-campo">
				<a href="#" style="cursor: hand;"><img  src="../images/estados/aprobar.png" border=0 title="Venta Por Aprobar"></a>
				<br>
				APR
			</td>
		{/if}
		
		<td class="grilla-tab-fila-campo" align='center'><b>{$arrRegistros[registros].item}</b></td>
		<td class="grilla-tab-fila-campo" align='right'><b>{$arrRegistros[registros].folio}</b></td>
		<td class="grilla-tab-fila-campo" align='right'><b>{$arrRegistros[registros].sector}</b></td>
		<td class="grilla-tab-fila-campo" align='right'><b>{$arrRegistros[registros].fecha_tarjeta}</b></td>
		<td colspan='5' class="grilla-tab-fila-campo" align='left'><b>{$arrRegistros[registros].cliente}</b></td>
	</tr>
	
	<!-- encabezado de los articulos -->
	<tr> 
		<td colspan='3' class="grilla-tab-fila-campo-pequenio"></td>
		<td class="grilla-tab-fila-campo-pequenio" align='center'>Código</td>
		<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='center'>Descripción</td>
		<td class="grilla-tab-fila-campo-pequenio" align='center'>Observacion</td>
		<td class="grilla-tab-fila-campo-pequenio" align='center'>Cant.</td>
		<td class="grilla-tab-fila-campo-pequenio" align='center'>Pend. Entrega</td>
		<td class="grilla-tab-fila-campo-pequenio" align='center'>Tiempo Espera</td>
		<td class="grilla-tab-fila-campo-pequenio" align='center'>N/U</td>
	</tr>
	{section name=detalle loop=$arrDetalle}
		{if ($arrRegistros[registros].ncorr == $arrDetalle[detalle].ncorr)}
			<tr> 
				<td colspan='3' class="grilla-tab-fila-campo-pequenio"></td>
				<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].codigo}</td>
				<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='left'>{$arrDetalle[detalle].descripcion}</td>
                <td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].observacion}</td>
				<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].cantidad|number_format:0:',':'.'}</td>
				<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].pend_entrega|number_format:0:',':'.'}</td>
				{if ($arrDetalle[detalle].estado == 'PENDIENTE')}
					<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].tiempo_espera|number_format:0:',':'.'} días</td>
				{/if}
				{if ($arrDetalle[detalle].estado == 'ENTREGADO')}
					<td class="grilla-tab-fila-campo-pequenio" align='center'>
						<label class="requerido">
							{$arrDetalle[detalle].estado} {$arrDetalle[detalle].fecha_ult_carga|date_format:"%d/%m/%Y %H:%M:%S"}
						</label>
					</td>
				{/if}
				
				<td class="grilla-tab-fila-campo-pequenio" align='center'>{$arrDetalle[detalle].nu}</td>
			</tr>
		{/if}
	{/section}
	
	<!--
	<tr> 
		<td colspan='12'>
			<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
				{section name=detalle loop=$arrDetalle}
					{if ($arrRegistros[registros].ncorr == $arrDetalle[detalle].ncorr)}
						<tr> 
							<td colspan='4' class="grilla-tab-fila-campo-pequenio"></td>
							<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].codigo}</td>
							<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='left'>{$arrDetalle[detalle].descripcion}</td>
							<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].cantidad|number_format:0:',':'.'}</td>
							<td class="grilla-tab-fila-campo-pequenio" align='center'>{$arrDetalle[detalle].nu}</td>
						</tr>
					{/if}
				{/section}
			</table>
		</td>
	</tr>
	-->
	
	<tr>
		<td colspan='14'  class="grilla-tab-fila-campo"></td>
	</tr>
		
{/section}

<!--
<tr>
	<td colspan='3' class="grilla-tab-fila-campo" align='right'><b>Total Artículos:</b></td>
	<td colspan='11' class="grilla-tab-fila-campo" align='left'><b>{$TOTAL_ARTICULOS|number_format:0:',':'.'}</b></td>
</tr>
<tr>
	<td colspan='3' class="grilla-tab-fila-campo" align='right'><b>Total Tarjetas:</b></td>
	<td colspan='11' class="grilla-tab-fila-campo" align='left'><b>{$TOTAL_TARJETAS|number_format:0:',':'.'}</b></td>
</tr>
<tr>
	<td colspan='3' class="grilla-tab-fila-campo" align='right'><b>Total Ventas:</b></td>
	<td colspan='11' class="grilla-tab-fila-campo" align='left'><b>{$TOTAL_VENTAS|number_format:0:',':'.'}</b></td>
</tr>
-->

<tr>
	<td colspan='14' class="grilla-tab-fila-titulo">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divresultado');">
		<input type="button" name="btnImprimir" value="Imprimir Formulario Carga" class="boton" onclick="ImprimeDiv('divresultadocarga');">
		<!--<input type="button" name="btnExportar" value="Exportar a Excel" class="boton" onclick="enviaPivotExcel('Form1');">!-->
	</td>
</tr>

</table>
</div>