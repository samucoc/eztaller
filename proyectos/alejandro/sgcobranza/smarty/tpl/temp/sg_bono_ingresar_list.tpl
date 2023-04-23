<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td class="grilla-tab-fila-titulo">Fecha</td>
	<td class="grilla-tab-fila-titulo">Trabajador</td>
	<td class="grilla-tab-fila-titulo">Detalle</td>
	<td class="grilla-tab-fila-titulo">Monto</td>
	<td class="grilla-tab-fila-titulo"></td>
</tr>
{section name=registros loop=$arrRegistros}
	<tr>
		<td class="grilla-tab-fila-campo">
        	{$arrRegistros[registros].fecha|date_format:'%d/%m/%Y'}
        </td>
		<td class="grilla-tab-fila-campo">
        	{$arrRegistros[registros].trabajador}
        </td>
		<td class="grilla-tab-fila-campo">
        	{$arrRegistros[registros].detalle}
        </td>
		<td class="grilla-tab-fila-campo">
        	{$arrRegistros[registros].monto}
        </td>
		<td class="grilla-tab-fila-campo">
        	<a href="#" onclick="xajax_Eliminar(xajax.getFormValues('Form1'),{$arrRegistros[registros].codigo})">Eliminar</a>
        </td>
	</tr>
{/section}
	<tr>
		<td class="grilla-tab-fila-campo" colspan="2">
        	<a href="http://192.168.0.50/sgvales/sitio/scripts/enviar_correo_bonos.php?grupo={$grupo}" >Enviar Correo</a>
        </td>
		<td class="grilla-tab-fila-campo" colspan="1">
        	Total
        </td>
		<td class="grilla-tab-fila-campo" colspan="1">
        	{$total}
        </td>
    </tr>
    <tr>
		<td class="grilla-tab-fila-campo" colspan="4">
        <!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
    	</td>
    </tr>
</table>
