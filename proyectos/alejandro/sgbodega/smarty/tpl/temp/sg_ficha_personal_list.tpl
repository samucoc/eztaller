<div id="pivot">
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Rut</td>
		<td class="grilla-tab-fila-titulo" align='center'>Nombres</td>
		<td class="grilla-tab-fila-titulo" align='center'>Apellido Paterno</td>
		<td class="grilla-tab-fila-titulo" align='center'>Apellido Materno</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].rut}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].nombre}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].apellido_paterno}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].apellido_materno}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/cross.png" border=0 title="Eliminar" onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');"></a>
			</td>
		</tr>
	{/section}

</table>
</div>