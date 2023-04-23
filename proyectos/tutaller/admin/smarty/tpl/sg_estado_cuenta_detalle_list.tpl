<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <td class="grilla-tab-fila-campo" align='center' >Concepto</td>
            <td class="grilla-tab-fila-campo" align='center' >Fecha</td>
            <td class="grilla-tab-fila-campo" align='center' >Monto</td>
            <td class="grilla-tab-fila-campo" align='center' >Usuario</td>
        </tr>
        {section name=detalle loop=$arrRegistros}
            <tr>
                <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[detalle].concepto}</td>
                <td class="grilla-tab-fila-campo" align='left'>
                    {if $arrRegistros[detalle].fecha != 'xxxx'}
	                    {$arrRegistros[detalle].fecha|date_format:"%d/%m/%Y"}
					{else}                    
                    	----
                    {/if}
                </td>
                <td class="grilla-tab-fila-campo" align='left'>
                    {$arrRegistros[detalle].monto}
                </td>
                <td class="grilla-tab-fila-campo" align='left'>
                    {$arrRegistros[detalle].usuario}
                </td>
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



