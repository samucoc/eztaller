<div id="pivot">
	<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'ot_ncorr');">Nro OT</a></td>
			<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'folio');">Folio</a></td>
			<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'fecha');">Fecha</a></td>
			<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'mecanico');">Mecanico</a></td>
			<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'patente');">Patente</a></td>
			<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'rut_trabajador');">Trabajador</a></td>
			<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'total_mo');">Total Mano Obra</a></td>
			<td class="grilla-tab-fila-titulo" align='center'><a href="#" style="cursor: hand;" onclick="xajax_Ordenar(xajax.getFormValues('Form1'), 'total_rep');">Total Repuesto</a></td>
			<td class="grilla-tab-fila-titulo" align='center'>Ver detalle</td>
		</tr>
			{section name=registros loop=$arrRegistros}

		<tr >
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].ot_ncorr}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].folio}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].fecha}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].mecanico}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].patente}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].rut_trabajador}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].total_mo|number_format:0:".":","}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].total_rep|number_format:0:".":","}</td>
			<td class="grilla-tab-fila-campo"><input type="button"  name="btnDetalle" id="btnDetalle" class="boton" onclick="xajax_VerDetalle(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ot_ncorr}');" value="Ver Detalle"></td>
		</tr>
	{/section}
	<tr>
		<td colspan='9' class="grilla-tab-fila-titulo">
			<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
		</td>
	</tr>
</table>
</div>