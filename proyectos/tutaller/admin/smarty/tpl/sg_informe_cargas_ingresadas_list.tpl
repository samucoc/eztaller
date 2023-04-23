<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'vehiculo');">Vehiculo</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'persona');">Trabajador</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'debe');">Abonos</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'haber');">Cargos</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'fecha');">Fecha</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'tipo');">Tipo de Carga</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'boleta');">Boleta</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'observacion');">Observacion</a></td>
	<td class="grilla-tab-fila-titulo" align='center' colspan='2'>Accion</td>
	</tr>	

{section name=registros loop=$arrRegistros}
        {if (($arrRegistros[registros].vehiculo!='')&&($arrRegistros[registros].debe!='')&&($arrRegistros[registros].haber!='')&&($arrRegistros[registros].fecha!='')&&($arrRegistros[registros].tipo!=''))}
        <tr>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].vehiculo}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].persona}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].haber}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].debe}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].fecha|date_format:"%d/%m/%Y"}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].tipo}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].boleta}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].observacion}</td>
		{if (($arrRegistros[registros].fecha_dig|date_format:"%Y-%m-%d"==$smarty.now|date_format:"%Y-%m-%d")&&($arrRegistros[registros].tipo!='Extra'))}
            <td class="grilla-tab-fila-campo">
                <a href="#" onclick="showPopWin('sg_informe_cargas_ingresadas_modificar.php?ncorr={$arrRegistros[registros].ncorr}', 'Modificar Carga', 800, 600, null);" >Modificar Carga</a>
            </td>
            <td class="grilla-tab-fila-campo">
                <a href="scripts/eliminar_carga.php?id_carga={$arrRegistros[registros].ncorr}" >Eliminar Carga</a>
            </td>
        {else}
            <td class="grilla-tab-fila-campo" colspan='2'>
                Sin Accion   
            </td>
        {/if}
        </tr>
        {/if}
{/section}

<tr>
	<td colspan='17' class="grilla-tab-fila-titulo">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>
</table>
</div>



