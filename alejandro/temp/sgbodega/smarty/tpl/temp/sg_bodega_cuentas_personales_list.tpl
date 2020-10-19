<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td colspan='10' class="grilla-tab-fila-titulo" align='center'><b>Listado de Devoluciones De Clientes Por Confirmar al {$smarty.now|date_format:"%d/%m/%Y"}</b></td>
</tr>

<tr>
	<td class="grilla-tab-fila-titulo" align='center'></td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha Dev.</td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha Dig.</td>
	<td class="grilla-tab-fila-titulo" align='center'>Usuario</td>
	<td class="grilla-tab-fila-titulo" align='center'>Folio</td>
	<td class="grilla-tab-fila-titulo" align='center'>Guia</td>
	<td class="grilla-tab-fila-titulo" align='center'>Código</td>
	<td class="grilla-tab-fila-titulo" align='center'>Descripción</td>
	<td class="grilla-tab-fila-titulo" align='center'>Cantidad</td>
</tr>

{section name=registros loop=$arrRegistros}
	<tr>
		<td class="grilla-tab-fila-campo" align='center'>
			<input type="checkbox" name="seleccion[]" value='{$arrRegistros[registros].ncorr}'>
		</td>
		<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].fecha|date_format:"%d/%m/%Y"}</td>
		<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].fecha_dig|date_format:"%d/%m/%Y %H:%M:%S"}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].usuario}</td>
		<td class="grilla-tab-fila-campo" align='center'>{$arrRegistros[registros].folio}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].guia}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].codigo}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].descripcion}</td>
		<td class="grilla-tab-fila-campo" align='right'>{$arrRegistros[registros].cantidad|number_format:0:',':'.'}</td>
		
	</tr>
		
{/section}

<!--
<tr>
	<td colspan='2' class="grilla-tab-fila-titulo" align='left'>Total:</td>
	<td colspan='6' class="grilla-tab-fila-campo" align='left'>{$TOTAL_FOLIOS|number_format:0:',':'.'}</td>
</tr>
!-->

<tr>
	<td colspan='10' class="grilla-tab-fila-titulo">
		<input type="button" name="btnConfirmar" value="Confirmar" class="boton" onclick="xajax_Grabar(xajax.getFormValues('Form1'));">
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">
		<input type="button" name="btnUsado" value="Usado" class="boton" onclick="xajax_Usado(xajax.getFormValues('Form1'));">
	</td>
</tr>
</table>
</div>



