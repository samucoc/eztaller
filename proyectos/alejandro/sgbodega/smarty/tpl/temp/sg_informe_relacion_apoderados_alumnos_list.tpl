<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr >
            <td class='grilla-tab-fila-campo' align='center'>
                Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Telefono Particular Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Telefono Movil Apoderado
            </td>
           <td class='grilla-tab-fila-campo' align='center'>
                Alumno
            </td>
           <td class='grilla-tab-fila-campo' align='center'>
                Nombre Curso
            </td>
           
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].apoderado}
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].TelefonoParticularApoderado}
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].TelefonoMovilApoderado}
            </td>
           <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].alumno}
            </td>
           <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].NombreCurso}
            </td>
           
	    </tr>
    {/section}
    <tr>
        <td  class="grilla-tab-fila-titulo">
            Cantidad Apoderados
        </td>
        <td colspan="16" class="grilla-tab-fila-titulo">
            {$apoderados}
        </td>
    </tr>
    <tr>
        <td  class="grilla-tab-fila-titulo">
            Cantidad Alumnos
        </td>
        <td colspan="16" class="grilla-tab-fila-titulo">
            {$alumnos}
        </td>
    </tr>
    </table>
</div>