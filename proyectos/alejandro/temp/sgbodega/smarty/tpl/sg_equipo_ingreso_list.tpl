<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Item</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Código</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Descripción</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>N/U</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center'>Cantidad</td>
	<td class="grilla-tab-fila-campo-pequenio" align='center' style="width: 5%"><b>+</b></td>
</tr>

{section name=productos loop=$arrProductos}
	<tr>
		<td class="grilla-tab-fila-campo-pequenio" align='center'>{$arrProductos[productos].item}</td>
		<td class="grilla-tab-fila-campo-pequenio">{$arrProductos[productos].codigo}</td>
		<td class="grilla-tab-fila-campo-pequenio">{$arrProductos[productos].descripcion}</td>
		<td class="grilla-tab-fila-campo-pequenio" align='center'>{$arrProductos[productos].nu}</td>
		<td class="grilla-tab-fila-campo-pequenio" align='right'>{$arrProductos[productos].cantidad|number_format:0:',':'.'}</td>
        <td>
        	<input type="button" name="btnAgregar" value="+" class="boton" onclick="xajax_GrabarLinea(xajax.getFormValues('Form1'),{$arrProductos[productos].ncorr},{$arrProductos[productos].codigo},{$arrProductos[productos].cantidad});">
        </td>
	</tr>
{/section}


</table>
</div>



