<br>
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td colspan='6' class="grilla-tab-fila-titulo-pequenio" align='center'><b>Movimientos Por Sector al {$smarty.now|date_format:"%d/%m/%Y"}</b></td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo-pequenio"><b>Rango:</b></td>
	<td colspan='5' class="grilla-tab-fila-campo-pequenio">{$RANGO} {$DETALLE_RANGO}</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo-pequenio"><b>Empresa:</b></td>
	<td colspan='5' class="grilla-tab-fila-campo-pequenio">{$EMPRESA}</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo-pequenio"><b>Sector:</b></td>
	<td colspan='5' class="grilla-tab-fila-campo-pequenio">{$SECTOR}</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo-pequenio"><b>Saldo Inicial:</b></td>
	<td colspan='5' class="grilla-tab-fila-campo-pequenio">{$SALDO_INICIAL|number_format:0:',':'.'}</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo-pequenio"><b>Saldo Actual:</b></td>
	<td colspan='5' class="grilla-tab-fila-campo-pequenio">{$SALDO_ACTUAL|number_format:0:',':'.'}</td>
</tr>

<tr>
	<td class="grilla-tab-fila-titulo-pequenio" align='center'>Fecha</td>
	<td class="grilla-tab-fila-titulo-pequenio" align='center'>Empresa</td>
	<td class="grilla-tab-fila-titulo-pequenio" align='center'>Nº Operación</td>
	<td class="grilla-tab-fila-titulo-pequenio" align='center'>Descripción</td>
	<td class="grilla-tab-fila-titulo-pequenio" align='center'>Egresos</td>
	<td class="grilla-tab-fila-titulo-pequenio" align='center'>Ingresos</td>
	<!--<td class="grilla-tab-fila-titulo-pequenio" align='center'>Saldo</td>-->
</tr>

{section name=registros loop=$arrRegistros}
	
	<tr>
		<td class="grilla-tab-fila-campo-pequenio" align='center'>{$arrRegistros[registros].fecha}</td>
		<td class="grilla-tab-fila-campo-pequenio">{$arrRegistros[registros].empresa}</td>
		<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrRegistros[registros].transac}</td>
		<td class="grilla-tab-fila-campo-pequenio">{$arrRegistros[registros].descripcion}</td>
		<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrRegistros[registros].cargo|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrRegistros[registros].abono|number_format:0:',':'.'}</td>
		<!--<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrRegistros[registros].saldo|number_format:0:',':'.'}</td>-->
	</tr>
		
{/section}


<tr>
	<td colspan='4' class="grilla-tab-fila-campo" align='right'><b>Totales:</b></td>
	<td class="grilla-tab-fila-campo" align='right'><b>{$TOTAL_CARGOS|number_format:0:',':'.'}</b></td>
	<td class="grilla-tab-fila-campo" align='right'><b>{$TOTAL_ABONOS|number_format:0:',':'.'}</b></td>
</tr>


<tr>
	<td colspan='6' class="grilla-tab-fila-titulo-pequenio">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divresultado');">
	</td>
</tr>

</table>




