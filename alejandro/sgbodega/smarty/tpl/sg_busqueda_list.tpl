<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td class="grilla-tab-fila-titulo">Codigo</td>
	<td class="grilla-tab-fila-titulo">Descripcion</td>
</tr>
{section name=registros loop=$arrRegistros}
	<tr>
		<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].codigo}','{$arrRegistros[registros].descripcion}');">{$arrRegistros[registros].codigo}</a></td>
		<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].codigo}','{$arrRegistros[registros].descripcion}');">{$arrRegistros[registros].descripcion}</a></td>
	</tr>
{/section}

</table>
