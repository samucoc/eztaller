<div id="pivot">										
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
    	<td colspan="2" class="grilla-tab-fila-titulo">Cartola A&ntilde;o {$anio}</td> 
    </tr>
	<tr>
    	<td class="grilla-tab-fila-titulo">Alumno</td>
    	<td class="grilla-tab-fila-campo">{$alumno}</td>
    </tr>
    <tr>
    	<td class="grilla-tab-fila-titulo">Curso</td>
    	<td class="grilla-tab-fila-campo">{$curso}</td>
    </tr>
    <tr>
        <td colspan="2">
            <table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td class="grilla-tab-fila-titulo" align='center'>Codigo</td>
                <td class="grilla-tab-fila-titulo" align='center'>Nro Cuota</td>
                <td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
                <td class="grilla-tab-fila-titulo" align='center'>Pactado</td>
                <td class="grilla-tab-fila-titulo" align='center'>Pagado</td>
            </tr>
            {section name=registros loop=$arrRegistros}
                    <tr>
                    <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].codigo}</td>
                    <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].nro_cuota}</td>
                    <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].fecha|date_format:"%d/%m/%Y"}</td>
                    <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].pactado|number_format:0:".":","}</td>
                    <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].valorpagado|number_format:0:".":","}</td>
                    </tr>
            {/section}
            
            <tr>
                <td class="grilla-tab-fila-titulo" align='center'>Total</td>
                <td class="grilla-tab-fila-campo" align='right' colspan="6"><label id="total" name="total">{$tot_saldo}</label></td>
            </tr>
            </table>
        </td>
    </tr>
</table>
</div>



