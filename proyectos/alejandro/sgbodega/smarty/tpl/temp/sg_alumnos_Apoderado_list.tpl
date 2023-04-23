<div id='pivot'>
	<table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
   	<tr>
    	<td class="grilla-tab-fila-titulo" align="left">Alumno</td>
    	<td class="grilla-tab-fila-titulo" colspan="6" align="left" style="font-weight: bold">{$nombre_alumno}</td>
    </tr>
    <tr>
        <td class="grilla-tab-fila-titulo" align="left">Curso</td>
        <td class="grilla-tab-fila-titulo" colspan="6" align="left" style="font-weight: bold">{$nombre_curso}</td>
    </tr>
    <tr >
            <td class='grilla-tab-fila-campo' align='center'>
                Nombre Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Tipo Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Direccion Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Tel&eacute;fono Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                M&oacute;vil Apoderado
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                Correo Apoderado
            </td>
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" style="cursor: hand;" onclick="xajax_TraerApoderado(xajax.getFormValues('Form1'), '{$arrRegistros[registros].RutApoderado}', '{$arrRegistros[registros].RutAlumno}');" >{$arrRegistros[registros].nombre_apoderado}</a>
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" style="cursor: hand;" onclick="xajax_TraerApoderado(xajax.getFormValues('Form1'), '{$arrRegistros[registros].RutApoderado}', '{$arrRegistros[registros].RutAlumno}');" >{$arrRegistros[registros].tipo_apoderado}</a>

                
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" style="cursor: hand;" onclick="xajax_TraerApoderado(xajax.getFormValues('Form1'), '{$arrRegistros[registros].RutApoderado}', '{$arrRegistros[registros].RutAlumno}');" >{$arrRegistros[registros].direcc_apoderado}</a>
                
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" style="cursor: hand;" onclick="xajax_TraerApoderado(xajax.getFormValues('Form1'), '{$arrRegistros[registros].RutApoderado}', '{$arrRegistros[registros].RutAlumno}');" >{$arrRegistros[registros].telefono_apoderado}</a>
                
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="#" style="cursor: hand;" onclick="xajax_TraerApoderado(xajax.getFormValues('Form1'), '{$arrRegistros[registros].RutApoderado}', '{$arrRegistros[registros].RutAlumno}');" >{$arrRegistros[registros].movil_apoderado}</a>
                
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                <a href="mailto:{$arrRegistros[registros].correo_apoderado}">{$arrRegistros[registros].correo_apoderado}</a>
            </td>

            <td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
                <a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminaApoderado(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
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