<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">


{section name=registros loop=$arrRegistros}
	<tr>
		<td class="grilla-tab-fila-campo" style="width: 7%">{$arrRegistros[registros].codigo}</td>
		<td class="grilla-tab-fila-campo" style="width: 38%">{$arrRegistros[registros].descripcion}</td>
		<td class="grilla-tab-fila-campo" style="width: 5%">{$arrRegistros[registros].marca}</td>
		<td class="grilla-tab-fila-campo" style="width: 5%">{$arrRegistros[registros].vehiculo}</td>
		<td class="grilla-tab-fila-campo" style="width: 5%" align='right'>{$arrRegistros[registros].cantidad|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo" style="width: 8%" align='right'>{$arrRegistros[registros].valor|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo">
			<a href="#" style="cursor: hand;"><img src="../images/cross.png" border=0 title="Eliminar" onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');"></a>
		</td>
	</tr>
		
{/section}

</table>
</div>



