<div id="pivot">

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='14' class="grilla-tab-fila-titulo" align='center'><b>Autorización de Cargas al {$smarty.now|date_format:"%d/%m/%Y"}</b></td>
</tr>
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'></td>
		<td class="grilla-tab-fila-titulo" align='center' style="width: 5%">Item</td>
		<td class="grilla-tab-fila-titulo" align='center' style="width: 5%">Folio</td>
		<td class="grilla-tab-fila-titulo" align='center' style="width: 5%">Sector</td>
		<td class="grilla-tab-fila-titulo" align='center' style="width: 10%">Cod. Vend.</td>
		<td class="grilla-tab-fila-titulo" align='center' style="width: 25%">Nombre Vendedor</td>
		<td class="grilla-tab-fila-titulo" align='center' style="width: 10%">Fecha</td>
		<td class="grilla-tab-fila-titulo" align='center' style="width: 25%">Cliente</td>
		<td colspan='2' class="grilla-tab-fila-titulo" align='center' style="width: 10%">Total</td>
		<td class="grilla-tab-fila-titulo" align='center' style="width: 10%">Autoriza Carga</td>
	</tr>
{section name=registros loop=$arrRegistros}
	<tr>
		
		{if ($arrRegistros[registros].estado_venta == 'ACTIVA')}
			<td class="grilla-tab-fila-campo">
				<a href="#" style="cursor: hand;"><img  src="../../sgyonley/images/estados/activa.png" border=0 title="Venta Activa"></a>
				<br>
				ACT	
			</td>
		{/if}
		{if ($arrRegistros[registros].estado_venta == 'POR APROBAR')}
			<td class="grilla-tab-fila-campo">
				<a href="#" style="cursor: hand;"><img  src="../../sgyonley/images/estados/aprobar.png" border=0 title="Venta Por Aprobar"></a>
				<br>
				APR
			</td>
		{/if}
		{if ($arrRegistros[registros].estado_venta == 'NULA')}
			<td class="grilla-tab-fila-campo">
				<a href="#" style="cursor: hand;"><img  src="../../sgyonley/images/estados/nula.png" border=0 title="Venta Nula"></a>
				<br>
				NUL
			</td>
		{/if}
		{if ($arrRegistros[registros].estado_venta == 'DE BAJA')}
			<td class="grilla-tab-fila-campo">
				<a href="#" style="cursor: hand;"><img  src="../../sgyonley/images/estados/baja.png" border=0 title="Venta De Baja"></a>
				<br>
				BAJ
			</td>
		{/if}
		{if ($arrRegistros[registros].estado_venta == 'DEVOLUCION')}
			<td class="grilla-tab-fila-campo">
				<a href="#" style="cursor: hand;"><img  src="../../sgyonley/images/estados/devolucion.png" border=0 title="Venta Con Devolución"></a>
				<br>
				DEV
			</td>
		{/if}
		{if ($arrRegistros[registros].estado_venta == 'PAGADA')}
			<td class="grilla-tab-fila-campo">
				<a href="#" style="cursor: hand;"><img  src="../../sgyonley/images/estados/cancelada.png" border=0 title="Venta Cancelada"></a>
				<br>
				CAN
			</td>
		{/if}
		
		<td class="grilla-tab-fila-campo" align='center'><b>{$arrRegistros[registros].item}</b></td>
		<td class="grilla-tab-fila-campo" align='right'><b>{$arrRegistros[registros].folio}</b></td>
		<td class="grilla-tab-fila-campo" align='right'><b>{$arrRegistros[registros].sector}</b></td>
		<td class="grilla-tab-fila-campo" align='right'><b>{$arrRegistros[registros].vend_ncorr}</b></td>
		<td class="grilla-tab-fila-campo" align='left'><b>{$arrRegistros[registros].nombre_vendedor}</b></td>
		<td class="grilla-tab-fila-campo" align='right'><b>{$arrRegistros[registros].fecha_tarjeta}</b></td>
		<td class="grilla-tab-fila-campo" align='left'><b>{$arrRegistros[registros].cliente}</b></td>
		<td colspan='2' class="grilla-tab-fila-campo" align='right'><b>{$arrRegistros[registros].total_venta|number_format:0:',':'.'}</b></td>
		<td valign='middle' class="grilla-tab-fila-campo" align='center'>
			<!--
			<a href="#" style="cursor: hand;"><img  src="../images/Truck-48.png" border=0 title="Autorizar Carga" onClick="xajax_AutorizaCarga(xajax.getFormValues('Form1'), '{$arrRegistros[registros].folio}');"></a>
			<a href="#" style="cursor: hand;"><img  src="../images/accept.png" border=0 title="Autorizar Carga" onClick="xajax_AutorizaCarga(xajax.getFormValues('Form1'), '{$arrRegistros[registros].folio}');"></a>
			-->
			
		</td>
	</tr>
	
	{section name=detalle loop=$arrDetalle}
		{if ($arrRegistros[registros].ncorr == $arrDetalle[detalle].ncorr)}
			<tr> 
				<td colspan='4' class="grilla-tab-fila-campo-pequenio"></td>
				<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].codigo}</td>
				<td colspan='2' class="grilla-tab-fila-campo-pequenio" align='left'>{$arrDetalle[detalle].descripcion}</td>
				<td class="grilla-tab-fila-campo-pequenio" align='left'>{$arrDetalle[detalle].observacion}<textarea name="observacion_{$arrRegistros[registros].folio}_{$arrDetalle[detalle].codigo}" cols="50" rows="2" id="observacion_{$arrRegistros[registros].folio}_{$arrDetalle[detalle].codigo}"></textarea></td>
			  <td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].cantidad|number_format:0:',':'.'}</td>
				<td class="grilla-tab-fila-campo-pequenio" align='center'>{$arrDetalle[detalle].nu}</td>
				<td class="grilla-tab-fila-campo-pequenio" align='center'>
					
					{if ($arrDetalle[detalle].aut == 'NO')}
						<a href="#" style="cursor: hand;"><img  src="../images/accept.png" border=0 title="Autorizar Carga" onClick="xajax_AutorizaCarga(xajax.getFormValues('Form1'), '{$arrRegistros[registros].folio}', '{$arrDetalle[detalle].vdet_ncorr}','{$arrDetalle[detalle].codigo}');"></a>
						<a href="#" style="cursor: hand;"><img  src="../images/cross.png" border=0 title="Eliminar Listado de Carga" onClick="xajax_EliminaCarga(xajax.getFormValues('Form1'), '{$arrRegistros[registros].folio}', '{$arrDetalle[detalle].vdet_ncorr}','{$arrDetalle[detalle].codigo}');"></a>
					{/if}	
					{if ($arrDetalle[detalle].aut == 'SI')}
						<label class="requerido"> AUTORIZADO 
						{$arrDetalle[detalle].fecha_aut|date_format:"%d/%m/%Y %H:%M:%S"}
						</label>
					{/if}	
					
				</td>
			</tr>
		{/if}
	{/section}
	
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
		<!--<input type="button" name="btnExportar" value="Exportar a Excel" class="boton" onclick="enviaPivotExcel('Form1');">!-->
	</td>
</tr>

</table>
</div>


