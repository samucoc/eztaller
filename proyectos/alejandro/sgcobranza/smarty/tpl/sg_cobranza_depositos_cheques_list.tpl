<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Banco</td>
        <td class="grilla-tab-fila-campo-pequenio" align="center">{$banco}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Rango de Fechas</td>
        <td class="grilla-tab-fila-campo-pequenio" align="center">{$desde} al {$hasta}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Nro Cheque</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Banco</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Valor</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Fecha</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Estado</td>
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].apoderado}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].curso}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].alumno}
            </td>
            <<td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].nro_cheque}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].banco}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].valor}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].fecha}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].estado}
            </td>
	    </tr>
    {/section}
    <tr>
        <td colspan='2' class="grilla-tab-fila-titulo">
            Total
        </td>
        <td class="grilla-tab-fila-titulo">
            {$total}
        </td>
    </tr>
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <a href="#" onclick="ImprimeDiv('divabonos');">
                <img src='../images/basicos/imprimir.png' title='Imprimir' width="32"/>
            </a>
        </td>
    </tr>
    </table>
</div>