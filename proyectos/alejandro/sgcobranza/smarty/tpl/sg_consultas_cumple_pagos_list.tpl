<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo-pequenio"  width="25%" align="center">Mes</td>
        <td class="grilla-tab-fila-titulo-pequenio"  width="25%" align="center">Proyectado</td>
        <td class="grilla-tab-fila-titulo-pequenio"  width="25%" align="center">Real</td>
        <td class="grilla-tab-fila-titulo-pequenio" align="center">Porcentaje de Incumplimiento</td> 
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo-pequenio' align='left'>
                {$arrRegistros[registros].mes}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='right'>
                {$arrRegistros[registros].proyectado}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='right'>
                {$arrRegistros[registros].real}
            </td>
            <td class='grilla-tab-fila-campo-pequenio' align='center'>
                {$arrRegistros[registros].porcentaje}
            </td>
        </tr>
    {/section}
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divresultado');" width="32"></a>
        </td>
    </tr>
    </table>
</div>