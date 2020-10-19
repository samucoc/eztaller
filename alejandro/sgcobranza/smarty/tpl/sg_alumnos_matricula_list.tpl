<div id='pivot'>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
         <td class='grilla-tab-fila-titulo' align='left'>
               Curso:
            </td>
         <td class='grilla-tab-fila-campo' align='left'>
                {$nombre_curso}
            </td>
            <td class='grilla-tab-fila-titulo' align='left'>
                Profesor:
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                {$nombre_profe}
            </td>
    </tr>
    <tr>
            <td class='grilla-tab-fila-titulo' align='left'>
                Total de Alumnos:
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                {$total}
            </td>
    </tr>
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
            <td class='grilla-tab-fila-titulo' align='left' style="width: 16%">
                Matriculados:
            </td>
            <td class='grilla-tab-fila-campo' align='left' style="width: 16%">
                {$matriculados}
            </td>
            <td class='grilla-tab-fila-titulo' align='left' style="width: 16%">
                No Matriculados:
            </td>
            <td class='grilla-tab-fila-campo' align='left' style="width: 16%">
                {$no_matriculados}
            </td>
            <td class='grilla-tab-fila-titulo' align='left' style="width: 16%">
                Retirados:
            </td>
            <td class='grilla-tab-fila-campo' align='left' style="width: 16%">
                {$retirados}
            </td>
    </tr>
    </table>
    <table id='tabla' class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="grilla-tab-fila-titulo" align="center">Nro Lista</td>
        <td class="grilla-tab-fila-titulo" align="center">Rut Alumno</td>
        <td class="grilla-tab-fila-titulo" align="center">Nombre Alumno</td>
        <td class="grilla-tab-fila-titulo" align="center">Sexo</td>
        <td class="grilla-tab-fila-titulo" align="center">Fecha Nacimiento</td>
        <td class="grilla-tab-fila-titulo" align="center">Matriculado</td>
        <td class="grilla-tab-fila-titulo" align="center">Eliminar Matricular</td>
    </tr>
    {section name=registros loop=$arrRegistros}
        <tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
            <td class='grilla-tab-fila-campo' align='center'>
                {$arrRegistros[registros].nro_lista}
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                {$arrRegistros[registros].rut_alumno}
            </td>
            <td class='grilla-tab-fila-campo' align='left'>
                {$arrRegistros[registros].nombre_alumno}
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                {if $arrRegistros[registros].sexo_alumno == 0}
					Masculino
				{else}
					Femenino
				{/if}
            </td>
            <td class='grilla-tab-fila-campo' align='center'>
                {$arrRegistros[registros].fecha_nacimiento|date_format:"%d/%m/%Y"}
            </td>
            {if $arrRegistros[registros].matriculado == '1' } 
                <td class='grilla-tab-fila-campo' align='center'> 
                    <img src='../images/tick.png' width='24' title='Ver Cartola' onclick="xajax_Enviar(xajax.getFormValues('Form1'),'{$arrRegistros[registros].rut_alumno}','{$arrRegistros[registros].matriculado}')"/>
                </td>
                <td class='grilla-tab-fila-campo' align='center'>
                    <img src='../images/stop.png' width='24' title='Eliminar Matricular' onclick="xajax_VolverMatricular(xajax.getFormValues('Form1'),'{$arrRegistros[registros].rut_alumno}')"/>
                </td>
            {else}
                <td class='grilla-tab-fila-campo' align='center'>
                    <img src='../images/stop.png' width='24' 
                        {if $arrRegistros[registros].matriculado == '2'}
                            title='Retirado'
                        {else}
                             title='No Matriculado'
                        {/if}
                     onclick="xajax_Enviar(xajax.getFormValues('Form1'),'{$arrRegistros[registros].rut_alumno}','{$arrRegistros[registros].matriculado}')"/>
                    {if $arrRegistros[registros].condicional == '1'}
                        ?
                    {/if}
                    {if $arrRegistros[registros].matriculado == '2'}
                        !
                    {/if}
                </td>
                <td class='grilla-tab-fila-campo' align='center'>
                        ----
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