<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Item</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Código</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Descripción</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>N/U</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Cantidad</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Precio</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Total</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center' style="width: 5%"><b>Cant. Dev.</b></td>
	<td class="grilla-tab-fila-campo-pequenio" align='center' style="width: 5%"><b>N/U</b></td>
	<td class="grilla-tab-fila-campo-pequenio" align='center' style="width: 5%"><b>Total Dev</b></td>
</tr>

{section name=productos loop=$arrProductos}
	<tr>
		<td class="grilla-tab-fila-campo-pequenio" align='center'>{$arrProductos[productos].item}</td>
		<td class="grilla-tab-fila-campo-pequenio">{$arrProductos[productos].codigo}</td>
		<td class="grilla-tab-fila-campo-pequenio">{$arrProductos[productos].descripcion}</td>
		<td class="grilla-tab-fila-campo-pequenio" align='center'>{$arrProductos[productos].nu}</td>
		<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrProductos[productos].cantidad|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrProductos[productos].precio|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrProductos[productos].total|number_format:0:',':'.'}</td>
		
		<td class="grilla-tab-fila-campo-pequenio" style="width: 5%">
			<INPUT type="text" id="{$arrProductos[productos].ncorr}txtDev" name="{$arrProductos[productos].ncorr}txtDev" value='0' onKeyPress="return SoloNumeros(this, event, 3)" onchange="xajax_CalculaTotalesLinea(xajax.getFormValues('Form1'),'{$arrProductos[productos].ncorr}', '{$arrProductos[productos].cantidad}', '{$arrProductos[productos].precio}', '{$arrProductos[productos].item}');" maxLength="5" size="5">
		</td>
		<td class="grilla-tab-fila-campo-pequenio" style="width: 5%">
			<SELECT id="{$arrProductos[productos].ncorr}cboNU" name="{$arrProductos[productos].ncorr}cboNU">
				<option value='N'>N</option>
				<option value='U'>U</option>
			</SELECT>
		</td>
		<td class="grilla-tab-fila-campo-pequenio" style="width: 5%">
			<INPUT type="text" id="{$arrProductos[productos].ncorr}txtTotalDev" name="{$arrProductos[productos].ncorr}txtTotalDev" value='0' readonly size="10">
		</td>
	</tr>
{/section}


</table>
</div>



