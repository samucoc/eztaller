<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="left" colspan="17">Detalle de Boletas</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Numero Rut Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">DV Rut Alumno</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Numero Boleta</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Fecha Boleta</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Valor Pagado</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Estado Boleta</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Periodo Boleta</td>
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].NumeroRutAlumno}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].dv}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                {$arrRegistros[registros].NumeroBoleta}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].FechaBoleta}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='right'>
                {$arrRegistros[registros].ValorPagado|number_format:0:",":"."}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                {$arrRegistros[registros].EstadoBoleta}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                {$arrRegistros[registros].Periodo}
            </td>
	    </tr>
    {/section}

    </table>
</div>