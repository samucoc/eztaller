<div id="pivot">
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Nro OT</td>
		<td class="grilla-tab-fila-titulo" align='center'>{$ot_ncorr}</td>
	</tr>
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
		<td class="grilla-tab-fila-titulo" align='center'>{$fecha}</td>
	</tr>
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Folio</td>
		<td class="grilla-tab-fila-titulo" align='center'>{$folio}</td>
	</tr>
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Mecanico</td>
		<td class="grilla-tab-fila-titulo" align='center'>{$nombre_mecanico}</td>
	</tr>
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Patente</td>
		<td class="grilla-tab-fila-titulo" align='center'>{$patente}</td>
	</tr>
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Trabajador</td>
		<td class="grilla-tab-fila-titulo" align='center'>{$nombre_trabajador}</td>
	</tr>
	</table>
	<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
		<td class="grilla-tab-fila-titulo" align='center' colspan="6">Mano de Obra</td>
		</tr>
		<tr>
			<td class="grilla-tab-fila-titulo" align='center'>Detalle</td>
			<td class="grilla-tab-fila-titulo" align='center'>Cantidad</td>
			<td class="grilla-tab-fila-titulo" align='center'>Precio neto</td>
			<td class="grilla-tab-fila-titulo" align='center'>Iva</td>
			<td class="grilla-tab-fila-titulo" align='center'>Total unitario</td>
			<td class="grilla-tab-fila-titulo" align='center'>Total</td>
		</tr>
	{section name=registros_mo loop=$arrRegistros_MO}
		<tr >
			<td class="grilla-tab-fila-campo">{$arrRegistros_MO[registros_mo].detalle}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros_MO[registros_mo].cantidad}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros_MO[registros_mo].precio_neto}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros_MO[registros_mo].iva}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros_MO[registros_mo].total_unitario}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros_MO[registros_mo].total}</td>
		</tr>
	{/section}
		<tr>
			<td class="grilla-tab-fila-titulo" align='center' colspan="6">Repuestos</td>
		</tr>
		<tr>
			<td class="grilla-tab-fila-titulo" align='center'>Detalle</td>
			<td class="grilla-tab-fila-titulo" align='center'>Cantidad</td>
			<td class="grilla-tab-fila-titulo" align='center'>Precio neto</td>
			<td class="grilla-tab-fila-titulo" align='center'>Iva</td>
			<td class="grilla-tab-fila-titulo" align='center'>Total unitario</td>
			<td class="grilla-tab-fila-titulo" align='center'>Total</td>
		</tr>
	{section name=registros_rep loop=$arrRegistros_REP}
		<tr >
			<td class="grilla-tab-fila-campo">{$arrRegistros_REP[registros_rep].cod_repuesto}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros_REP[registros_rep].cantidad}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros_REP[registros_rep].precio_neto_unitario}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros_REP[registros_rep].iva}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros_REP[registros_rep].precio_unitario}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros_REP[registros_rep].total}</td>
		</tr>
	{/section}
	</table>
	<table align="right"  class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">>
		<tr>
			<td>
				<table align="right">
					<tr>
						<td class="grilla-tab-fila-titulo" >
							
						</td>
						<td class="grilla-tab-fila-titulo" >
							Neto	
						</td>
						<td class="grilla-tab-fila-titulo" >
							Iva
						</td>
						<td class="grilla-tab-fila-titulo" >
							Total
						</td>
					</tr>
					<tr>
						<td class="grilla-tab-fila-titulo" >
							Total Mano de Obra
						</td>
						<td class="grilla-tab-fila-campo" id="neto_mo_final" name="neto_mo_final">
						
						</td>
						<td class="grilla-tab-fila-campo" id="iva_mo_final" name="iva_mo_final">
						
						</td>
						<td class="grilla-tab-fila-campo" id="total_mo_final" name="total_mo_final">
						
						</td>
					</tr>
					<tr>
						<td class="grilla-tab-fila-titulo" >
							Total Repuestos
						</td>
						<td class="grilla-tab-fila-campo" id="neto_rep_final" name="neto_rep_final">
							
						</td>
						<td class="grilla-tab-fila-campo" id="iva_rep_final" name="iva_rep_final">
							
						</td>
						<td class="grilla-tab-fila-campo" id="total_rep_final" name="total_rep_final">
							
						</td>
					</tr>
					<tr>
						<td class="grilla-tab-fila-titulo" >
							Total
						</td>
						<td class="grilla-tab-fila-campo" id="neto_final" name="neto_final">
							
						</td>
						<td class="grilla-tab-fila-campo" id="iva_final" name="iva_final">
							
						</td>
						<td class="grilla-tab-fila-campo" id="total_final" name="total_final">
							
						</td>
					</tr>
				</table>
			</td>
		</tr>
	<tr>
		<td colspan='9' class="grilla-tab-fila-titulo">
			<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
		</td>
	</tr>
</table>
</div>