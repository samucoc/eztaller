<div id="pivot">										
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
    	<td colspan="2" class="grilla-tab-fila-titulo">Detalle de Pagos A&ntilde;o {$anio}</td> 
    </tr>
	<tr>
    	<td class="grilla-tab-fila-titulo">Alumno</td>
    	<td class="grilla-tab-fila-campo">{$alumno}</td>
    </tr>
    <tr>
    	<td class="grilla-tab-fila-titulo">Curso</td>
    	<td class="grilla-tab-fila-campo">{$curso}</td>
    </tr>
    

</table>
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Nro Boleta</td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
	<td class="grilla-tab-fila-titulo" align='center'>Valor</td>
	<td class="grilla-tab-fila-titulo" align='center'>Tipo de Pago</td>
	<td class="grilla-tab-fila-titulo" align='center'>Estado Pago</td>
	<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>

    </tr>
	

{section name=registros loop=$arrRegistrosMov}
        <tr>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistrosMov[registros].nro_boleta}</td>
       	<td class="grilla-tab-fila-campo" align='left'>{$arrRegistrosMov[registros].fecha|date_format:"%d/%m/%Y"}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistrosMov[registros].valor|number_format:0:".":","}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistrosMov[registros].tipo_pago}</td>
		{if $arrRegistrosMov[registros].valor == '0'}
			<td class="grilla-tab-fila-campo" align='left'>NULA</td>
		{else}
			<td class="grilla-tab-fila-campo" align='left'>VIGENTE</td>
		{/if}
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistrosMov[registros].descripcion}</td>
		</tr>
{/section}

<tr>
	<tr>
    <td class="grilla-tab-fila-titulo" align='center'>Total</td>
    <td class="grilla-tab-fila-campo" align='right' colspan="6"><label id="total" name="total">{$tot_valor}</label></td>
    </tr>
	<td colspan='16' class="grilla-tab-fila-titulo">
		<!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divabonos');">-->
		         <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto;	text-align: center;"></iframe>
	</td>
</tr>
</table>
</div>



