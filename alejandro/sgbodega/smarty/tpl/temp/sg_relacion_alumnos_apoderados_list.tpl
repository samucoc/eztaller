<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr >
            <td class='grilla-tab-fila-campo' align='center'>
                Nombre Curso
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Rut Alumno
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Nombre Alumno
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Rut Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Email Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Telefono Particular Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Telefono Movil Apoderado
            </td>
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].NombreCurso}
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].NumeroRutAlumno}
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].alumno}
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].NumeroRutApoderado}
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].apoderado}
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].EmailApoderado}
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].TelefonoParticularApoderado}
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].TelefonoMovilApoderado}
            </td>
	    </tr>
    {/section}
    </table>
</div>