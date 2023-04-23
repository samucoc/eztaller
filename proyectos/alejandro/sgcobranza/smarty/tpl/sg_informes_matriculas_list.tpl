<div id="pivot">										

<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo" align='center'>Nro Matricula</td>
        <td class="grilla-tab-fila-titulo" align='center'>Rut Alumno</td>
        <td class="grilla-tab-fila-titulo" align='center'>Alumno</td>
        <td class="grilla-tab-fila-titulo" align='center'>Sexo</td>
        <td class="grilla-tab-fila-titulo" align='center'>Fecha Nacimiento</td>
        <td class="grilla-tab-fila-titulo" align='center'>Curso</td>
        <td class="grilla-tab-fila-titulo" align='center'>Fecha Matricula</td>
        <td class="grilla-tab-fila-titulo" align='center'>Direccion Alumno</td>
        <td class="grilla-tab-fila-titulo" align='center'>Apoderado</td>
        <td class="grilla-tab-fila-titulo" align='center'>Telefono Apoderado</td>
    </tr>
    {section name=registros loop=$arrRegistros}
            <tr> 
                <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].NroMatricula}</td>
                <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].NumeroRutAlumno}</td>
                <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].alumno}</td>
                <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].SexoAlumno}</td>
                <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].FechaNacimiento}</td>
                <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].NombreCurso}</td>
                <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].Fecha}</td>
                <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].DireccionParticularAlumno}</td>
                <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].apoderado}</td>
                <td class="grilla-tab-fila-campo" align='left'>{$arrRegistros[registros].TelefonoParticularApoderado}</td>
            </tr>
    {/section}
<tr>
	<td colspan='16' class="grilla-tab-fila-titulo">
        <input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv(divresultado);">
	</td>
</tr>
</table>
</div>
