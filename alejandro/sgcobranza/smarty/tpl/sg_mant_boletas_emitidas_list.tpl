<div id="pivot">
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Numero Boleta</td>
		<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
		<td class="grilla-tab-fila-titulo" align='center'>Alumno</td>
		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>
		<td class="grilla-tab-fila-titulo" align='center'>Valor</td>
		<td class="grilla-tab-fila-titulo" align='center'>Estado</td>
		<td class="grilla-tab-fila-titulo" align='center'>Tipo Pago</td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].nro_boleta}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].fecha}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].alumno}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].descripcion}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].valor}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].estado}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].tipo_pago}</td>
		</tr>
	{/section}

	<tr>
	    <td colspan='16' class="grilla-tab-fila-titulo">
    		<a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divresultado');" width="32">
    	</td>
    </tr>
</table>
</div>