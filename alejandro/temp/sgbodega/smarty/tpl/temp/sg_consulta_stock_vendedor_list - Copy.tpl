<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='18' class="grilla-tab-fila-titulo" align='center'><b>Consulta Stock Vendedor al {$smarty.now|date_format:"%d/%m/%Y"}</b></td>
</tr>

<tr>
	<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Empresa:</td>
	<td colspan='17' class="grilla-tab-fila-campo" align='left'>{$EMPRESA}</td>
</tr>
<tr>
	<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Vendedor:</td>
	<td colspan='17' class="grilla-tab-fila-campo" align='left'>{$COBRADOR}</td>
</tr>

<tr>
	<td colspan='4' class="grilla-tab-fila-titulo" align='center'></td>
	<td colspan='2' class="grilla-tab-fila-titulo" align='center'>Valor</td>
	<td colspan='2' class="grilla-tab-fila-titulo" align='center'>Inicial</td>
	<td colspan='2' class="grilla-tab-fila-titulo" align='center'>Aumentos</td>
	<td colspan='2' class="grilla-tab-fila-titulo" align='center'>Ventas</td>
	<td colspan='2' class="grilla-tab-fila-titulo" align='center'>Rebajas</td>
	<td colspan='2' class="grilla-tab-fila-titulo" align='center'>Nulas</td>
	<td colspan='2' class="grilla-tab-fila-titulo" align='center'><b>Stock Actual</b></td>

	
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'familia');">Familia</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'subfamilia');">SubFamilia</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'codigo');">Código</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'descripcion');">Descripción</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'valor_n');">N</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'valor_u');">U</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'inicial_n');">N</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'inicial_u');">U</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'aumentos_n');">N</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'aumentos_u');">U</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'ventas_n');">N</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'ventas_u');">U</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'rebajas_n');">N</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'rebajas_u');">U</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'nulas_n');">N</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'nulas_u');">U</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'actual_n');">N</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'actual_u');">U</a></td>
</tr>

{section name=registros loop=$arrRegistros}
	<tr>
		
		<td class="grilla-tab-fila-campo-rev" align='left'>{$arrRegistros[registros].familia}</td>
		<td class="grilla-tab-fila-campo-rev" align='left'>{$arrRegistros[registros].subfamilia}</td>
		<td class="grilla-tab-fila-campo-rev" align='right'>{$arrRegistros[registros].codigo}</td>
		<td class="grilla-tab-fila-campo-rev" align='left'><a href="#" style="cursor: hand;" onclick="xajax_LlamaDetalle(xajax.getFormValues('Form1'), '{$arrRegistros[registros].codigo}', '{$arrRegistros[registros].descripcion}');">{$arrRegistros[registros].descripcion}</a></td>
		<td class="grilla-tab-fila-campo-rev" align='right'>{$arrRegistros[registros].valor_n|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-rev" align='right'>{$arrRegistros[registros].valor_u|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-rev" align='right'>{$arrRegistros[registros].inicial_n|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-rev" align='right'>{$arrRegistros[registros].inicial_u|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-rev" align='right'>{$arrRegistros[registros].aumentos_n|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-rev" align='right'>{$arrRegistros[registros].aumentos_u|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-rev" align='right'>{$arrRegistros[registros].ventas_n|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-rev" align='right'>{$arrRegistros[registros].ventas_u|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-rev" align='right'>{$arrRegistros[registros].rebajas_n|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-rev" align='right'>{$arrRegistros[registros].rebajas_u|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-rev" align='right'>{$arrRegistros[registros].nulas_n|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-rev" align='right'>{$arrRegistros[registros].nulas_u|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-rev" align='right'><b>{$arrRegistros[registros].actual_n|number_format:0:',':'.'}</b></td>
		<td class="grilla-tab-fila-campo-rev" align='right'><b>{$arrRegistros[registros].actual_u|number_format:0:',':'.'}</b></td>
		
	</tr>
		
{/section}
<tr>
	<td colspan='6' class="grilla-tab-fila-titulo" align='right'><B>Totales:</B></td>
	<td class="grilla-tab-fila-campo" align='right'>{$TOTAL_INICIAL_N|number_format:0:',':'.'}</td>
	<td class="grilla-tab-fila-campo" align='right'>{$TOTAL_INICIAL_U|number_format:0:',':'.'}</td>
	<td class="grilla-tab-fila-campo" align='right'>{$TOTAL_AUMENTOS_N|number_format:0:',':'.'}</td>
	<td class="grilla-tab-fila-campo" align='right'>{$TOTAL_AUMENTOS_U|number_format:0:',':'.'}</td>
	<td class="grilla-tab-fila-campo" align='right'>{$TOTAL_VENTAS_N|number_format:0:',':'.'}</td>
	<td class="grilla-tab-fila-campo" align='right'>{$TOTAL_VENTAS_U|number_format:0:',':'.'}</td>
	<td class="grilla-tab-fila-campo" align='right'>{$TOTAL_REBAJAS_N|number_format:0:',':'.'}</td>
	<td class="grilla-tab-fila-campo" align='right'>{$TOTAL_REBAJAS_U|number_format:0:',':'.'}</td>
	<td class="grilla-tab-fila-campo" align='right'>{$TOTAL_NULAS_N|number_format:0:',':'.'}</td>
	<td class="grilla-tab-fila-campo" align='right'>{$TOTAL_NULAS_U|number_format:0:',':'.'}</td>
	<td class="grilla-tab-fila-campo" align='right'><b>{$TOTAL_ACTUAL_N|number_format:0:',':'.'}</b></td>
	<td class="grilla-tab-fila-campo" align='right'><b>{$TOTAL_ACTUAL_U|number_format:0:',':'.'}</b></td>
</tr>

<tr>
	<td colspan='18' class="grilla-tab-fila-titulo">
		<input type="button" name="btnImprimir" value="Imprimir Listado" class="boton" onclick="ImprimeDiv('divabonos');">
		<input type="button" name="btnImprimir" value="Imprimir Listado P/Revisión" class="boton" onclick="ImprimeDiv('divrevision');">
	</td>
</tr>
</table>
</div>



