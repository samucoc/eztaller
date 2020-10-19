<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

<tr>
	<td class="grilla-tab-fila-titulo" align='center'>Empresa</td>
	<td class="grilla-tab-fila-titulo" align='center'>Tipo</td>
	<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
	<td class="grilla-tab-fila-titulo" align='center'>Proveedor</td>
	<td class="grilla-tab-fila-titulo" align='center'>Nro Factura</td>
	<td class="grilla-tab-fila-titulo" align='center'>Neto</td>
	<td class="grilla-tab-fila-titulo" align='center'>Iva</td>
	<td class="grilla-tab-fila-titulo" align='center'>Total</td>
	<td class="grilla-tab-fila-titulo" align='center'>Elegir</td>
	<td class="grilla-tab-fila-titulo" align='center'>Eliminar</td>

    </tr>
	

{section name=registros loop=$arrRegistros}
        <tr>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].empresa}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].tipo_factura}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].fecha|date_format:"%d/%m/%Y"}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].cliente}</td>
        <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].nro_boleta}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].neto|number_format:0:".":","}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].iva|number_format:0:".":","}</td>
		<td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].total|number_format:0:".":","}</td>
		<td class="grilla-tab-fila-campo" align='left'>
        	<input type="checkbox" name="fact_elegida[]" id="{$arrRegistros[registros].nro_boleta}" value="{$arrRegistros[registros].tipo_factura}_{$arrRegistros[registros].ncorr}"/>
        </td>
        <td class="grilla-tab-fila-campo" align='left'>
        	{if $arrRegistros[registros].cierre =='SI'}
            <a href="#" onclick="xajax_Eliminar(xajax.getFormValues('Form1'),{$arrRegistros[registros].ncorr})">Eliminar</a>
            {else}
            No Aplica
            {/if}
        </td>
		</tr>
{/section}
	<tr>
        <td class="grilla-tab-fila-titulo" >Periodo Contable:</td>
        <td class="grilla-tab-fila-campo" colspan="8">
            Mes:
            <SELECT id="cboMes" name="cboMes" onKeyPress="return Tabula(this, event, 0)">
                <option value=''>- - Seleccione - -</option>
                <option value='1'>Enero</option>
                <option value='2'>Febrero</option>
                <option value='3'>Marzo</option>
                <option value='4'>Abril</option>
                <option value='5'>Mayo</option>
                <option value='6'>Junio</option>
                <option value='7'>Julio</option>
                <option value='8'>Agosto</option>
                <option value='9'>Septiembre</option>
                <option value='10'>Octubre</option>
                <option value='11'>Noviembre</option>
                <option value='12'>Diciembre</option>
            </SELECT>
            &nbsp;&nbsp;
            A&ntilde;o:
            <SELECT id="cboAnio" name="cboAnio" onKeyPress="return Tabula(this, event, 0)">
                <option value=''>- - Seleccione - -</option>
                <option value='2010'>2010</option>
                <option value='2011'>2011</option>
                <option value='2012'>2012</option>
                <option value='2013'>2013</option>
                <option value='2014'>2014</option>
                <option value='2015'>2015</option>
            </SELECT>
            
        </td>
    </tr>
    <tr>
    	<td class="grilla-tab-fila-titulo" ><input type="button" class="boton" value="Asociar" name="btnAsociar" onclick="xajax_Asociar(xajax.getFormValues('Form1'));"/></td>
    </tr>
</table>
</div>



