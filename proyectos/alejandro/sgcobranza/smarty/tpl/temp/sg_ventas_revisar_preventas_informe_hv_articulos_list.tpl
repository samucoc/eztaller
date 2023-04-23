<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='7' class="grilla-tab-fila-campo-pequenio" align='center'><b>Artículos de la Cuenta</b></td>
</tr>

<tr>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Item</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Código</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Descripción</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>N/U</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Cantidad</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Precio</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Total</td>
</tr>

{section name=productos loop=$arrProductos}
	<tr>
		<td class="grilla-tab-fila-campo-pequenio" align='center'>{$arrProductos[productos].item}</td>
		<td class="grilla-tab-fila-campo-pequenio">{$arrProductos[productos].codigo}</td>
		<td class="grilla-tab-fila-campo-pequenio">
			{$arrProductos[productos].descripcion}
            <INPUT type="hidden" id="{$arrProductos[productos].ncorr}txtDesc" name="{$arrProductos[productos].ncorr}txtDesc" value='{$arrProductos[productos].descripcion}' maxLength="100" style="WIDTH: 98%;">
		</td>
		<td class="grilla-tab-fila-campo-pequenio" align='center'>{$arrProductos[productos].nu}</td>
		<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrProductos[productos].cantidad|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrProductos[productos].precio|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrProductos[productos].total|number_format:0:',':'.'}</td>
	</tr>
{/section}

</table>
</div>



