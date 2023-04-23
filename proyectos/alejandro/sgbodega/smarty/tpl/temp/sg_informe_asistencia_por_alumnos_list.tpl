<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	  <tr>
        <td colspan='16' class="grilla-tab-fila-titulo" align="center">
            Inasistencias y Atrasos por Alumno
        </td>
        </tr>
        {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            {if (($arrRegistros[registros].FechaInasistencia=='Inasistencias')||($arrRegistros[registros].FechaInasistencia=='Atrasos'))}
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold; width: 15%" >
                        {if ($arrRegistros[registros].item == 'Total Inasistencias')||
                            ($arrRegistros[registros].item == 'Total Atrasos')||
                            ($arrRegistros[registros].item == 'Total Dias Trabajados Nominal')||
                            ($arrRegistros[registros].item == '% Asistencia Nominal')}
                            {$arrRegistros[registros].item}
                        {else}
                            {if $arrRegistros[registros].FechaInasistencia=='Atrasos' || $arrRegistros[registros].FechaInasistencia=='Inasistencias'}

                            {else}
                                {$arrRegistros[registros].item}
                            {/if}
                        {/if}
                    </td>
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        {$arrRegistros[registros].FechaInasistencia}
                    </td>
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        Observaci&oacute;n
                    </td>
                {else}
                    <td class='grilla-tab-fila-campo' align='center' style="font-weight: bold" >
                        {if ($arrRegistros[registros].item == 'Total Inasistencias')||
                            ($arrRegistros[registros].item == 'Total Atrasos')||
                            ($arrRegistros[registros].item == 'Total Dias Trabajados Nominal')||
                            ($arrRegistros[registros].item == '% Asistencia Nominal')}
                            {$arrRegistros[registros].item}
                        {else}
                            {if $arrRegistros[registros].FechaInasistencia=='Atrasos' || $arrRegistros[registros].FechaInasistencia=='Inasistencias'}

                            {else}
                                {$arrRegistros[registros].item}
                            {/if}
                        {/if}
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
            <a href="#" style="cursor: hand;"><img src="../images/basicos/email2.png" border=0 title="Enviar Correo Apoderado" onclick="xajax_EnivarPDF(xajax.getFormValues('Form1'));" width="32"></a>
        </td>
    </tr>
    </table>
</div>