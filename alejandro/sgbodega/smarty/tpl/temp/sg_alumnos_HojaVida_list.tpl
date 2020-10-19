<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
        <td class="grilla-tab-fila-titulo" align="left">Alumno</td>
        <td class="grilla-tab-fila-titulo" colspan="4" align="left" style="font-weight: bold">{$nombre_alumno}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align="left">Curso</td>
        <td class="grilla-tab-fila-titulo" colspan="4" align="left" style="font-weight: bold">{$nombre_curso}</td>
    </tr>
        <tr >
            <td class='grilla-tab-fila-campo' align='center'>
                Fecha
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Asignatura
            </td>
            <td class="grilla-tab-fila-campo" align="center">
                Tipo Anotaci&oacute;n
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Motivo
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Descripci&oacute;n
            </td>
            </tr>

    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].FechaHojaVida|date_format:"%d-%m-%Y"}
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].ramo}
            </td>
            {if $arrRegistros[registros].nombre == 'Positiva'}
                <td class="grilla-tab-fila-campo" align="center">
                    <a href="#"><img src='../images/cara_verde.jpg' title='Positiva' width="24" /></a>
                </td>
            {else}  
                <td class="grilla-tab-fila-campo" align="center">
                    <a href="#"><img src='../images/cara_roja.jpg' title='Negativa' width="24" /></a>
                </td>
            {/if}
            <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].DescripcionMotivo}
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].DescripcionHojaVida}
            </td>
	        </tr>
    {/section}
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
    
        </td>
    </tr>
    </table>
</div>