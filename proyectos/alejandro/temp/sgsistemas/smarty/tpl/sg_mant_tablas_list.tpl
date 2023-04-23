<div id="pivot">
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

{if ($TBL == 'cuentas')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Código</td>
		<td class="grilla-tab-fila-titulo" align='center'>Número</td>
		<td class="grilla-tab-fila-titulo" align='center'>Descripción</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].ncorr}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].numero}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].desc}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/cross.png" border=0 title="Eliminar" onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');"></a>
			</td>
		</tr>
	{/section}
	
{else}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Código</td>
		<td class="grilla-tab-fila-titulo" align='center'>Cuenta</td>
		<td class="grilla-tab-fila-titulo" align='center'>Sub Cuenta</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].ncorr}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].cuenta}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].desc}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/cross.png" border=0 title="Eliminar" onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');"></a>
			</td>
		</tr>
	{/section}
{/if}

</table>
</div>