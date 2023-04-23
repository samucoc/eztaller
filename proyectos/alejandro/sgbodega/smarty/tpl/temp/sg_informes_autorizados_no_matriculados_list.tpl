<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo" colspan="16" align='center' style="font-size: 8px !important; border: 0px">REGISTRO ALUMNOS AUTORIZADOS NO MATRICULADOS PERIODO {$anio}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Numero de Orden</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Identificacion del alumno</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Curso</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Nombre de los Padres y/o Apoderados</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Telefono Apoderado</td>
    </tr>
    {section name=registros loop=$arrRegistros}
            <tr> 
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important; width:5%">{$arrRegistros[registros].NroMatricula}</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important">{$arrRegistros[registros].alumno}</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important">{$arrRegistros[registros].NombreCurso}</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important">{$arrRegistros[registros].apoderado}</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important">{$arrRegistros[registros].TelefonoParticularApoderado}</td>
            </tr>
    {/section}
<tr>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Total</td>
        <td colspan='16' class="grilla-tab-fila-campo">
            {$total_alumnos}
        </td>
    </tr>
<tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
             <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divresultado');" width="32"></a>
    
        </td>
    </tr>
</table>
</div>
