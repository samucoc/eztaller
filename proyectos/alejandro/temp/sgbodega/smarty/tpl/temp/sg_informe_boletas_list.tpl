<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Empresa</td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
	<td class="grilla-tab-fila-titulo" align='center'>Mes Contable</td>
	<td class="grilla-tab-fila-titulo" align='center'>Nro Boleta</td>
	<td class="grilla-tab-fila-titulo" align='center'>Monto</td>
	<td class="grilla-tab-fila-titulo" align='center'></td>

    </tr>
	

{section name=registros loop=$arrRegistros}
        <tr>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].empresa}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].fecha|date_format:"%d/%m/%Y"}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].mes_contable}</td>
        <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].nro_boleta}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].monto}</td>
		<td class="grilla-tab-fila-campo" align='left'>
        	{if $arrRegistros[registros].cierre =='SI'}
            <a href="#" onclick="xajax_Eliminar(xajax.getFormValues('Form1'),{$arrRegistros[registros].ncorr})">Eliminar</a>
            {else}
            No Aplica
            {/if}
        </td>
		</tr>
{/section}

<tr>
	<tr>
    <td class="grilla-tab-fila-titulo" align='center'>Total</td>
    <td class="grilla-tab-fila-campo" align='right' colspan="4"><label id="total" name="total">0</label></td>
    </tr>
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



