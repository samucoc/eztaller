<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='16' class="grilla-tab-fila-titulo" align='center'><b>Movimientos Mensuales al {$smarty.now|date_format:"%d/%m/%Y"}</b></td>
</tr>

<tr>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'familia');">Familia</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'subfamilia');">SubFamilia</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'descripcion');">Descripcion</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'codigo');">Codigo</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'codigo_antiguo');">Codigo Antiguo</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'stock_nuevo');">Stock Nuevo</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'stock_usa');">Stock Usado</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'ventas_men_nuevo');">Ventas Ultimo Mes Stock Nuevo</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'ventas_men_usa');">Ventas Ultimo Mes Stock Usado</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'ventas_tri_nuevo');">Ventas Promedio Ultimos 3 Meses Stock Nuevo</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'ventas_tri_usa');">Ventas Promedio Ultimos 3 Meses Stock Usado</a></td>
</tr>

{section name=registros loop=$arrRegistros}
    {if $arrRegistros[registros].ventas_tri_no_estado == 'SI'}
        <tr>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].familia}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].subfamilia}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].descripcion}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].codigo}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].codigo_antiguo}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].stock_nuevo|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].stock_usa|number_format:0:',':'.'}</td>
                {if $arrRegistros[registros].ventas_men_estado == 'SI'}
                    <td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].ventas_men_nuevo|number_format:0:',':'.'}</td>
                    <td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].ventas_men_usa|number_format:0:',':'.'}</td>
                {else}
                    <td class="grilla-tab-fila-campo" align='right'>No Aplica</td>
                    <td class="grilla-tab-fila-campo" align='right'>No Aplica</td>
                {/if}
                
                {if $arrRegistros[registros].ventas_tri_estado == 'SI'}
                    <td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].ventas_tri_nuevo|number_format:0:',':'.'}</td>
                    <td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].ventas_tri_usa|number_format:0:',':'.'}</td>
                {else}
                    <td class="grilla-tab-fila-campo" align='right'>No Aplica</td>
                    <td class="grilla-tab-fila-campo" align='right'>No Aplica</td>
                {/if}                
	</tr>
    {/if}
{/section}

<tr>
	<td colspan='16' class="grilla-tab-fila-titulo">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">
	</td>
</tr>
</table>
</div>



