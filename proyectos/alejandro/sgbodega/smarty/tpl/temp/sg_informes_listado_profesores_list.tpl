<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nombre </td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Rut </td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Tipo Funcionario </td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Fecha Ingreso </td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">A&ntilde;os de Servicio </td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Direccion </td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Telefono </td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Email </td>
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].nombre}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].rut}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].NombreTipoFuncionario}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].IngresoFuncionario|date_format:"%d/%m/%Y"}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].fe}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].direccion}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].telefono}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].email}
            </td>
        </tr>
    {/section}
    </table>
</div>