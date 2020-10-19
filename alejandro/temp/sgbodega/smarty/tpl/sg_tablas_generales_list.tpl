<div id="pivot">
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

{if ($TBL == 'sectores')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Zona</td>
		<td class="grilla-tab-fila-titulo" align='center'>Código</td>
		<td class="grilla-tab-fila-titulo" align='center'>Descripción</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>

	</tr>
	{section name=registros loop=$arrRegistros}
		<tr>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].zona}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].codigo}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].descripcion}</td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<input type="button" name="btnModificar" value="Modificar" class="boton" onclick="xajax_Modificar(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');">
			</td>
		</tr>
	{/section}

{/if}

{if ($TBL == 'vendedores')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Código</td>
		<td class="grilla-tab-fila-titulo" align='center'>Vendedor</td>
		<td class="grilla-tab-fila-titulo" align='center'>Comisión</td>
		<td class="grilla-tab-fila-titulo" align='center'>Activo</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>

	</tr>
	{section name=registros loop=$arrRegistros}
		<tr>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].codigo}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].vendedor}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].comision}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].activo}</td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<input type="button" name="btnModificar" value="Modificar" class="boton" onclick="xajax_Modificar(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');">
			</td>
		</tr>
	{/section}

{/if}

{if ($TBL == 'cobrador')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Código</td>
		<td class="grilla-tab-fila-titulo" align='center'>Cobrador</td>
		<td class="grilla-tab-fila-titulo" align='center'>Comisión</td>
		<td class="grilla-tab-fila-titulo" align='center'>Activo</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>

	</tr>
	{section name=registros loop=$arrRegistros}
		<tr>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].codigo}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].cobrador}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].comision}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].activo}</td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<input type="button" name="btnModificar" value="Modificar" class="boton" onclick="xajax_Modificar(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');">
			</td>
		</tr>
	{/section}

{/if}

{if ($TBL == 'supervisor')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Código</td>
		<td class="grilla-tab-fila-titulo" align='center'>Supervisor</td>
		<td class="grilla-tab-fila-titulo" align='center'>Comisión</td>
		<td class="grilla-tab-fila-titulo" align='center'>Activo</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>

	</tr>
	{section name=registros loop=$arrRegistros}
		<tr>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].codigo}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].supervisor}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].comision}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].activo}</td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<input type="button" name="btnModificar" value="Modificar" class="boton" onclick="xajax_Modificar(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');">
			</td>
		</tr>
	{/section}

{/if}

{if ($TBL == 'familias')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Código</td>
		<td class="grilla-tab-fila-titulo" align='center'>Descripción</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>

	</tr>
	{section name=registros loop=$arrRegistros}
		<tr>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].codigo}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].descripcion}</td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<input type="button" name="btnModificar" value="Modificar" class="boton" onclick="xajax_Modificar(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');">
			</td>
		</tr>
	{/section}

{/if}
{if ($TBL == 'subfamilias')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Código</td>
		<td class="grilla-tab-fila-titulo" align='center'>Descripción</td>
		<td class="grilla-tab-fila-titulo" align='center'>Familia</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>

	</tr>
	{section name=registros loop=$arrRegistros}
		<tr>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].codigo}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].descripcion}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].familia}</td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<input type="button" name="btnModificar" value="Modificar" class="boton" onclick="xajax_Modificar(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');">
			</td>
		</tr>
	{/section}

{/if}

{if (($TBL == 'marcas') OR ($TBL == 'clasificacion') OR ($TBL == 'tramos'))}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Código</td>
		<td class="grilla-tab-fila-titulo" align='center'>Descripción</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>

	</tr>
	{section name=registros loop=$arrRegistros}
		<tr>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].codigo}</td>
			<td class="grilla-tab-fila-campo">{$arrRegistros[registros].descripcion}</td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<input type="button" name="btnModificar" value="Modificar" class="boton" onclick="xajax_Modificar(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');">
			</td>
		</tr>
	{/section}

{/if}

</table>
</div>