<div id="pivot">

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='14' class="grilla-tab-fila-titulo" align='center'><b>Informe de Precargas al {$smarty.now|date_format:"%d/%m/%Y"}</b></td>
</tr>
{section name=vendedor loop=$arrRegistrosVend}
		
		<tr>
			<td colspan='3' class="grilla-tab-fila-titulo" align='left'>Vendedor:</td>
			<td colspan='11' class="grilla-tab-fila-campo" align='left'>{$arrRegistrosVend[vendedor].ncorr} - {$arrRegistrosVend[vendedor].nombre}</td>
		</tr>

		<tr>
			<td class="grilla-tab-fila-titulo" align='center'></td>
			<td class="grilla-tab-fila-titulo" align='center' >Item</td>
			<td class="grilla-tab-fila-titulo" align='center' >Folio</td>
			<td class="grilla-tab-fila-titulo" align='center' >Empresa</td>
			<td class="grilla-tab-fila-titulo" align='center' >Sector</td>
			<td class="grilla-tab-fila-titulo" align='center' >Fecha</td>
			<td class="grilla-tab-fila-titulo" align='center'>Cliente</td>
			<td class="grilla-tab-fila-titulo" align='center'>Código</td>
			<td class="grilla-tab-fila-titulo" align='center'>Descripción</td>
			<td class="grilla-tab-fila-titulo" align='center'>Observacion</td>
			<td class="grilla-tab-fila-titulo" align='center'>Cant.</td>
			<td class="grilla-tab-fila-titulo" align='center'>Pedido</td>
			<td class="grilla-tab-fila-titulo" align='center'>Despachado</td>
			<td class="grilla-tab-fila-titulo" align='center'>Acciones</td>
			<td class="grilla-tab-fila-titulo" align='center'>N/U</td>
		</tr>
	{section name=registros loop=$arrRegistros}
	{if ($arrRegistros[registros].cod_vendedor == $arrRegistrosVend[vendedor].ncorr)}
		{section name=detalle loop=$arrDetalle}
			{if ($arrRegistros[registros].ncorr == $arrDetalle[detalle].ncorr)}
			<tr>
				{if ($arrRegistros[registros].estado_venta == 'POR APROBAR')}
					<td class="grilla-tab-fila-campo">
						<a href="#" style="cursor: hand;"><img  src="../../sgyonley/images/estados/aprobar.png" border=0 title="Venta Por Aprobar"></a>
						<br>
						APR
					</td>
				{/if}
		
			<td class="grilla-tab-fila-campo" align='center'><b>{$arrRegistros[registros].item}</b></td>
			<td class="grilla-tab-fila-campo" align='right'>
				<b>
					<a href="#" onclick="showPopWin('sg_ventas_revisar_preventas_informe_hv.php?folio={$arrRegistros[registros].folio}', 'Revision', 800, 600, null);" >{$arrRegistros[registros].folio}
					</a>
				</b></td>
			<td class="grilla-tab-fila-campo" align='right'><b>{$arrRegistros[registros].empresa}</b></td>
            <td class="grilla-tab-fila-campo" align='right'><b>{$arrRegistros[registros].sector}</b></td>
			<td class="grilla-tab-fila-campo" align='right'><b>{$arrRegistros[registros].fecha_tarjeta}</b></td>
			<td class="grilla-tab-fila-campo" align='left'><b>{$arrRegistros[registros].cliente}</b></td>
	
			<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].codigo}</td>
			<td class="grilla-tab-fila-campo-pequenio" align='left'>{$arrDetalle[detalle].descripcion}</td>
		        <td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].observacion}</td>
			<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].cantidad|number_format:0:',':'.'}</td>
			<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].pedido|date_format:"%d/%m/%Y"}</td>
			<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].despachado|date_format:"%d/%m/%Y"}</td>
			<td class="grilla-tab-fila-campo-pequenio" align='center'>
				{if ($arrRegistros[registros].usuario == 'mdiaz') || ($arrRegistros[registros].usuario == 'jruz')}
                        <a href="#" onclick="xajax_Pedido(xajax.getFormValues('Form1'),{$arrRegistros[registros].folio},{$arrDetalle[detalle].codigo});" title="Pedido" ><img src="../../sgyonley/images/pedido.png" title="Pedido" /></a>
                {/if}
                {if (($arrRegistros[registros].usuario == 'imolina') || ($arrRegistros[registros].usuario == 'fballadares')|| ($arrRegistros[registros].usuario == 'jruz')) }
						<a href="#" onclick="xajax_Despacho(xajax.getFormValues('Form1'),{$arrRegistros[registros].folio},{$arrDetalle[detalle].codigo});" title="Despachado" ><img src="../../sgyonley/images/despachado.png" title="Despachado" /></a>
                {/if}
                {if (($arrRegistros[registros].usuario == 'ofernandez') || ($arrRegistros[registros].usuario == 'jruz'))} 
						<a href="#" onclick="xajax_Aprobado(xajax.getFormValues('Form1'),{$arrRegistros[registros].folio},{$arrDetalle[detalle].codigo});" title="Aprobado" ><img src="../../sgyonley/images/aprobado.png" title="Aprobado" /></a>
                {/if}
                		<a href="#" onclick="xajax_Historial(xajax.getFormValues('Form1'),{$arrRegistros[registros].folio},{$arrDetalle[detalle].codigo});" title="Historial" ><img src="../../sgyonley/images/historial.png" title="Historial" /></a>
			</td>
				
			<td class="grilla-tab-fila-campo-pequenio" align='center'>{$arrDetalle[detalle].nu}</td>
				</tr>
			{/if}
		{/section}
	{/if}
	{/section}
{/section}
	
	<tr>
		<td colspan='14'  class="grilla-tab-fila-campo"></td>
	</tr>

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
		<input type="button" name="btnPdf" value="Generar PDF" class="boton" onclick="showPopWin('sg_nylor_informe_precargas_2_imprimir.php?VENDEDOR={$VENDEDOR}', 'Informe Precargas', 800, 600, null);">
	</td>
</tr>

</table>
</div>
