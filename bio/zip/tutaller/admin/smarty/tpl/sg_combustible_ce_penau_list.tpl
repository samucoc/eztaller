<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'ncorr');">Codigo</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'persona');">Trabajador</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'patente');">Patente</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'monto');">Monto</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'fecha');">Fecha</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'autorizado_por');">Autorizado Por</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'autorizado');">Autorizado</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'tipo');">Tipo</a></td>
	<td class="grilla-tab-fila-titulo" align='center'>Accion</td>
	

{section name=registros loop=$arrRegistros}
        <tr>
            <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].ncorr}</td>
            <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].persona}</td>
            <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].patente}</td>
            <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].monto}</td>
            <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].fecha|date_format:"%d/%m/%Y"}</td>
            <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].autorizado_por}</td>
            <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].autorizado}</td>
            <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].tipo}</td>
            {if $arrRegistros[registros].autorizado=='SI'}
            	<td class="grilla-tab-fila-campo" align='left'>
            		<a href="#" onclick="xajax_RealizarCarga(xajax.getFormValues('Form1'),{$arrRegistros[registros].ncorr},'{$arrRegistros[registros].tipo}')" >Realizar Carga</a>
               		<!-- <a href="#" onclick="xajax_EliminarItem(xajax.getFormValues('Form1'),{$arrRegistros[registros].ncorr},'{$arrRegistros[registros].tipo}')" >Eliminar Carga</a>--></td> 
			{else}
	            <td class="grilla-tab-fila-campo" align='left'>
            		<!-- <a href="#" onclick="xajax_EliminarItem(xajax.getFormValues('Form1'),{$arrRegistros[registros].ncorr},'{$arrRegistros[registros].tipo}')" >Eliminar Carga</a>--></td>
	        {/if}
        </tr>
{/section}

<tr>
	<td colspan='16' class="grilla-tab-fila-titulo">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>
</table>
</div>



