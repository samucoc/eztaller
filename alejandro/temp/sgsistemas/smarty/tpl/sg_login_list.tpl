<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
{section name=registros loop=$arrRegistros}
	<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
		<td class="grilla-tab-fila-campo">{$arrRegistros[registros].accion}</td>
		<td class="grilla-tab-fila-campo">{$arrRegistros[registros].descripcion}</td>
		<td class="grilla-tab-fila-campo">{$arrRegistros[registros].fecha|date_format:"%d-%m-%Y %H:%M:%S"}</td>
		<td class="grilla-tab-fila-campo">{$arrRegistros[registros].usuario}</td>
		</tr>
{/section}

</table>