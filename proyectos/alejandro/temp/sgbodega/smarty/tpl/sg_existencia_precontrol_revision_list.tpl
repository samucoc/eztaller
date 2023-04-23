<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='18' class="grilla-tab-fila-titulo" align='center'><b>Consulta Stock Vendedor P/Revisión al {$smarty.now|date_format:"%d/%m/%Y"}</b></td>
</tr>

<tr>
	<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Empresa:</td>
	<td colspan='17' class="grilla-tab-fila-campo" align='left'>{$EMPRESA}</td>
</tr>
<tr>
	<td colspan='1' class="grilla-tab-fila-titulo" align='left'>Vendedor:</td>
	<td colspan='17' class="grilla-tab-fila-campo" align='left'>{$COBRADOR}</td>
</tr>

<tr>
	<td class="grilla-tab-fila-titulo" style="width: 10%" align='center'>Código</td>
	<td class="grilla-tab-fila-titulo" style="width: 30%" align='center'>Descripción del Producto</td>
	<td class="grilla-tab-fila-titulo" style="width: 8%" align='center'>Valor</td>
	<td class="grilla-tab-fila-titulo" style="width: 8%" align='center'>Stock Nuevo</td>
	<td class="grilla-tab-fila-titulo" style="width: 5%" align='center'>Cor</td>
	<td class="grilla-tab-fila-titulo" style="width: 5%" align='center'>S/F</td>
	<td class="grilla-tab-fila-titulo" style="width: 8%" align='center'>DV</td>
	<td class="grilla-tab-fila-titulo" style="width: 8%" align='center'>Stock Usado</td>
	<td class="grilla-tab-fila-titulo" style="width: 5%" align='center'>Cor</td>
	<td class="grilla-tab-fila-titulo" style="width: 5%" align='center'>S/F</td>
	<td class="grilla-tab-fila-titulo" style="width: 8%" align='center'>DV</td>
</tr>

{section name=registros loop=$arrRegistrosRev}
	<tr>
		<td class="grilla-tab-fila-campo-rev" style="width: 10%" align='right'>{$arrRegistrosRev[registros].codigo}</td>
		<td class="grilla-tab-fila-campo-rev" style="width: 30%" align='left'>{$arrRegistrosRev[registros].descripcion}</td>
		<td class="grilla-tab-fila-campo-rev" style="width: 8%" align='left'>{$arrRegistrosRev[registros].valor|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-rev" style="width: 8%" align='right'>{$arrRegistrosRev[registros].stock_nuevo|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-rev" style="width: 5%" align='center'><label class="requerido">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></td>
		<td class="grilla-tab-fila-campo-rev" style="width: 5%" align='center'><label class="requerido">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></td>
		<td class="grilla-tab-fila-campo-rev" style="width: 8%" align='right'>{$arrRegistrosRev[registros].dv_nuevo|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-rev" style="width: 8%" align='right'>{$arrRegistrosRev[registros].stock_usado|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-rev" style="width: 5%" align='center'><label class="requerido">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></td>
		<td class="grilla-tab-fila-campo-rev" style="width: 5%" align='center'><label class="requerido">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></td>
		<td class="grilla-tab-fila-campo-rev" style="width: 8%" align='right'>{$arrRegistrosRev[registros].dv_usado|number_format:0:',':'.'}</td>
	</tr>
		
{/section}


</table>
</div>



