<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo" colspan="16" align='left' style="font-size: 8px !important; border: 0px">{$nombre}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" colspan="16" align='left' style="font-size: 8px !important; border: 0px">{$rut}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" colspan="16" align='left' style="font-size: 8px !important; border: 0px">{$direccion}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" colspan="16" align='left' style="font-size: 8px !important; border: 0px">{$ciudad}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" colspan="16" align='center' style="font-size: 8px !important; border: 0px">REGISTRO MATRICULA DE ALUMNOS PERIODO {$anio}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Numero de Matricula</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">R.U.N.</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Identificacion del alumno</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Sexo</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Fecha de Nacimiento</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important; width:5%" >Curso</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Local Escolar</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Fecha de matricula</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Domicilio del alumno</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Nombre de los Padres y/o Apoderados</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Telefono Apoderado</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Fecha Retiro</td>
        <td class="grilla-tab-fila-titulo" align='center' style="font-size: 8px !important">Motivo Retiro - Observacion</td>
    </tr>
    {section name=registros loop=$arrRegistros}
            <tr> 
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important; width:5%">{$arrRegistros[registros].NroMatricula}</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important; width:5%">{$arrRegistros[registros].NumeroRutAlumno}</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important">{$arrRegistros[registros].alumno}</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important">{$arrRegistros[registros].SexoAlumno}</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important">{$arrRegistros[registros].FechaNacimiento}</td>
                <td class="grilla-tab-fila-campo" align='center' style="font-size: 8px !important">{$arrRegistros[registros].NombreCurso}</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important">Principal</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important">{$arrRegistros[registros].Fecha}</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important">{$arrRegistros[registros].DireccionParticularAlumno}</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important">{$arrRegistros[registros].apoderado}</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important">{$arrRegistros[registros].TelefonoParticularApoderado}</td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important">
                    {if $arrRegistros[registros].FechaRetiro=='00/00/0000'}
                    {else}
                        {$arrRegistros[registros].FechaRetiro}
                    {/if}
                </td>
                <td class="grilla-tab-fila-campo" align='left' style="font-size: 8px !important">{$arrRegistros[registros].MotivoRetiro}</td>
                
            </tr>
    {/section}
<tr>
        <td colspan='16' class="grilla-tab-fila-titulo">
             <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divresultado');" width="32"></a>
    
        </td>
    </tr>
</table>
</div>
