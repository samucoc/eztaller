<div id="pivot">										
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Nro Boleta</td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
	<td class="grilla-tab-fila-titulo" align='center'>Valor</td>
	<td class="grilla-tab-fila-titulo" align='center'>Tipo de Pago</td>
	<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>

    </tr>
	

{section name=registros loop=$arrRegistros}
        <tr>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].nro_boleta}</td>
       	<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].fecha|date_format:"%d/%m/%Y"}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].valor|number_format:0:".":","}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].tipo_pago}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].descripcion}</td>
		</tr>
{/section}

</table>
</div>



