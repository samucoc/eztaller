<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td style="width: 20%" class="grilla-tab-fila-titulo">Código</td>
	<td style="width: 80%" class="grilla-tab-fila-titulo">Descripción</td>
</tr>
{section name=registros loop=$arrRegistros}
	<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
		<td style="width: 20%" class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}','{$arrRegistros[registros].desc}');">{$arrRegistros[registros].ncorr}</a></td>
		<td style="width: 80%" class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}','{$arrRegistros[registros].desc}');">{$arrRegistros[registros].desc}</a></td>
	</tr>
{/section}

</table>
