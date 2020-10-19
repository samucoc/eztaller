<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
    	<td class="grilla-tab-fila-titulo" align="left">Alumno</td>
    	<td class="grilla-tab-fila-titulo" colspan="4" align="left" style="font-weight: bold; width: 80% !important">{$nombre_alumno}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align="left">Curso</td>
        <td class="grilla-tab-fila-titulo" colspan="4" align="left" style="font-weight: bold">{$nombre_curso}</td>
    </tr>
        {section name=registros1 loop=$arrRegistros1}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            {if (($arrRegistros1[registros1].FechaInasistencia=='Inasistencias')||($arrRegistros1[registros1].FechaInasistencia=='Atrasos'))}
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        
                    </td>
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        {$arrRegistros1[registros1].FechaInasistencia}
                    </td>
                {else}
                    <td class='grilla-tab-fila-campo' align='left'>
                        {$arrRegistros1[registros1].item}
                    </td>
                    <td class='grilla-tab-fila-campo' align='left'>
                        {$arrRegistros1[registros1].FechaInasistencia}
                    </td>
                    <td class='grilla-tab-fila-campo' align='left'>
                        {$arrRegistros1[registros1].Observacion}
                    </td>
                {/if}
           
            </tr>
        {/section}
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    
        {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            {if (($arrRegistros[registros].FechaInasistencia=='Inasistencias')||($arrRegistros[registros].FechaInasistencia=='Atrasos'))}
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        
                    </td>
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        {$arrRegistros[registros].FechaInasistencia}
                    </td>
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        Observaci&oacute;n
                    </td>
                {else}
                    <td class='grilla-tab-fila-campo' align='left'>
                        {$arrRegistros[registros].item}
                    </td>
                    <td class='grilla-tab-fila-campo' align='left'>
                        {$arrRegistros[registros].FechaInasistencia}
                    </td>
                    <td class='grilla-tab-fila-campo' align='left'>
                        {$arrRegistros[registros].Observacion}
                    </td>
                {/if}
           
            </tr>
    {/section}
    <tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
            <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divabonos');" width="32"></a>
    
        </td>
    </tr>
    </table>
</div>