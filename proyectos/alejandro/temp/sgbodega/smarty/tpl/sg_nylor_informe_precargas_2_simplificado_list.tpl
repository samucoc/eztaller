<div id="pivot">

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='14' class="grilla-tab-fila-titulo" align='center'><b>Informe de Precargas al {$smarty.now|date_format:"%d/%m/%Y"}</b></td>
</tr>
		
		<tr>
			<td colspan='3' class="grilla-tab-fila-titulo" align='left'>Producto:</td>
			<td colspan='11' class="grilla-tab-fila-campo" align='left'>{$cod_producto} - {$descr_producto}</td>
		</tr>

		<tr>
			<td class="grilla-tab-fila-titulo" align='center' >Empresa</td>
			<td class="grilla-tab-fila-titulo" align='center' >Folio</td>
			<td class="grilla-tab-fila-titulo" align='center' >Sector</td>
			<td class="grilla-tab-fila-titulo" align='center' >Fecha</td>
			<td class="grilla-tab-fila-titulo" align='center'>Cliente</td>
			<td class="grilla-tab-fila-titulo" align='center'>Código</td>
			<td class="grilla-tab-fila-titulo" align='center'>Descripción</td>
			<td class="grilla-tab-fila-titulo" align='center'>Observacion</td>
			<td class="grilla-tab-fila-titulo" align='center'>Cant.</td>
			<td class="grilla-tab-fila-titulo" align='center'>N/U</td>
			<td class="grilla-tab-fila-titulo" align='center'>Despachado</td>
			<td class="grilla-tab-fila-titulo" align='center'>Vendedor</td>
		</tr>
	{section name=registros loop=$arrRegistros}
		{section name=detalle loop=$arrDetalle}
			{if ($arrRegistros[registros].ncorr == $arrDetalle[detalle].folio)}
		            <tr>
                        <td class="grilla-tab-fila-campo" align='right'><b>{$arrRegistros[registros].empresa}</b></td>
                        <td class="grilla-tab-fila-campo" align='right'>
                            <b>
                                <a href="#" onclick="showPopWin('sg_ventas_revisar_preventas_informe_hv.php?folio={$arrRegistros[registros].folio}', 'Revision', 800, 600, null);" >{$arrRegistros[registros].folio}
                                </a>
                            </b></td>
                        <td class="grilla-tab-fila-campo" align='right'><b>{$arrRegistros[registros].sector}</b></td>
                        <td class="grilla-tab-fila-campo" align='right'><b>{$arrRegistros[registros].fecha_tarjeta}</b></td>
                        <td class="grilla-tab-fila-campo" align='left'><b>{$arrRegistros[registros].cliente}</b></td>
                        <td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].codigo}</td>
                        <td class="grilla-tab-fila-campo-pequenio" align='left'>{$arrDetalle[detalle].descripcion}</td>
                        <td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].observacion}</td>
                        <td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].cantidad|number_format:0:',':'.'}</td>
                        <td class="grilla-tab-fila-campo-pequenio" align='center'>{$arrDetalle[detalle].nu}</td>
                        <td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrDetalle[detalle].despachado|date_format:"%d/%m/%Y"}</td>
                        <td class="grilla-tab-fila-campo-pequenio" align='center'>{$arrRegistros[registros].cod_vendedor} -- {$arrRegistros[registros].nombre_vendedor}</td>
    	   	{/if}
		{/section}
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
		<!--<input type="button" name="btnPdf" value="Generar PDF" class="boton" onclick="showPopWin('sg_nylor_informe_precargas_2_imprimir.php?VENDEDOR={$VENDEDOR}', 'Informe Precargas', 800, 600, null);">-->
		<input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
		<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('form1');" />
		<iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>

</table>
</div>
