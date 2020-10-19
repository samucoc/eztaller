<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td colspan="4" class="grilla-tab-fila-titulo" align="center">Informe IVA</td>
</tr>
<tr>
	<td colspan="2" class="grilla-tab-fila-titulo" align="center">Ventas</td>
	<td colspan="2" class="grilla-tab-fila-titulo" align="center">Compras</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='left' width="25%">Neto</td>
	<td class="grilla-tab-fila-campo" align='left' width="25%">{$neto_venta|number_format:0:",":"."}</td>
	<td class="grilla-tab-fila-titulo" align='left' width="25%">Neto</td>
	<td class="grilla-tab-fila-campo" align='left' width="25%">{$neto_compra|number_format:0:",":"."}</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='left'>Iva</td>
	<td class="grilla-tab-fila-campo" align='left'>{$iva_venta|number_format:0:",":"."}</td>
	<td class="grilla-tab-fila-titulo" align='left'>Iva</td>
	<td class="grilla-tab-fila-campo" align='left'>{$iva_compra_1|number_format:0:",":"."}</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder">Total</td>
	<td class="grilla-tab-fila-campo" align='left' style="font-weight:bolder  ;border:2px solid #000">{$total_venta|number_format:0:",":"."}</td>
	<td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder">Total</td>
	<td class="grilla-tab-fila-campo" align='left' style="font-weight:bolder  ;border:2px solid #000">{$total_compra_1|number_format:0:",":"."}</td>
</tr>
<tr>
  <td class="grilla-tab-fila-titulo" align='left'>Neto Nota de Cr&eacute;dito</td>
  <td class="grilla-tab-fila-campo" align='left'>{$neto_credito_venta|number_format:0:",":"."}</td>
  <td class="grilla-tab-fila-titulo" align='left'>Neto Nota de Cr&eacute;dito</td>
  <td class="grilla-tab-fila-campo" align='left'>{$neto_credito_compra|number_format:0:",":"."}</td>
</tr>
<tr>
  <td class="grilla-tab-fila-titulo" align='left'>Iva Nota de Cr&eacute;dito</td>
  <td class="grilla-tab-fila-campo" align='left'>{$iva_credito_venta|number_format:0:",":"."}</td>
  <td class="grilla-tab-fila-titulo" align='left'>Iva Nota de Cr&eacute;dito</td>
  <td class="grilla-tab-fila-campo" align='left'>{$iva_credito_compra|number_format:0:",":"."}</td>
</tr>
<tr>
  <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder">Total Nota de Cr&eacute;dito</td>
  <td class="grilla-tab-fila-campo" align='left' style="font-weight:bolder  ;border:2px solid #000">{$total_credito_venta|number_format:0:",":"."}</td>
  <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder">Total Nota de Cr&eacute;dito</td>
  <td class="grilla-tab-fila-campo" align='left' style="font-weight:bolder  ;border:2px solid #000">{$total_credito_compra|number_format:0:",":"."}</td>
</tr>
<tr>
  <td class="grilla-tab-fila-titulo" align='left'>Neto Nota de D&eacute;bito</td>
  <td class="grilla-tab-fila-campo" align='left'>{$neto_debito_venta|number_format:0:",":"."}</td>
  <td class="grilla-tab-fila-titulo" align='left'>Neto Nota de D&eacute;bito</td>
  <td class="grilla-tab-fila-campo" align='left'>{$neto_debito_compra|number_format:0:",":"."}</td>
</tr>
<tr>
  <td class="grilla-tab-fila-titulo" align='left'>Iva Nota de D&eacute;bito</td>
  <td class="grilla-tab-fila-campo" align='left'>{$iva_debito_venta|number_format:0:",":"."}</td>
  <td class="grilla-tab-fila-titulo" align='left'>Iva Nota de D&eacute;bito</td>
  <td class="grilla-tab-fila-campo" align='left'>{$iva_debito_compra|number_format:0:",":"."}</td>
</tr>
<tr>
  <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder">Total Nota de D&eacute;bito</td>
  <td class="grilla-tab-fila-campo" align='left' style="font-weight:bolder; border:2px solid #000">{$total_debito_venta|number_format:0:",":"."}</td>
  <td class="grilla-tab-fila-titulo" align='left' style="font-weight:bolder">Total Nota de D&eacute;bito</td>
  <td class="grilla-tab-fila-campo" align='left' style="font-weight:bolder; border:2px solid #000">{$total_debito_compra|number_format:0:",":"."}</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" colspan="2" align='right'></td>
	<td class="grilla-tab-fila-titulo" 	align='left'>Exento</td>
	<td class="grilla-tab-fila-campo" align='left'>{$exento_compra|number_format:0:",":"."}</td>
</tr>

<tr>
	<td class="grilla-tab-fila-titulo" colspan="4" align='center'>Resumen</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='left'>Iva D&eacute;bito</td>
	<td class="grilla-tab-fila-campo" colspan="3" align='left'>{$iva_venta|number_format:0:",":"."}</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='left'>Iva Cr&eacute;dito</td>
	<td class="grilla-tab-fila-campo" colspan="3" align='left'>{$iva_compra|number_format:0:",":"."}</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='left'></td>
	<td class="grilla-tab-fila-campo" colspan="3" align='left' style="font-weight:bolder; border:2px solid #000">{$iva_resultado|number_format:0:",":"."}</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='left'>Ret. 2&ordf; Categor&iacute;a</td>
	<td class="grilla-tab-fila-campo" colspan="3" align='left'>{$total_bh|number_format:0:",":"."}</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='left'>PPM {$porcentaje_ppm}%</td>
	<td class="grilla-tab-fila-campo" colspan="3" align='left'>{math equation="x * (y/100)" x=$neto_venta y=$porcentaje_ppm format="%.0f"}</td>
</tr>
<tr>
	<td class="grilla-tab-fila-titulo" align='left'>Total a pagar</td>
	<td class="grilla-tab-fila-campo" colspan="3" align='left' style="font-weight:bolder; border:2px solid #000">{math equation="x+y+(z * (a/100))" x=$iva_resultado y=$total_bh z=$neto_venta a=$porcentaje_ppm format="%.0f"}</td>
</tr>
<tr>
	<td colspan='16' class="grilla-tab-fila-titulo">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>
</table>
</div>



