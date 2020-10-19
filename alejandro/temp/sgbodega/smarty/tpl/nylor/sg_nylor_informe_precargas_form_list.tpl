<div id="pivot">

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='14' class="grilla-tab-fila-titulo" align='center'><b>Informe para Carga {$smarty.now|date_format:"%d/%m/%Y"}</b></td>
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
		<td colspan='6' class="grilla-tab-fila-titulo" align='center' style="width: 75%">Cliente</td>
	</tr>
{section name=registros loop=$arrRegistros}
	{if ($arrRegistros[registros].folio_entregado == 'NO')}
    	{if ($arrRegistros[registros].fila_pendiente > 0)}	
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
				<td colspan='6' class="grilla-tab-fila-campo" align='left'><b>{$arrRegistros[registros].cliente}</b></td>
		</tr>
		
		<!-- encabezado de los articulos -->
		<tr> 
			<td colspan='3' class="grilla-tab-fila-campo-pequenio"></td>
			<td class="grilla-tab-fila-campo-pequenio" align='center'>Código</td>
			<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='center'>Descripción</td>
			<td class="grilla-tab-fila-campo-pequenio" align='center'>Observacion</td>
            <td class="grilla-tab-fila-campo-pequenio" align='center'>Cant.</td>
			<td class="grilla-tab-fila-campo-pequenio" align='center'>Pend. Entrega</td>
			<td class="grilla-tab-fila-campo-pequenio" align='center'>Cant. Cargada</td>
			<td colspan='10' class="grilla-tab-fila-campo-pequenio" align='center'>N/U</td>
		</tr>
		{section name=detalle loop=$arrDetalle}
			{if ($arrRegistros[registros].ncorr == $arrDetalle[detalle].ncorr)}
				
					<tr> 
						<td colspan='3' class="grilla-tab-fila-campo-pequenio"></td>
						<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].codigo}</td>
						<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='left'>{$arrDetalle[detalle].descripcion}</td>
                        <td colspan='1' class="grilla-tab-fila-campo-pequenio" align='left'>{$arrDetalle[detalle].observacion}</td>
						<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].cantidad|number_format:0:',':'.'}</td>
						<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].pend_entrega|number_format:0:',':'.'}</td>
						{if ($arrDetalle[detalle].estado == 'PENDIENTE')}
                            <td class="grilla-tab-fila-campo-pequenio" align='right'>
                            	<INPUT type="text" id="txt" name="txt" value='' maxLength="5" style="width: 98%">
                            </td>
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
		
		<tr>
			<td colspan='14'  class="grilla-tab-fila-campo"></td>
		</tr>
	
	{/if}
	{/if}
	
{/section}


</table>
</div>