<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='16' class="grilla-tab-fila-titulo" align='center'><b>Toma de Inventario al {$smarty.now|date_format:"%d/%m/%Y"}</b></td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha Cierre</td>
	<td class="grilla-tab-fila-titulo" align='center'>{$fecha_cierre}</td>
</tr>
</table>

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'familia');">Familia</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'subfamilia');">SubFamilia</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'codigo');">Código</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'descripcion');">Descripción</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'costo');">Precio Costo</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'cantidad');">Bodega Nuevo</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'cantidad_1');">Bodega Usado</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'cantidad_2');">Bodega Servicio Tecnico</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'cantidad_3');">Bodega Reparaciones</a></td>
</tr>

{section name=registros loop=$arrRegistros}
	<tr>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].familia}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].subfamilia}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].codigo}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].descripcion}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].costo}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].cantidad|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].cantidad_1|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].cantidad_2|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].cantidad_3|number_format:0:',':'.'}</td>
	</tr>
		
{/section}
</table>
</div>



