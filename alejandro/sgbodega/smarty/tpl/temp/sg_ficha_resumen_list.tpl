<div id="pivot">
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Rut</td>
		<td class="grilla-tab-fila-titulo" align='center'>Nombres</td>
		<td class="grilla-tab-fila-titulo" align='center'>Apellido Paterno</td>
		<td class="grilla-tab-fila-titulo" align='center'>Apellido Materno</td>
		<td class="grilla-tab-fila-titulo" align='center'>Fecha Nacimiento</td>
		<td class="grilla-tab-fila-titulo" align='center'>Parentesco</td>
		<td class="grilla-tab-fila-titulo" align='center'>Estado</td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].rut}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].nombre}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].apellido_paterno}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].apellido_materno}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].fec_nac|date_format:"%d/%m/%Y"}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].parentesco}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].estado}</td>
		</tr>
	{/section}

</table>
</div>