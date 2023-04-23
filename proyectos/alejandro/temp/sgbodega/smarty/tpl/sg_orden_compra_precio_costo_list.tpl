<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

	<tr>
		<td >
			<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

				<tr>
					<td class="grilla-tab-fila-titulo-pequenio">Codigo</td>
					<td class="grilla-tab-fila-titulo-pequenio">Descripcion</td>
					<td class="grilla-tab-fila-titulo-pequenio">Precio Costo Nuevo</td>
					<td class="grilla-tab-fila-titulo-pequenio">Usuario</td>
					<td class="grilla-tab-fila-titulo-pequenio">Fecha Digitacion</td>
				</tr>

				{section name=pcn loop=$arrpcn}
					<tr >
						<td class='grilla-tab-fila-campo-pequenio' align='left'>{$arrpcn[pcn].codigo}</td>
						<td class='grilla-tab-fila-campo-pequenio' align='left'>{$arrpcn[pcn].descr}</td>
						<td class='grilla-tab-fila-campo-pequenio' align='left'>{$arrpcn[pcn].precio_neto}</td>
						<td class='grilla-tab-fila-campo-pequenio' align='left'>{$arrpcn[pcn].usuario}</td>
						<td class='grilla-tab-fila-campo-pequenio' align='center'>{$arrpcn[pcn].fecha_dig|date_format:"%d/%m/%Y"}</td>
					</tr>
				{/section}
			</table>
		</td>
		<td >
			<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

				<tr>
					<td class="grilla-tab-fila-titulo-pequenio">Codigo</td>
					<td class="grilla-tab-fila-titulo-pequenio">Descripcion</td>
					<td class="grilla-tab-fila-titulo-pequenio">Precio Costo Usado</td>
					<td class="grilla-tab-fila-titulo-pequenio">Usuario</td>
					<td class="grilla-tab-fila-titulo-pequenio">Fecha Digitacion</td>
				</tr>
				{section name=pcu loop=$arrpcu}
					<tr >
						<td class='grilla-tab-fila-campo-pequenio' align='left'>{$arrpcu[pcu].codigo}</td>
						<td class='grilla-tab-fila-campo-pequenio' align='left'>{$arrpcu[pcu].descr}</td>
						<td class='grilla-tab-fila-campo-pequenio' align='left'>{$arrpcu[pcu].precio_neto}</td>
						<td class='grilla-tab-fila-campo-pequenio' align='left'>{$arrpcu[pcu].usuario}</td>
						<td class='grilla-tab-fila-campo-pequenio' align='center'>{$arrpcu[pcu].fecha_dig|date_format:"%d/%m/%Y"}</td>
					</tr>
				{/section}
			</table>
		</td>
	</tr>
	<tr>
		<td colspan='16' class="grilla-tab-fila-titulo">
			<!--<input type="button" name="btnSeleccionar" value="Volver" class="boton" onclick="xajax_Volver(xajax.getFormValues('Form1'));">-->
	        <input type="button" class='boton' value="Imprimir" onClick="ImprimeDiv('divabonos');">
		</td>
	</tr>
</table>


