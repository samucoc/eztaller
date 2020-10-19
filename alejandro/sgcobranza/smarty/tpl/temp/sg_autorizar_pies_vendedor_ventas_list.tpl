<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='10' class="grilla-tab-fila-titulo" align='center'><b>Listado de autorizaciones de pie de vendedor de ventas por confirmar al {$smarty.now|date_format:"%d/%m/%Y"}</b></td>
</tr>

<tr>
    <td class="grilla-tab-fila-titulo" align='center'><input type="checkbox" name="selectall[]" id="selectall" onclick="checkAll(document.getElementById('Form1'), 'results1', this.checked);"></td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha de venta</td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha de vale</td>
	<td class="grilla-tab-fila-titulo" align='center'>Folio</td>
	<td class="grilla-tab-fila-titulo" align='center'>Monto</td>
	<td class="grilla-tab-fila-titulo" align='center'>Trabajador</td>
	<td class="grilla-tab-fila-titulo" align='center'>Usuario</td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha digitacion</td>
</tr>

{section name=registros loop=$arrRegistros}
	<tr>
		<td class="grilla-tab-fila-campo" align='center'>
			<input type="checkbox" name="seleccion[]" class="results1" value='{$arrRegistros[registros].ncorr}'>
		</td>
		<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].fecha|date_format:"%d/%m/%Y"}</td>
        <td class="grilla-tab-fila-campo" align='center'>
        	<input type="text" name="fecha_vale_{$arrRegistros[registros].ncorr}" id="fecha_vale_{$arrRegistros[registros].ncorr}" class="fecha_vale" onKeyPress="return SoloNumeros(this, event, 0)" onkeyup="mascara(this,'/',patron,true)" />
        </td>
		<td class="grilla-tab-fila-campo" align='center'>
        	<a href="#" onclick="xajax_LlamaVenta(xajax.getFormValues('Form1'),'{$arrRegistros[registros].folio}');">
            	{$arrRegistros[registros].folio}
            </a>
        </td>
		<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].monto|number_format:0:',':'.'}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].trabajador}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].usuario}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].fecha_digitacion|date_format:"%d/%m/%Y %H:%M:%S"}</td>
	</tr>
		
{/section}

<tr>
	<td colspan='2' class="grilla-tab-fila-titulo" align='left'>Total:</td>
	<td colspan='6' class="grilla-tab-fila-campo" align='left'>{$TOTAL_FOLIOS|number_format:0:',':'.'}</td>
</tr>

<tr>
	<td colspan='10' class="grilla-tab-fila-titulo">
		<input type="button" name="btnConfirmar" value="Confirmar" class="boton" onclick="xajax_Grabar(xajax.getFormValues('Form1'));">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
	</td>
</tr>
</table>
</div>



