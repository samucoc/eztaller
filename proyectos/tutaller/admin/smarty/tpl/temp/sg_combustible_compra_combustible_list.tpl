<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
	<td class="grilla-tab-fila-titulo" align='center'>Empresa</td>
	<td class="grilla-tab-fila-titulo" align='center'>Tipo Combustible</td>
	<td class="grilla-tab-fila-titulo" align='center'>Monto</td>
	<td class="grilla-tab-fila-titulo" align='center'></td>
	

{section name=registros loop=$arrRegistros}
        <tr>
		<td class="grilla-tab-fila-campo" align='left'>
        	{$arrRegistros[registros].fecha|date_format:"%d/%m/%Y"}
            <input type="hidden" name="fecha[]" value='{$arrRegistros[registros].fecha}'/>
        </td>
		<td class="grilla-tab-fila-campo" align='left'>
        	{$arrRegistros[registros].empresa}
            <input type="hidden" name="empresa[]" value='{$arrRegistros[registros].empresa}'/>
        </td>
		<td class="grilla-tab-fila-campo" align='left'>
        	{$arrRegistros[registros].tipo_com}
            <input type="hidden" name="tipo_com[]" value='{$arrRegistros[registros].tipo_com}'/>
        </td>
		<td class="grilla-tab-fila-campo" align='left'>
        	{$arrRegistros[registros].monto}
            <input type="hidden" name="monto[]" value='{$arrRegistros[registros].monto}'/>
        </td>
		<td class="grilla-tab-fila-campo" align='left'>
        	<a href="#" onclick="xajax_Eliminar(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}'))">Eliminar</a>
        </td>
        </tr>
{/section}

</table>
</div>



