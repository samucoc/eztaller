<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td colspan='13' class="grilla-tab-fila-titulo-pequenio" align='center'>Depósitos Confirmados</td>
</tr>

<tr>
	<td class="grilla-tab-fila-titulo-pequenio">Cód.</td>
	
	<!--
	<td class="grilla-tab-fila-titulo-pequenio">Empresa</td>
	<td class="grilla-tab-fila-titulo-pequenio">Sector</td>
	<td class="grilla-tab-fila-titulo-pequenio">Cobrador</td>
	-->
	
	<td class="grilla-tab-fila-titulo-pequenio">Tipo</td>
	<td class="grilla-tab-fila-titulo-pequenio">Banco</td>
	<td class="grilla-tab-fila-titulo-pequenio">Sucursal</td>
	<td class="grilla-tab-fila-titulo-pequenio">Cta.</td>
	<td class="grilla-tab-fila-titulo-pequenio">Fecha Cob.</td>
	<td class="grilla-tab-fila-titulo-pequenio">Fecha Dep.</td>
	<td class="grilla-tab-fila-titulo-pequenio">Transac.</td>
	<td class="grilla-tab-fila-titulo-pequenio">Monto</td>
	<td class="grilla-tab-fila-titulo-pequenio">Usuario</td>
	<td class="grilla-tab-fila-titulo-pequenio">Usuario Conf.</td>
	<td class="grilla-tab-fila-titulo-pequenio">Fecha Conf.</td>
	<td class="grilla-tab-fila-titulo-pequenio"></td>
</tr>

{section name=registros loop=$arrRegistros}
	<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
		
		<td class='grilla-tab-fila-campo-pequenio' align='right'>
			<INPUT style='text-align: right; font-size:9px; width: 90%;' type="text" id="{$arrRegistros[registros].codigo}" name="{$arrRegistros[registros].codigo}" size='2' value='{$arrRegistros[registros].codigo}' readonly>
		</td>
		<!--
		<td class='grilla-tab-fila-campo-pequenio' align='left'>{$arrRegistros[registros].empresa}</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>{$arrRegistros[registros].sector}</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>{$arrRegistros[registros].cobrador}</td>
		-->
		
		<td class='grilla-tab-fila-campo-pequenio' align='left'>{$arrRegistros[registros].tipo}</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>{$arrRegistros[registros].banco}</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>{$arrRegistros[registros].sucursal}</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>{$arrRegistros[registros].cta}</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center'>{$arrRegistros[registros].fechacob}</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center'>{$arrRegistros[registros].fechadep}</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>{$arrRegistros[registros].transac}</td>
		<td class='grilla-tab-fila-campo-pequenio' align='right'><b>{$arrRegistros[registros].monto}</b></td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>{$arrRegistros[registros].usuario}</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>{$arrRegistros[registros].usuario_conf}</td>
		<td class='grilla-tab-fila-campo-pequenio' align='left'>{$arrRegistros[registros].fecha_conf}</td>
		<td class='grilla-tab-fila-campo-pequenio' align='center'>
			<input type='button' name='btnOK' value='Anular Confirmación' class='botondestaca' onclick="xajax_Anular('{$arrRegistros[registros].ncorr}');">
		</td>

	</tr>
{/section}



</table>
