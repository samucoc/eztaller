<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'empresa');">Empresa</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'depto');">Departamento</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'tipo_comb');">Tipo de combustible</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'patente');">Patente</a></td>
	<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'trabajador');">Trabajador</a></td>
    <td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'monto');">Monto</a></td>


{section name=registros loop=$arrRegistros}
        <tr>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].empresa}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].depto}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].tipo_comb}</td>
		<td class="grilla-tab-fila-campo" align='left'>
        	{$arrRegistros[registros].patente}
            <input type="hidden" name="patente[]" id="patente_{$arrRegistros[registros].rut_trabajador}"
            value="{$arrRegistros[registros].patente}"/>
            </td>
		<td class="grilla-tab-fila-campo" align='left'>
        	{$arrRegistros[registros].trabajador}
            <input type="hidden" name="rut[]" id="rut_{$arrRegistros[registros].patente}"
            value="{$arrRegistros[registros].rut_trabajador}"/>
        </td>
		<td class="grilla-tab-fila-campo" align='center'>
        	<input type="text" name="monto[]" id="monto_{$arrRegistros[registros].patente}" value="0" style="text-align:right"/></td>
        </tr>
{/section}

<tr>
	<td colspan='16' class="grilla-tab-fila-titulo">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">
        <input type="button" name="btnGrabar" value="Grabar" class="boton" onclick="xajax_GrabarMultiple(xajax.getFormValues('Form1'));">
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>
</table>
</div>



