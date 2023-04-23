<div id="pivot">
<table class="tabla-alycar" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class="tabla-alycar-label" align='center'>Repuesto</td>
		<td class="tabla-alycar-label" align='center'>Cantidad</td>
		<td class="tabla-alycar-label" align='center'>Precio neto</td>
		<td class="tabla-alycar-label" align='center'>Iva</td>
		<td class="tabla-alycar-label" align='center'>Total unitario</td>
		<td class="tabla-alycar-label" align='center'>Total</td>
		<td class="tabla-alycar-label" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="tabla-alycar-texto">{$arrRegistros[registros].cod_repuesto}</td>
			<td class="tabla-alycar-texto">{$arrRegistros[registros].cantidad}</td>
			<td class="tabla-alycar-texto">{$arrRegistros[registros].precio_neto_unitario}</td>
			<td class="tabla-alycar-texto">{$arrRegistros[registros].iva}</td>

			<td class="tabla-alycar-texto">{$arrRegistros[registros].precio_unitario}</td>
			<td class="tabla-alycar-texto">{$arrRegistros[registros].total}</td>
			<td class="tabla-alycar-texto">
				<a href="#" onclick="xajax_EliminarRepuesto(xajax.getFormValues('Form1'),'{$arrRegistros[registros].otr_ncorr}','{$arrRegistros[registros].grupo_mod}');">
					<img src="../images/close_delete.png" title="Eliminar Repuesto" />
				</a>
			</td>
			
		</tr>
	{/section}
</table>
</div>