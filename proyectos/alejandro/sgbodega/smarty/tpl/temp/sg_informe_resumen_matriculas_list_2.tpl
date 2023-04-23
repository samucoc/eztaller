<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important;  font-weight: bold" colspan="6">INFORME RESUMEN MATRICULAS VIGENTES</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important">Nombre Curso</td>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important">Capacidad</td>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important">Alumnos Antiguos</td>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important">Alumnos Nuevos</td>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important">Cantidad de Alumnos</td>
        <td class="grilla-tab-fila-titulo" align='center' style="width: 10% !important">Vacantes</td>
    </tr>
</table>
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%" style="overflow: scroll; height: 600px !important;">

    {section name=registros loop=$arrRegistros}
            <tr {if ($arrRegistros[registros].NombreCurso == 'Totales Matricula Antiguos') || ($arrRegistros[registros].NombreCurso == 'Totales Matricula Nuevos') || ($arrRegistros[registros].NombreCurso == 'Total General')} 
                    style="background-color: #1B4978 !important;"
                {else} 
                    onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'
                {/if}>
                <td class="grilla-tab-fila-campo" align='left' style="width: 10% !important;
                     {if ($arrRegistros[registros].NombreCurso == 'Totales Matricula Antiguos') || ($arrRegistros[registros].NombreCurso == 'Totales Matricula Nuevos') || ($arrRegistros[registros].NombreCurso == 'Total General')} 
                     color: white;
                     {/if}
                ">{$arrRegistros[registros].NombreCurso}</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 10% !important;
                     {if ($arrRegistros[registros].NombreCurso == 'Totales Matricula Antiguos') || ($arrRegistros[registros].NombreCurso == 'Totales Matricula Nuevos') || ($arrRegistros[registros].NombreCurso == 'Total General')} 
                     color: white;
                     {/if}
                ">{$arrRegistros[registros].Capacidad}</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 10% !important;
                    {if ($arrRegistros[registros].NombreCurso == 'Totales Matricula Antiguos') || ($arrRegistros[registros].NombreCurso == 'Totales Matricula Nuevos') || ($arrRegistros[registros].NombreCurso == 'Total General')} 
                     color: white;
                     {/if}">{$arrRegistros[registros].anio_actual}</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 10% !important;
                    {if ($arrRegistros[registros].NombreCurso == 'Totales Matricula Antiguos') || ($arrRegistros[registros].NombreCurso == 'Totales Matricula Nuevos') || ($arrRegistros[registros].NombreCurso == 'Total General')} 
                     color: white;
                    {/if}">{$arrRegistros[registros].anio_siguiente}</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 10% !important;
                    {if ($arrRegistros[registros].NombreCurso == 'Totales Matricula Antiguos') || ($arrRegistros[registros].NombreCurso == 'Totales Matricula Nuevos') || ($arrRegistros[registros].NombreCurso == 'Total General')} 
                     color: white;
                    {/if}">{$arrRegistros[registros].cantidad_alumnos}</td>
                <td class="grilla-tab-fila-campo" align='center' style="width: 10% !important;
                    {if ($arrRegistros[registros].NombreCurso == 'Totales Matricula Antiguos') || ($arrRegistros[registros].NombreCurso == 'Totales Matricula Nuevos') || ($arrRegistros[registros].NombreCurso == 'Total General')} 
                     color: white;
                    {/if}">{$arrRegistros[registros].disponible}</td>
            </tr>
    {/section}
<tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
             <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divresultado');" width="32"></a>
    
        </td>
    </tr>
</table>
</div>
