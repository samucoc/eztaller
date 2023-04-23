<div id="pivot">
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Detalle</td>
		<td class="grilla-tab-fila-titulo" align='center'>Cantidad</td>
		<td class="grilla-tab-fila-titulo" align='center'>Precio neto</td>
		<td class="grilla-tab-fila-titulo" align='center'>Iva</td>
		<td class="grilla-tab-fila-titulo" align='center'>Total unitario</td>
		<td class="grilla-tab-fila-titulo" align='center'>Total</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
	<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].detalle}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].cantidad}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].precio_neto}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].iva}</td>

			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].total_unitario}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].total}</td>
			<td class="grilla-tab-fila-campo">
				<a href="#" onclick="xajax_EliminarMO(xajax.getFormValues('Form1'),'{$arrRegistros[registros].mod_ncorr}','{$arrRegistros[registros].grupo_mod}');">
					<img src="../images/close_delete.png" title="Eliminar Mano de Obra" />
				</a>
			</td>
			
		</tr>
	{/section}
</table>
</div>