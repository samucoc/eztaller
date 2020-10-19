<div id="pivot">

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

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
		<td class="grilla-tab-fila-campo-pequenio" align='center'>Cant. Cargada</td>
		<td class="grilla-tab-fila-campo-pequenio" align='center'>N/U</td>
	</tr>
	
	{section name=detalle loop=$arrDetalle}
		{if ($arrRegistros[registros].ncorr == $arrDetalle[detalle].ncorr)}
			<tr> 
				<td colspan='3' class="grilla-tab-fila-campo-pequenio"></td>
				<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].codigo}</td>
				<td colspan='1' class="grilla-tab-fila-campo-pequenio" align='left'>{$arrDetalle[detalle].descripcion}</td>
				<td class="grilla-tab-fila-campo-pequenio" align='center'>{$arrDetalle[detalle].observacion}</td>
				<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].cantidad|number_format:0:',':'.'}</td>
				<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].pend_entrega|number_format:0:',':'.'}</td>
				
				{if ($arrDetalle[detalle].estado == 'PENDIENTE')}
					<td class="grilla-tab-fila-campo-pequenio" style="width: 5%">
						<INPUT type="text" id="{$arrDetalle[detalle].ncorr_art}txtCantCarg" name="{$arrDetalle[detalle].ncorr_art}txtCantCarg" value='0' onKeyPress="return SoloNumeros(this, event, 0)" onchange="xajax_VerificaCantidad(xajax.getFormValues('Form1'),'{$arrDetalle[detalle].ncorr_art}txtCantCarg','{$arrDetalle[detalle].pend_entrega}', '{$arrDetalle[detalle].codigo}', '{$arrDetalle[detalle].descripcion}');" maxLength="5" size="5">
					</td>
				{/if}
				{if ($arrDetalle[detalle].estado == 'ENTREGADO')}
					<td class="grilla-tab-fila-campo-pequenio" align='center' style="width: 5%"><label class="requerido">{$arrDetalle[detalle].estado}</label></td>
				{/if}
				
				<td class="grilla-tab-fila-campo-pequenio" align='center'>{$arrDetalle[detalle].nu}</td>
			</tr>
		{/if}
	{/section}
	
	<tr>
		<td colspan='14'  class="grilla-tab-fila-campo"></td>
	</tr>
		
{/section}

<tr>
	<td colspan='14' class="grilla-tab-fila-titulo">
		<input type="button" name="btnGrabar" value="Grabar" class="boton" onclick="xajax_IngresaCargas(xajax.getFormValues('Form1'));">
	</td>
</tr>

</table>
</div>